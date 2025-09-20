"use client";

import { useEffect, useMemo, useState } from "react";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { Loader2, Plus } from "lucide-react";

import {
  Sheet,
  SheetContent,
  SheetDescription,
  SheetFooter,
  SheetHeader,
  SheetTitle,
  SheetTrigger,
} from "@/components/ui/sheet";
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Textarea } from "@/components/ui/textarea";
import { Button } from "@/components/ui/button";
import { createManualTransaction } from "@/lib/actions/transaction.actions";

const manualTransactionSchema = z.object({
  bankId: z.string().min(1, "Select a bank account"),
  name: z.string().min(2, "Enter a description"),
  amount: z.coerce.number().positive("Amount must be greater than 0"),
  direction: z.enum(["credit", "debit"]),
  date: z.string().min(1, "Select a transaction date"),
  category: z.string().optional(),
  notes: z.string().max(280, "Notes must be under 280 characters").optional(),
});

type ManualTransactionFormValues = z.infer<typeof manualTransactionSchema>;

type ManualTransactionSheetProps = {
  accounts: Account[];
  defaultBankId?: string;
};

const CATEGORY_OPTIONS = [
  "General",
  "Dining",
  "Travel",
  "Housing",
  "Utilities",
  "Income",
  "Transfer",
  "Investment",
];

const getToday = () => new Date().toISOString().slice(0, 10);

export const ManualTransactionSheet = ({
  accounts,
  defaultBankId,
}: ManualTransactionSheetProps) => {
  const [open, setOpen] = useState(false);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const firstAccountId = useMemo(
    () => defaultBankId ?? accounts[0]?.appwriteItemId ?? "",
    [accounts, defaultBankId]
  );

  const form = useForm<ManualTransactionFormValues>({
    resolver: zodResolver(manualTransactionSchema),
    defaultValues: {
      bankId: firstAccountId,
      direction: "debit",
      date: getToday(),
      name: "",
      amount: 0,
      category: "General",
      notes: "",
    },
  });

  useEffect(() => {
    if (!open) return;
    if (defaultBankId) {
      form.setValue("bankId", defaultBankId);
    }
  }, [defaultBankId, form, open]);

  const resetForm = () => {
    form.reset({
      bankId: firstAccountId,
      direction: "debit",
      date: getToday(),
      name: "",
      amount: 0,
      category: "General",
      notes: "",
    });
    setError(null);
  };

  const onSubmit = async (values: ManualTransactionFormValues) => {
    setIsSubmitting(true);
    setError(null);

    try {
      await createManualTransaction({
        bankId: values.bankId,
        name: values.name,
        amount: values.amount,
        direction: values.direction,
        category: values.category,
        date: values.date,
        notes: values.notes,
      });

      resetForm();
      setOpen(false);
    } catch (err) {
      console.error(err);
      setError("Unable to save transaction. Please try again.");
    } finally {
      setIsSubmitting(false);
    }
  };

  const isDisabled = accounts.length === 0;

  return (
    <Sheet open={open} onOpenChange={(next) => {
      setOpen(next);
      if (next) {
        resetForm();
      }
    }}>
      <SheetTrigger asChild>
        <Button className="flex items-center gap-2" disabled={isDisabled} variant="outline">
          <Plus className="h-4 w-4" />
          Manual transaction
        </Button>
      </SheetTrigger>
      <SheetContent className="flex w-full flex-col gap-6 overflow-y-auto bg-white p-6 sm:max-w-lg">
        <SheetHeader className="items-start text-left">
          <SheetTitle>Add manual transaction</SheetTitle>
          <SheetDescription>
            Record manual credits or debits for the selected account. Saved entries immediately refresh your dashboard and history.
          </SheetDescription>
        </SheetHeader>

        <Form {...form}>
          <form onSubmit={form.handleSubmit(onSubmit)} className="flex flex-1 flex-col gap-5">
            <FormField
              control={form.control}
              name="bankId"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Account</FormLabel>
                  <FormControl>
                    <Select
                      onValueChange={field.onChange}
                      value={field.value}
                      disabled={isDisabled}
                    >
                      <SelectTrigger>
                        <SelectValue placeholder="Select account" />
                      </SelectTrigger>
                      <SelectContent>
                        {accounts.map((account) => (
                          <SelectItem key={account.appwriteItemId} value={account.appwriteItemId}>
                            {account.name} • {account.mask ? `••••${account.mask}` : account.appwriteItemId.slice(-4)}
                          </SelectItem>
                        ))}
                      </SelectContent>
                    </Select>
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={form.control}
              name="name"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Description</FormLabel>
                  <FormControl>
                    <Input placeholder="e.g. Office supplies" {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <FormField
                control={form.control}
                name="amount"
                render={({ field }) => {
                  const displayValue = field.value?.toString?.() ?? "";
                  return (
                    <FormItem>
                      <FormLabel>Amount (USD)</FormLabel>
                      <FormControl>
                        <Input
                          type="number"
                          step="0.01"
                          min="0"
                          placeholder="0.00"
                          value={displayValue === "0" ? "" : displayValue}
                          onChange={(event) => field.onChange(event.target.value)}
                        />
                      </FormControl>
                      <FormMessage />
                    </FormItem>
                  );
                }}
              />

              <FormField
                control={form.control}
                name="direction"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>Type</FormLabel>
                    <FormControl>
                      <Select onValueChange={field.onChange} value={field.value}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="debit">Debit (money out)</SelectItem>
                          <SelectItem value="credit">Credit (money in)</SelectItem>
                        </SelectContent>
                      </Select>
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />
            </div>

            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <FormField
                control={form.control}
                name="date"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>Date</FormLabel>
                    <FormControl>
                      <Input type="date" max={getToday()} {...field} />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />

              <FormField
                control={form.control}
                name="category"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>Category</FormLabel>
                    <FormControl>
                      <Select onValueChange={field.onChange} value={field.value ?? "General"}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          {CATEGORY_OPTIONS.map((category) => (
                            <SelectItem key={category} value={category}>
                              {category}
                            </SelectItem>
                          ))}
                        </SelectContent>
                      </Select>
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />
            </div>

            <FormField
              control={form.control}
              name="notes"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Notes</FormLabel>
                  <FormControl>
                    <Textarea
                      placeholder="Optional memo..."
                      className="resize-none"
                      {...field}
                    />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            {error && (
              <p className="text-sm text-red-500" role="alert">
                {error}
              </p>
            )}

            <SheetFooter className="mt-auto flex w-full justify-end gap-3 sm:justify-between">
              <Button
                type="button"
                variant="outline"
                onClick={() => {
                  resetForm();
                  setOpen(false);
                }}
              >
                Cancel
              </Button>
              <Button type="submit" disabled={isSubmitting || isDisabled}>
                {isSubmitting ? (
                  <>
                    <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                    Saving...
                  </>
                ) : (
                  "Save transaction"
                )}
              </Button>
            </SheetFooter>
          </form>
        </Form>
      </SheetContent>
    </Sheet>
  );
};
