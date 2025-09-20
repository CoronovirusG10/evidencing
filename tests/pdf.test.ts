import assert from 'assert';
import { generateStatementPdf } from '../lib/pdf';
import { buildStatementLines, computeStatementSummary } from '../lib/transactions';

interface StatementTransaction {
  id: string;
  name: string;
  amount: number;
  date: string;
  direction?: 'credit' | 'debit';
  type?: string;
  category?: string;
  bankId?: string;
  $id?: string;
  $createdAt?: string;
}

(() => {
  const transactions: StatementTransaction[] = [
    { id: '1', name: 'Salary', amount: 2500, date: '2025-01-01', direction: 'credit' },
    { id: '2', name: 'Coffee', amount: -4.5, date: '2025-01-02', direction: 'debit' },
  ];

  const summary = computeStatementSummary(transactions as any, 2495.5);
  const lines = buildStatementLines(transactions as any, summary, {
    accountName: 'Premium Checking',
    officialName: 'Horizon Private Bank',
    period: { from: '2025-01-01', to: '2025-01-31' },
    direction: 'all',
  });

  assert.ok(lines.length > 5, 'Statement lines should include summary + entries');

  const pdf = generateStatementPdf({ lines });
  assert.ok(Buffer.isBuffer(pdf), 'PDF generator should return a buffer');
  assert.ok(pdf.byteLength > 100, 'PDF buffer should contain content');
})();
