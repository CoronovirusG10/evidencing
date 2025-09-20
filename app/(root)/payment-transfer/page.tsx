import HeaderBox from '@/components/HeaderBox';
import PaymentTransferForm from '@/components/PaymentTransferForm';
import { getAccounts } from '@/lib/actions/bank.actions';
import { getLoggedInUser } from '@/lib/actions/user.actions';
import { isTransfersEnabled } from '@/lib/feature-flags';
import Link from 'next/link';
import React from 'react';

const Transfer = async () => {
  const loggedIn = await getLoggedInUser();

  if (!isTransfersEnabled()) {
    return (
      <section className="payment-transfer">
        <HeaderBox
          title="Transfers Unavailable"
          subtext="Automated transfers are disabled for this environment."
        />

        <div className="mt-6 rounded-2xl bg-white p-6 text-sm text-gray-600 shadow-subtle">
          <p>
            Dwolla-powered transfers are currently turned off. You can still track movement by recording manual transactions from the dashboard or statements page.
          </p>
          <p className="mt-4">
            Need to enable transfers? Update the <code>NEXT_PUBLIC_ENABLE_TRANSFERS</code> flag and redeploy. Manual entries remain available under the{' '}
            <Link className="font-semibold text-brand-700" href="/">
              dashboard
            </Link>{' '}
            and{' '}
            <Link className="font-semibold text-brand-700" href="/statements">
              statements
            </Link>{' '}
            experiences.
          </p>
        </div>
      </section>
    );
  }

  const accounts = await getAccounts({
    userId: loggedIn.$id,
  });

  if (!accounts) return null;

  const accountsData = accounts?.data;

  return (
    <section className="payment-transfer">
      <HeaderBox
        title="Payment Transfer"
        subtext="Please provide any specific details or notes related to the payment transfer"
      />

      <section className="size-full pt-5">
        <PaymentTransferForm accounts={accountsData} />
      </section>
    </section>
  );
};

export default Transfer;
