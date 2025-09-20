import HeaderBox from '@/components/HeaderBox'
import { Pagination } from '@/components/Pagination';
import TransactionsTable from '@/components/TransactionsTable';
import { ManualTransactionSheet } from '@/components/ManualTransactionSheet';
import { TransactionFilters } from '@/components/TransactionFilters';
import { getAccount, getAccounts } from '@/lib/actions/bank.actions';
import { getLoggedInUser } from '@/lib/actions/user.actions';
import { filterTransactions } from '@/lib/transactions';
import { formatAmount } from '@/lib/utils';
import React from 'react'

const TransactionHistory = async ({ searchParams }:SearchParamProps) => {
  const currentPage = Number(searchParams.page as string) || 1;
  const loggedIn = await getLoggedInUser();
  const accounts = await getAccounts({ 
    userId: loggedIn.$id 
  })

  if(!accounts) return;
  
  const accountsData = accounts?.data;
  const appwriteItemId = (searchParams.id as string) || accountsData[0]?.appwriteItemId;

  const account = await getAccount({ appwriteItemId })

const filters = {
  from: searchParams.from as string | undefined,
  to: searchParams.to as string | undefined,
  direction: (searchParams.direction as string | undefined) || 'all',
};

const filteredTransactions = filterTransactions(account?.transactions || [], {
  from: filters.from,
  to: filters.to,
  direction: filters.direction as 'credit' | 'debit' | 'all',
});

const rowsPerPage = 10;
const totalPages = Math.ceil(filteredTransactions.length / rowsPerPage) || 1;

const indexOfLastTransaction = currentPage * rowsPerPage;
const indexOfFirstTransaction = indexOfLastTransaction - rowsPerPage;

const currentTransactions = filteredTransactions.slice(
  indexOfFirstTransaction, indexOfLastTransaction
);

const exportParams = new URLSearchParams({ bankId: appwriteItemId });
if (filters.from) exportParams.set('from', filters.from);
if (filters.to) exportParams.set('to', filters.to);
if (filters.direction && filters.direction !== 'all') exportParams.set('direction', filters.direction);

const exportUrl = `/api/transactions/export?${exportParams.toString()}`;
  return (
    <div className="transactions">
      <div className="transactions-header">
        <HeaderBox 
          title="Transaction History"
          subtext="See your bank details and transactions."
        />
      </div>

      <div className="space-y-6">
        <div className="transactions-account">
          <div className="flex flex-col gap-2">
            <h2 className="text-18 font-bold text-white">{account?.data.name}</h2>
            <p className="text-14 text-blue-25">
              {account?.data.officialName}
            </p>
            <p className="text-14 font-semibold tracking-[1.1px] text-white">
              ●●●● ●●●● ●●●● {account?.data.mask}
            </p>
          </div>
          
          <div className='transactions-account-balance'>
            <p className="text-14">Current balance</p>
            <p className="text-24 text-center font-bold">{formatAmount(account?.data.currentBalance)}</p>
          </div>
        </div>

        <TransactionFilters
          defaultValues={{
            bankId: appwriteItemId,
            from: filters.from,
            to: filters.to,
            direction: filters.direction,
          }}
          exportUrl={exportUrl}
        />

        <section className="flex w-full flex-col gap-6">
          <div className="flex justify-end">
            <ManualTransactionSheet accounts={accountsData} defaultBankId={appwriteItemId} />
          </div>
          <TransactionsTable 
            transactions={currentTransactions}
          />
            {totalPages > 1 && (
              <div className="my-4 w-full">
                <Pagination totalPages={totalPages} page={currentPage} />
              </div>
            )}
        </section>
      </div>
    </div>
  )
}

export default TransactionHistory
