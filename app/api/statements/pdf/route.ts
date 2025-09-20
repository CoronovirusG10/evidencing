import { NextRequest, NextResponse } from 'next/server';

import { getAccount } from '@/lib/actions/bank.actions';
import { getBank, getLoggedInUser } from '@/lib/actions/user.actions';
import { generateStatementPdf } from '@/lib/pdf';
import { consumeRateLimit } from '@/lib/rate-limit';
import { buildStatementLines, computeStatementSummary, filterTransactions } from '@/lib/transactions';

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

  if (!bankId || !from || !to) {
    return NextResponse.json({ error: 'bankId, from, and to parameters are required' }, { status: 400 });
  }

  const user = await getLoggedInUser();
  if (!user) {
    return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
  }

  const bank = await getBank({ documentId: bankId });
  if (!bank) {
    return NextResponse.json({ error: 'Bank not found' }, { status: 404 });
  }

  const ownerId = typeof bank.userId === 'string' ? bank.userId : bank.userId?.$id;
  if (ownerId !== user.$id) {
    return NextResponse.json({ error: 'Forbidden' }, { status: 403 });
  }

  const account = await getAccount({ appwriteItemId: bankId });
  const transactions = account?.transactions || [];

  const rateKey = `${user.$id}:statement:${bankId}`;
  const rate = consumeRateLimit(rateKey, { limit: 5, window: 60_000 });

  if (!rate.success) {
    console.warn('[api/statements/pdf] rate limit exceeded', {
      userId: user.$id,
      bankId,
      reset: rate.reset,
    });

    return NextResponse.json(
      { error: 'Too many statement requests. Please try again shortly.' },
      {
        status: 429,
        headers: {
          'Retry-After': Math.max(Math.ceil((rate.reset - Date.now()) / 1000), 1).toString(),
        },
      }
    );
  }

  const filteredTransactions = filterTransactions(transactions, {
    from,
    to,
    direction: directionParam || 'all',
  });

  const summary = computeStatementSummary(filteredTransactions, account?.data?.currentBalance || 0);

  const lines = buildStatementLines(filteredTransactions, summary, {
    accountName: account?.data?.name || bankId,
    officialName: account?.data?.officialName,
    period: { from, to },
    direction: directionParam || 'all',
  });

  const pdfBuffer = generateStatementPdf({ lines });

  const filenameParts = [
    (account?.data?.name || 'statement').toLowerCase().replace(/[^a-z0-9]+/g, '-'),
    from,
    to,
  ];

  if (directionParam && directionParam !== 'all') {
    filenameParts.push(directionParam);
  }

  const filename = `${filenameParts.filter(Boolean).join('-')}.pdf`;

  console.info('[api/statements/pdf] generated statement', {
    userId: user.$id,
    bankId,
    from,
    to,
    remaining: rate.remaining,
  });

  return new NextResponse(pdfBuffer, {
    headers: {
      'Content-Type': 'application/pdf',
      'Content-Disposition': `attachment; filename="${filename}"`,
      'Cache-Control': 'no-store',
    },
  });
}
