import { NextRequest, NextResponse } from 'next/server';

import { getBank } from '@/lib/actions/user.actions';
import { getTransactionsByBankId } from '@/lib/actions/transaction.actions';
import { getLoggedInUser } from '@/lib/actions/user.actions';
import { consumeRateLimit } from '@/lib/rate-limit';
import { filterTransactions, toCsv } from '@/lib/transactions';

const buildFilename = (accountName: string, from?: string | null, to?: string | null) => {
  const safeName = accountName.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
  const parts = [safeName || 'transactions'];
  if (from) parts.push(from);
  if (to) parts.push(to);
  return `${parts.join('-') || 'transactions'}.csv`;
};

export async function GET(request: NextRequest) {
  const url = new URL(request.url);
  const bankId = url.searchParams.get('bankId');
  const from = url.searchParams.get('from');
  const to = url.searchParams.get('to');
  const directionParam = url.searchParams.get('direction') as
    | 'credit'
    | 'debit'
    | 'all'
    | null;

  if (!bankId) {
    return NextResponse.json({ error: 'bankId is required' }, { status: 400 });
  }

  const user = await getLoggedInUser();
  if (!user) {
    return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
  }

  const bank = await getBank({ documentId: bankId });
  if (!bank) {
    return NextResponse.json({ error: 'Bank not found' }, { status: 404 });
  }

  const bankOwnerId = typeof bank.userId === 'string' ? bank.userId : bank.userId?.$id;
  if (bankOwnerId !== user.$id) {
    return NextResponse.json({ error: 'Forbidden' }, { status: 403 });
  }

  const rateLimitKey = `${user.$id}:export:${bankId}`;
  const rate = consumeRateLimit(rateLimitKey, { limit: 5, window: 60_000 });

  if (!rate.success) {
    console.warn('[api/export] rate limit exceeded', {
      userId: user.$id,
      bankId,
      reset: rate.reset,
    });

    return new NextResponse(JSON.stringify({
      error: 'Too many export requests. Please try again shortly.',
    }), {
      status: 429,
      headers: {
        'Content-Type': 'application/json',
        'Retry-After': Math.max(Math.ceil((rate.reset - Date.now()) / 1000), 1).toString(),
      },
    });
  }

  const result = await getTransactionsByBankId({ bankId });
  const transactions = result?.documents ?? [];

  const filtered = filterTransactions(transactions, {
    from,
    to,
    direction: directionParam || 'all',
  });

  const accountName = bank.bankId || bank.accountId || bankId;

  const csv = toCsv(filtered, {
    accountName,
    bankId,
    filters: {
      from,
      to,
      direction: directionParam || 'all',
    },
  });

  const filename = buildFilename(accountName, from, to);

  console.info('[api/export] generated csv', {
    userId: user.$id,
    bankId,
    remaining: rate.remaining,
  });

  return new NextResponse(csv, {
    headers: {
      'Content-Type': 'text/csv; charset=utf-8',
      'Content-Disposition': `attachment; filename="${filename}"`,
      'Cache-Control': 'no-store',
    },
  });
}
