import type { NextRequest } from 'next/server';
import { NextResponse } from 'next/server';

import { AUTHORIZED_EMAIL_COOKIE, getAllowedEmails, isEmailAllowed } from '@/lib/auth';

const PUBLIC_ROUTES = ['/sign-in', '/sign-up'];

const isPublicRoute = (pathname: string): boolean => {
  return PUBLIC_ROUTES.some((route) => pathname === route || pathname.startsWith(`${route}/`));
};

export const config = {
  matcher: [
    '/((?!_next/static|_next/image|favicon.ico|fonts|icons|.*\\.(?:svg|png|jpg|jpeg|ico|txt|xml)).*)',
    '/api/:path*',
  ],
};

export function middleware(request: NextRequest) {
  const { pathname } = request.nextUrl;

  if (isPublicRoute(pathname)) {
    return NextResponse.next();
  }

  const allowedEmails = getAllowedEmails();
  if (allowedEmails.length === 0) {
    return NextResponse.next();
  }

  const cookieEmail = request.cookies.get(AUTHORIZED_EMAIL_COOKIE)?.value;

  if (!cookieEmail || !isEmailAllowed(cookieEmail)) {
    const signInUrl = request.nextUrl.clone();
    signInUrl.pathname = '/sign-in';
    signInUrl.searchParams.set('reason', 'not-authorized');
    return NextResponse.redirect(signInUrl);
  }

  return NextResponse.next();
}
