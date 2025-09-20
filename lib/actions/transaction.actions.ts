"use server";

import { ID, Query } from "node-appwrite";
import { revalidatePath } from "next/cache";

import { createAdminClient, createSessionClient } from "../appwrite";
import { parseStringify } from "../utils";
import { getBank, getLoggedInUser } from "./user.actions";

const {
  APPWRITE_DATABASE_ID: DATABASE_ID,
  APPWRITE_TRANSACTION_COLLECTION_ID: TRANSACTION_COLLECTION_ID,
} = process.env;

const HYDRATE_PATHS = ["/", "/transaction-history", "/statements"] as const;

const clean = <T extends Record<string, unknown>>(data: T) => {
  const entries = Object.entries(data).filter(([, value]) =>
    value !== undefined && value !== null && value !== ""
  );
  return Object.fromEntries(entries) as T;
};

const coerceAmount = (
  amount: string | number,
  direction?: "credit" | "debit"
) => {
  const numeric = typeof amount === "number" ? amount : Number(amount);
  if (Number.isNaN(numeric)) {
    throw new Error("Invalid amount supplied for transaction");
  }

  if (direction === "debit") return numeric > 0 ? -numeric : numeric;
  if (direction === "credit") return Math.abs(numeric);
  return numeric;
};

const deriveDirection = (
  amount: number,
  direction?: "credit" | "debit"
): "credit" | "debit" => {
  if (direction) return direction;
  return amount < 0 ? "debit" : "credit";
};

const getDatabaseForRead = async () => {
  try {
    const { database } = await createSessionClient();
    return database;
  } catch (error) {
    const { database } = await createAdminClient();
    return database;
  }
};

const mapTransactionDocument = (document: any): Transaction => {
  const amountValue = typeof document.amount === "number"
    ? document.amount
    : Number(document.amount);

  const direction = document.direction || document.type || deriveDirection(amountValue);

  return {
    id: document.externalId || document.$id,
    $id: document.$id,
    bankId: document.bankId || document.senderBankId || document.receiverBankId,
    name: document.name,
    paymentChannel: document.paymentChannel || document.channel || "online",
    direction,
    type: direction,
    accountId: document.accountId,
    amount: Number.isNaN(amountValue) ? 0 : amountValue,
    pending: document.status ? document.status !== "posted" : document.pending,
    category: document.category || "Transfer",
    date: document.date || document.$createdAt,
    image: document.image,
    status: document.status || (document.pending ? "pending" : "posted"),
    source: document.source,
    externalId: document.externalId,
    notes: document.notes,
    $createdAt: document.$createdAt,
    channel: document.channel,
    senderBankId: document.senderBankId,
    receiverBankId: document.receiverBankId,
  };
};

const upsertTransactionDocument = async (
  payload: Record<string, unknown>
) => {
  const { database } = await createAdminClient();

  const externalId = payload.externalId as string | undefined;

  if (externalId) {
    const existing = await database.listDocuments(
      DATABASE_ID!,
      TRANSACTION_COLLECTION_ID!,
      [Query.equal("externalId", [externalId])]
    );

    if (existing.total > 0) {
      const document = existing.documents[0];
      const updated = await database.updateDocument(
        DATABASE_ID!,
        TRANSACTION_COLLECTION_ID!,
        document.$id,
        clean(payload)
      );
      return parseStringify(updated);
    }
  }

  const created = await database.createDocument(
    DATABASE_ID!,
    TRANSACTION_COLLECTION_ID!,
    ID.unique(),
    clean(payload)
  );

  return parseStringify(created);
};

export const createTransaction = async (
  transaction: CreateTransactionProps
) => {
  try {
    const amountValue = coerceAmount(transaction.amount, transaction.direction);
    const direction = deriveDirection(amountValue, transaction.direction);

    const bankId =
      transaction.bankId || transaction.senderBankId || transaction.receiverBankId;

    const payload = clean({
      name: transaction.name,
      amount: amountValue,
      direction,
      type: direction,
      category:
        transaction.category || (direction === "debit" ? "Transfer" : "Transfer"),
      paymentChannel: transaction.paymentChannel || transaction.channel || "online",
      channel: transaction.channel || transaction.paymentChannel || "online",
      status: transaction.status || "posted",
      source: transaction.source || "transfer",
      date: transaction.date || new Date().toISOString(),
      bankId,
      accountId: transaction.accountId,
      senderId: transaction.senderId,
      receiverId: transaction.receiverId,
      senderBankId: transaction.senderBankId || bankId,
      receiverBankId: transaction.receiverBankId || bankId,
      email: transaction.email,
      userId: transaction.userId,
      externalId: transaction.externalId,
      notes: transaction.notes,
      metadata: transaction.metadata,
    });

    const created = await upsertTransactionDocument(payload);
    return created;
  } catch (error) {
    console.log(error);
    throw error;
  }
};

export const getTransactionsByBankId = async (
  { bankId }: getTransactionsByBankIdProps
) => {
  try {
    const database = await getDatabaseForRead();

    const primary = await database.listDocuments(
      DATABASE_ID!,
      TRANSACTION_COLLECTION_ID!,
      [Query.equal("bankId", [bankId])]
    );

    let documents = primary.documents;

    if (!primary.total) {
      const sender = await database.listDocuments(
        DATABASE_ID!,
        TRANSACTION_COLLECTION_ID!,
        [Query.equal("senderBankId", [bankId])]
      );

      const receiver = await database.listDocuments(
        DATABASE_ID!,
        TRANSACTION_COLLECTION_ID!,
        [Query.equal("receiverBankId", [bankId])]
      );

      const mergedMap = new Map<string, any>();

      sender.documents.forEach((doc: any) => {
        mergedMap.set(doc.$id, doc);
      });

      receiver.documents.forEach((doc: any) => {
        mergedMap.set(doc.$id, doc);
      });

      documents = Array.from(mergedMap.values());
    }

    const mapped = documents
      .map(mapTransactionDocument)
      .sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime());

    return parseStringify({
      total: mapped.length,
      documents: mapped,
    });
  } catch (error) {
    console.log(error);
  }
};

export const createManualTransaction = async (
  input: CreateManualTransactionInput
) => {
  try {
    const user = await getLoggedInUser();
    if (!user) {
      throw new Error("You must be signed in to create a transaction");
    }

    const bank = await getBank({ documentId: input.bankId });
    if (!bank) {
      throw new Error("Bank account not found");
    }

    if (bank.userId !== user.$id && bank.userId?.$id !== user.$id) {
      throw new Error("You are not allowed to modify this bank account");
    }

    const amountValue = coerceAmount(input.amount, input.direction);
    const direction = deriveDirection(amountValue, input.direction);

    const payload: CreateTransactionProps = {
      name: input.name,
      amount: String(amountValue),
      bankId: bank.$id,
      userId: user.$id,
      senderId: user.$id,
      receiverId: user.$id,
      senderBankId: bank.$id,
      receiverBankId: bank.$id,
      source: "manual",
      direction,
      category: input.category || (direction === "debit" ? "Manual" : "Manual"),
      date: input.date,
      paymentChannel: "manual",
      status: "posted",
      notes: input.notes,
    };

    const created = await createTransaction(payload);

    HYDRATE_PATHS.forEach((path) => revalidatePath(path));

    return created;
  } catch (error) {
    console.error("Error creating manual transaction", error);
    throw error;
  }
};

export const upsertPlaidTransactions = async (
  bankId: string,
  userId: string,
  transactions: Array<{
    name: string;
    amount: number;
    date: string;
    category?: string;
    paymentChannel?: string;
    externalId: string;
    status?: string;
    accountId?: string;
  }>
) => {
  for (const transaction of transactions) {
    const payload: CreateTransactionProps = {
      name: transaction.name,
      amount: String(transaction.amount),
      bankId,
      userId,
      source: "plaid",
      direction: transaction.amount < 0 ? "debit" : "credit",
      category: transaction.category,
      date: transaction.date,
      paymentChannel: transaction.paymentChannel || "online",
      status: transaction.status || "posted",
      externalId: transaction.externalId,
      accountId: transaction.accountId,
    };

    await createTransaction(payload);
  }
};
