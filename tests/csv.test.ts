import assert from 'assert';
import { toCsv, filterTransactions } from '../lib/transactions';

interface TestTransaction {
  id: string;
  $id: string;
  bankId: string;
  name: string;
  paymentChannel?: string;
  direction?: 'credit' | 'debit';
  amount: number;
  category?: string;
  date: string;
  source?: string;
  $createdAt: string;
}

const sampleTransactions: TestTransaction[] = [
  {
    id: 'txn-1',
    $id: 'txn-1',
    bankId: 'bank-1',
    name: 'Coffee Shop',
    paymentChannel: 'in_store',
    direction: 'debit',
    amount: -4.5,
    category: 'Food and Drink',
    date: '2025-01-10',
    source: 'manual',
    $createdAt: '2025-01-10T10:00:00Z',
  },
  {
    id: 'txn-2',
    $id: 'txn-2',
    bankId: 'bank-1',
    name: 'Salary',
    paymentChannel: 'direct_deposit',
    direction: 'credit',
    amount: 2500,
    category: 'Income',
    date: '2025-01-01',
    source: 'manual',
    $createdAt: '2025-01-01T09:00:00Z',
  },
];

(() => {
  const filtered = filterTransactions(sampleTransactions as any, {
    from: '2025-01-01',
    to: '2025-01-31',
    direction: 'credit',
  });

  assert.strictEqual(filtered.length, 1, 'filters should return only credit transactions');
  assert.strictEqual(filtered[0].name, 'Salary');

  const csv = toCsv(filtered as any, {
    accountName: 'Checking',
    bankId: 'bank-1',
    filters: { from: '2025-01-01', to: '2025-01-31', direction: 'credit' },
  });

  const lines = csv.trim().split('\n');
  assert.ok(lines[0].includes('Checking'), 'CSV should include account metadata');
  assert.ok(lines.some((line) => line.includes('Salary')), 'CSV should include transaction rows');
})();
