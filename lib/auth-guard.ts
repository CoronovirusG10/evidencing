'use server';

import { redirect } from 'next/navigation';

import { getLoggedInUser } from '@/lib/actions/user.actions';
import { isEmailAllowed } from '@/lib/auth';

const redirectToSignIn = (reason: string) => {
  const params = new URLSearchParams();
  if (reason) params.set('reason', reason);

  const query = params.toString();
  const location = query.length ? `/sign-in?${query}` : '/sign-in';

  redirect(location);
};

export const requireAuthorizedUser = async () => {
  const user = await getLoggedInUser();

  if (!user) {
    redirectToSignIn('not-authenticated');
  }

  if (!isEmailAllowed(user.email)) {
    redirectToSignIn('not-authorized');
  }

  return user;
};
