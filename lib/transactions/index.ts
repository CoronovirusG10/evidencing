const formatDate = (value: string | Date) => {
  const date = value instanceof Date ? value : new Date(value);
  return date.toISOString().slice(0, 10);
};

export type TransactionFilters = {
  from?: string | null;
  to?: string | null;
  direction?: 'credit' | 'debit' | 'all' | null;
};

const toDateOnly = (value: string | Date) => {
  const date = value instanceof Date ? value : new Date(value);
  return new Date(date.getFullYear(), date.getMonth(), date.getDate());
};

export const filterTransactions = (
  transactions: Transaction[],
  filters: TransactionFilters
): Transaction[] => {
  if (!transactions?.length) return [];

  const { from, to, direction } = filters;

  const fromDate = from ? toDateOnly(from) : null;
  const toDate = to ? toDateOnly(to) : null;
  const normalizedDirection = direction && direction !== 'all' ? direction : null;

  return transactions.filter((transaction) => {
    const transactionDate = toDateOnly(transaction.date);

    if (fromDate && transactionDate < fromDate) {
      return false;
    }

    if (toDate && transactionDate > toDate) {
      return false;
    }

    if (normalizedDirection) {
      const txnDirection = transaction.direction || transaction.type;
      if (txnDirection !== normalizedDirection) {
        return false;
      }
    }

    return true;
  });
};

export const computeStatementSummary = (
  transactions: Transaction[],
  closingBalance: number
) => {
  const totalChange = transactions.reduce((sum, transaction) => sum + transaction.amount, 0);
  const totalCredits = transactions
    .filter((transaction) => transaction.amount > 0)
    .reduce((sum, transaction) => sum + transaction.amount, 0);
  const totalDebits = transactions
    .filter((transaction) => transaction.amount < 0)
    .reduce((sum, transaction) => sum + Math.abs(transaction.amount), 0);

  const openingBalance = closingBalance - totalChange;

  return {
    totalCredits,
    totalDebits,
    netChange: totalChange,
    openingBalance,
    closingBalance,
  };
};

const escapeCsvValue = (value: string | number | null | undefined) => {
  if (value === null || value === undefined) return '';

  const stringValue = String(value);
  if (/[",\n]/.test(stringValue)) {
    return `"${stringValue.replace(/"/g, '""')}"`;
  }

  return stringValue;
};

export const toCsv = (
  transactions: Transaction[],
  options: {
    accountName: string;
    bankId: string;
    filters: TransactionFilters;
  }
) => {
  const { accountName, bankId, filters } = options;
  const headerLines = [
    ['Account', accountName],
    ['Bank ID', bankId],
    ['From', filters.from ? formatDate(filters.from) : '—'],
    ['To', filters.to ? formatDate(filters.to) : '—'],
    ['Direction', filters.direction && filters.direction !== 'all' ? filters.direction : 'All'],
    [],
  ];

  const columns = ['Date', 'Description', 'Amount', 'Direction', 'Category', 'Payment Channel', 'Source'];

  const rows = transactions.map((transaction) => [
    formatDate(transaction.date),
    transaction.name,
    transaction.amount.toFixed(2),
    transaction.direction || transaction.type || '',
    transaction.category || '',
    transaction.paymentChannel || transaction.channel || '',
    transaction.source || '',
  ]);

  const csvLines = [
    ...headerLines.map((line) => line.map(escapeCsvValue).join(',')),
    columns.join(','),
    ...rows.map((row) => row.map(escapeCsvValue).join(',')),
  ];

  return csvLines.join('\n');
};

export const buildStatementLines = (
  transactions: Transaction[],
  summary: ReturnType<typeof computeStatementSummary>,
  options: {
    accountName: string;
    officialName?: string;
    period: { from: string; to: string };
    direction?: string | null;
  }
) => {
  const { accountName, officialName, period, direction } = options;

  const lines: string[] = [];
  lines.push(`Account: ${accountName}`);
  if (officialName) {
    lines.push(`Institution: ${officialName}`);
  }
  lines.push(`Statement Period: ${formatDate(period.from)} to ${formatDate(period.to)}`);
  if (direction && direction !== 'all') {
    lines.push(`Direction: ${direction}`);
  }
  lines.push(`Opening Balance: $${summary.openingBalance.toFixed(2)}`);
  lines.push(`Closing Balance: $${summary.closingBalance.toFixed(2)}`);
  lines.push(`Total Credits: $${summary.totalCredits.toFixed(2)}`);
  lines.push(`Total Debits: $${summary.totalDebits.toFixed(2)}`);
  lines.push('');
  lines.push('Date | Description | Amount | Direction | Category');

  transactions.forEach((transaction) => {
    const formattedDate = formatDate(transaction.date);
    const amount = transaction.amount.toFixed(2);
    const direction = transaction.direction || transaction.type || '';
    const category = transaction.category || '';
    lines.push(
      `${formattedDate} | ${transaction.name} | ${amount} | ${direction} | ${category}`
    );
  });

  return lines;
};
