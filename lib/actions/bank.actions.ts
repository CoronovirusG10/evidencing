"use server";

import {
  CountryCode,
  TransferAuthorizationCreateRequest,
  TransferCreateRequest,
} from "plaid";

import { plaidClient } from "../plaid";
import { parseStringify } from "../utils";
import { isPlaidEnabled } from "../feature-flags";

import { getTransactionsByBankId, upsertPlaidTransactions } from "./transaction.actions";
import { getBanks, getBank } from "./user.actions";

const mapStoredTransaction = (transaction: Transaction) => ({
  id: transaction.id,
  name: transaction.name,
  amount: transaction.amount,
  date: transaction.date,
  paymentChannel: transaction.paymentChannel,
  category: transaction.category,
  type: transaction.type || transaction.direction,
});

const buildFallbackAccount = (bank: Bank) => {
  const shareableId = (bank as any).shareableId || (bank as any).sharaebleId;
  const maskSource = bank.accountId || shareableId || bank.$id;
  const mask = maskSource ? maskSource.slice(-4) : "0000";

  return {
    id: bank.accountId || bank.$id,
    availableBalance: 0,
    currentBalance: 0,
    institutionId: bank.bankId || "manual",
    name: `Manual Account ${mask}`,
    officialName: bank.bankId || "Manual Account",
    mask,
    type: "manual",
    subtype: "manual",
    appwriteItemId: bank.$id,
    sharaebleId: shareableId,
  };
};

// Get multiple bank accounts
export const getAccounts = async ({ userId }: getAccountsProps) => {
  try {
    const banks = await getBanks({ userId });

    if (!isPlaidEnabled()) {
      const accounts = banks?.map(buildFallbackAccount) ?? [];

      return parseStringify({
        data: accounts,
        totalBanks: accounts.length,
        totalCurrentBalance: 0,
      });
    }

    const accounts = await Promise.all(
      banks?.map(async (bank: Bank) => {
        const accountsResponse = await plaidClient.accountsGet({
          access_token: bank.accessToken,
        });
        const accountData = accountsResponse.data.accounts[0];

        const institution = await getInstitution({
          institutionId: accountsResponse.data.item.institution_id!,
        });

        return {
          id: accountData.account_id,
          availableBalance: accountData.balances.available!,
          currentBalance: accountData.balances.current!,
          institutionId: institution.institution_id,
          name: accountData.name,
          officialName: accountData.official_name,
          mask: accountData.mask!,
          type: accountData.type as string,
          subtype: accountData.subtype! as string,
          appwriteItemId: bank.$id,
          sharaebleId: (bank as any).shareableId,
        };
      }) ?? []
    );

    const totalBanks = accounts.length;
    const totalCurrentBalance = accounts.reduce((total, account) => {
      return total + account.currentBalance;
    }, 0);

    return parseStringify({ data: accounts, totalBanks, totalCurrentBalance });
  } catch (error) {
    console.error("An error occurred while getting the accounts:", error);
  }
};

// Get one bank account
export const getAccount = async ({ appwriteItemId }: getAccountProps) => {
  try {
    const bank = await getBank({ documentId: appwriteItemId });

    const storedTransactionsData = await getTransactionsByBankId({
      bankId: bank.$id,
    });

    const storedTransactions = storedTransactionsData.documents
      .map(mapStoredTransaction)
      .sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime());

    if (!isPlaidEnabled()) {
      const account = buildFallbackAccount(bank);
      return parseStringify({
        data: account,
        transactions: storedTransactions,
      });
    }

    const accountsResponse = await plaidClient.accountsGet({
      access_token: bank.accessToken,
    });
    const accountData = accountsResponse.data.accounts[0];

    const userId = typeof bank.userId === "string" ? bank.userId : bank.userId?.$id;

    const plaidTransactions = await getTransactions({
      accessToken: bank?.accessToken,
    });

    if (userId) {
      await upsertPlaidTransactions(
        bank.$id,
        userId,
        plaidTransactions.map((transaction: any) => ({
          name: transaction.name,
          amount: transaction.amount,
          date: transaction.date,
          category: transaction.category,
          paymentChannel: transaction.paymentChannel,
          externalId: transaction.id,
          status: transaction.pending ? "pending" : "posted",
          accountId: transaction.accountId,
        }))
      );
    }

    const institution = await getInstitution({
      institutionId: accountsResponse.data.item.institution_id!,
    });

    const account = {
      id: accountData.account_id,
      availableBalance: accountData.balances.available!,
      currentBalance: accountData.balances.current!,
      institutionId: institution.institution_id,
      name: accountData.name,
      officialName: accountData.official_name,
      mask: accountData.mask!,
      type: accountData.type as string,
      subtype: accountData.subtype! as string,
      appwriteItemId: bank.$id,
    };

    return parseStringify({
      data: account,
      transactions: storedTransactions,
    });
  } catch (error) {
    console.error("An error occurred while getting the account:", error);
  }
};

// Get bank info
export const getInstitution = async ({
  institutionId,
}: getInstitutionProps) => {
  try {
    const institutionResponse = await plaidClient.institutionsGetById({
      institution_id: institutionId,
      country_codes: ["US"] as CountryCode[],
    });

    const intitution = institutionResponse.data.institution;

    return parseStringify(intitution);
  } catch (error) {
    console.error("An error occurred while getting the accounts:", error);
  }
};

// Get transactions
export const getTransactions = async ({
  accessToken,
}: getTransactionsProps) => {
  if (!isPlaidEnabled()) {
    return [];
  }

  let hasMore = true;
  let cursor: string | undefined;
  const transactions: any[] = [];

  try {
    while (hasMore) {
      const response = await plaidClient.transactionsSync({
        access_token: accessToken,
        cursor,
      });

      transactions.push(...response.data.added);
      cursor = response.data.next_cursor || undefined;
      hasMore = response.data.has_more;
    }

    return parseStringify(
      transactions.map((transaction) => {
        const direction = transaction.amount >= 0 ? "debit" : "credit";
        const signedAmount =
          direction === "debit"
            ? -Math.abs(transaction.amount)
            : Math.abs(transaction.amount);

        return {
          id: transaction.transaction_id,
          name: transaction.name,
          paymentChannel: transaction.payment_channel,
          type: direction,
          accountId: transaction.account_id,
          amount: signedAmount,
          pending: transaction.pending,
          category: transaction.category ? transaction.category[0] : "Uncategorized",
          date: transaction.date,
          image: transaction.logo_url,
        };
      })
    );
  } catch (error) {
    console.error("An error occurred while getting the accounts:", error);
  }
};

// dwolla functions remain unchanged below...

// Create Dwolla transfer authorization
export const createDwollaTransferAuthorization = async (
  transferAuthorization: TransferAuthorizationCreateRequest
) => {
  try {
    const response = await plaidClient.transferAuthorizationCreate(
      transferAuthorization
    );

    return parseStringify(response.data);
  } catch (error) {
    console.error("An error occurred during transfer authorization:", error);
  }
};

// Create Dwolla transfer
export const createDwollaTransfer = async (transfer: TransferCreateRequest) => {
  try {
    const response = await plaidClient.transferCreate(transfer);

    return parseStringify(response.data);
  } catch (error) {
    console.error("An error occurred while creating the transfer:", error);
  }
};
