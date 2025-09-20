import HeaderBox from '@/components/HeaderBox';
import Link from 'next/link';

const sections = [
  {
    title: 'General Information',
    body: `Horizon Bank Corporation ("Horizon") provides digital banking tools designed for wealth management and private banking clients. Horizon is not a chartered bank. Custodial cash services are provided through partner financial institutions that are insured members of the Federal Deposit Insurance Corporation (FDIC).` ,
  },
  {
    title: 'Regulatory Status',
    body: `Investment advisory and brokerage services are offered through Horizon Advisors LLC, an SEC-registered investment adviser. Registration does not imply a certain level of skill or training. Products and services may not be available in all jurisdictions, and eligibility is subject to verification.`,
  },
  {
    title: 'Risk Disclosure',
    body: `All investments involve risk, including the possible loss of principal. Past performance does not guarantee future results. Horizon does not provide legal, tax, or accounting advice. Clients should consult their own professional advisors prior to engaging in any transaction.`,
  },
  {
    title: 'FDIC Coverage',
    body: `Cash balances swept to partner banks are eligible for FDIC insurance up to applicable limits when aggregated with any existing deposits held with the same institution in the same ownership capacity. Coverage details are provided at account opening and are available upon request.`,
  },
  {
    title: 'Electronic Communications',
    body: `By using Horizon digital services you consent to receiving statements, notices, and disclosures electronically. You may request paper copies at any time. Availability of services may be impacted by scheduled maintenance, network outages, or regulatory restrictions.`,
  },
  {
    title: 'Jurisdictional Restrictions',
    body: `Use of Horizon services is governed by the laws of the United States. Access from jurisdictions where services are prohibited is not permitted. UAE-based deployments comply with applicable UAE Central Bank and data-residency requirements through designated regional infrastructure.`,
  },
];

export default function LegalDisclaimerPage() {
  return (
    <div className="transactions">
      <div className="transactions-header">
        <HeaderBox
          title="Client Legal Disclosures"
          subtext="Please review these disclosures carefully before using Horizon services."
        />
      </div>

      <div className="space-y-8 rounded-2xl bg-white p-6 shadow-subtle">
        {sections.map((section) => (
          <section key={section.title} className="space-y-3">
            <h2 className="text-lg font-semibold text-brand-700">{section.title}</h2>
            <p className="text-sm text-gray-600 leading-6">{section.body}</p>
          </section>
        ))}

        <section className="space-y-3 border-t border-brand-50 pt-4">
          <h2 className="text-lg font-semibold text-brand-700">Contact & Additional Information</h2>
          <p className="text-sm text-gray-600 leading-6">
            Questions regarding these disclosures can be directed to Horizon Compliance at
            <Link className="ml-1 font-semibold text-brand-700" href="mailto:compliance@horizonbank.com">
              compliance@horizonbank.com
            </Link>.
            A full copy of the client agreement and privacy policy is available upon request.
          </p>
        </section>
      </div>
    </div>
  );
}
