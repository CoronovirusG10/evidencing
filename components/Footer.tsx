import { logoutAccount } from '@/lib/actions/user.actions'
import Image from 'next/image'
import Link from 'next/link'
import { useRouter } from 'next/navigation'
import React from 'react'

const Footer = ({ user, type = 'desktop' }: FooterProps) => {
  const router = useRouter();

  const handleLogOut = async () => {
    const loggedOut = await logoutAccount();

    if(loggedOut) router.push('/sign-in')
  }

  return (
    <footer className="footer">
      <div className={type === 'mobile' ? 'footer_name-mobile' : 'footer_name'}>
        <p className="text-xl font-bold text-gray-700">
          {user?.firstName[0]}
        </p>
      </div>

      <div className={type === 'mobile' ? 'footer_email-mobile' : 'footer_email'}>
          <h1 className="text-14 truncate text-gray-700 font-semibold">
            {user?.firstName}
          </h1>
          <p className="text-14 truncate font-normal text-gray-600">
            {user?.email}
          </p>
      </div>

      <div className="flex items-center gap-3">
        <Link href="/legal/disclaimer" className="text-12 font-semibold text-brand-700 hover:text-brand-900">
          Legal
        </Link>
        <div className="footer_image" onClick={handleLogOut}>
          <Image src="icons/logout.svg" fill alt="jsm" />
        </div>
      </div>
    </footer>
  )
}

export default Footer
