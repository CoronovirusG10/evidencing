import HeaderBox from '@/components/HeaderBox';
import LegalBanner from '@/components/LegalBanner';
import TransactionsTable from '@/components/TransactionsTable';
import { ManualTransactionSheet } from '@/components/ManualTransactionSheet';
import { StatementFilters } from '@/components/StatementFilters';
import { getAccount, getAccounts } from '@/lib/actions/bank.actions';
import { getLoggedInUser } from '@/lib/actions/user.actions';
import { buildStatementLines, computeStatementSummary, filterTransactions } from '@/lib/transactions';

const getDefaultPeriod = () => {
  const now = new Date();
  const from = new Date(now.getFullYear(), now.getMonth(), 1);
  const to = new Date(now.getFullYear(), now.getMonth() + 1, 0);
  return {
    from: from.toISOString().slice(0, 10),
    to: to.toISOString().slice(0, 10),
  };
};

const buildUrl = (base: string, params: Record<string, string | undefined>) => {
  const search = new URLSearchParams();

  Object.entries(params).forEach(([key, value]) => {
    if (value) {
      search.set(key, value);
    }
  });

  return `${base}?${search.toString()}`;
};

export default async function StatementsPage({ searchParams }: SearchParamProps) {
  const loggedIn = await getLoggedInUser();
  if (!loggedIn) return null;

  const accounts = await getAccounts({ userId: loggedIn.$id });
  if (!accounts?.data?.length) {
    return (
      <div className="transactions">
        <HeaderBox title="Statements" subtext="No accounts available." />
      </div>
    );
  }

  const defaultPeriod = getDefaultPeriod();
  const bankId = (searchParams.id as string) || accounts.data[0].appwriteItemId;
  const period = {
    from: (searchParams.from as string) || defaultPeriod.from,
    to: (searchParams.to as string) || defaultPeriod.to,
  };
  const direction = (searchParams.direction as string) || 'all';

  const account = await getAccount({ appwriteItemId: bankId });
  const transactions = account?.transactions || [];

  const filteredTransactions = filterTransactions(transactions, {
    from: period.from,
    to: period.to,
    direction: direction as 'credit' | 'debit' | 'all',
  });

  const orderedTransactions = filteredTransactions.slice().sort((a, b) =>
    new Date(a.date).getTime() - new Date(b.date).getTime()
  );

  const summary = computeStatementSummary(
    orderedTransactions,
    account?.data?.currentBalance || 0
  );

  const pdfUrl = buildUrl('/api/statements/pdf', {
    bankId,
    from: period.from,
    to: period.to,
    direction: direction !== 'all' ? direction : undefined,
  });

  const csvUrl = buildUrl('/api/transactions/export', {
    bankId,
    from: period.from,
    to: period.to,
    direction: direction !== 'all' ? direction : undefined,
  });

  const statementPreview = buildStatementLines(orderedTransactions, summary, {
    accountName: account?.data?.name || bankId,
    officialName: account?.data?.officialName,
    period,
    direction,
  });

  return (
    <div className="transactions">
      <div className="transactions-header">
        <HeaderBox
          title="Account Statements"
          subtext="Review period summaries, download PDFs, or export CSVs."
        />
      </div>

      <section className="space-y-6">
        <LegalBanner />

        <div className="flex flex-wrap items-center justify-between gap-3">
          <StatementFilters
            accounts={accounts.data}
            defaultValues={{
              bankId,
              from: period.from,
              to: period.to,
              direction,
            }}
            downloadLinks={{ pdf: pdfUrl, csv: csvUrl }}
          />

          <ManualTransactionSheet accounts={accounts.data} defaultBankId={bankId} />
        </div>

        <div className="grid gap-4 rounded-2xl bg-white p-6 shadow-sm md:grid-cols-3">
          <div>
            <p className="text-sm text-gray-500">Opening Balance</p>
            <p className="text-2xl font-semibold">${summary.openingBalance.toFixed(2)}</p>
          </div>
          <div>
            <p className="text-sm text-gray-500">Closing Balance</p>
            <p className="text-2xl font-semibold">${summary.closingBalance.toFixed(2)}</p>
          </div>
          <div>
            <p className="text-sm text-gray-500">Net Change</p>
            <p className={`text-2xl font-semibold ${summary.netChange >= 0 ? 'text-emerald-600' : 'text-rose-600'}`}>
              ${summary.netChange.toFixed(2)}
            </p>
          </div>
          <div>
            <p className="text-sm text-gray-500">Total Credits</p>
            <p className="text-xl font-medium text-emerald-600">${summary.totalCredits.toFixed(2)}</p>
          </div>
          <div>
            <p className="text-sm text-gray-500">Total Debits</p>
            <p className="text-xl font-medium text-rose-600">-${summary.totalDebits.toFixed(2)}</p>
          </div>
        </div>

        <div className="space-y-4 rounded-2xl bg-white p-6 shadow-sm">
          <h3 className="text-lg font-semibold text-gray-900">Statement Preview</h3>
          <p className="text-sm text-gray-500">
            Preview the data included in your PDF download.
          </p>
          <div className="max-h-64 overflow-y-auto rounded border border-gray-200 bg-gray-50 p-4 text-sm font-mono">
            {statementPreview.map((line, index) => (
              <p key={`${line}-${index}`} className="whitespace-pre">
                {line}
              </p>
            ))}
          </div>
        </div>

        <section className="space-y-4">
          <h3 className="text-lg font-semibold text-gray-900">Transactions</h3>
          <TransactionsTable transactions={orderedTransactions} />
        </section>
      </section>
    </div>
  );
}
