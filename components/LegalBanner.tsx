import Link from 'next/link';
import { ArrowUpRight } from 'lucide-react';

const LegalBanner = () => {
  return (
    <section className="legal-banner">
      <div className="flex-1 space-y-1">
        <p className="text-sm font-semibold text-brand-700">Regulatory Notice</p>
        <p className="text-sm text-gray-600">
          Horizon provides digital wealth management services with FDIC-insured sweep programs. Transaction availability may vary by jurisdiction.
          Please review the latest legal disclosures before completing a transfer.
        </p>
      </div>
      <div className="flex items-center gap-3">
        <Link className="legal-banner__cta" href="/legal/disclaimer">
          View full disclaimer
          <ArrowUpRight className="h-4 w-4" />
        </Link>
      </div>
    </section>
  );
};

export default LegalBanner;
