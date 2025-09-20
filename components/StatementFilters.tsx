"use client";

import { FormEvent, useEffect, useState } from 'react';
import { usePathname, useRouter, useSearchParams } from 'next/navigation';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';

type StatementFiltersProps = {
  accounts: Account[];
  defaultValues: {
    bankId: string;
    from: string;
    to: string;
    direction: string;
  };
  downloadLinks: {
    pdf: string;
    csv: string;
  };
};

const DIRECTIONS = [
  { value: 'all', label: 'All transactions' },
  { value: 'credit', label: 'Credits (money in)' },
  { value: 'debit', label: 'Debits (money out)' },
];

export const StatementFilters = ({ accounts, defaultValues, downloadLinks }: StatementFiltersProps) => {
  const router = useRouter();
  const pathname = usePathname();
  const searchParams = useSearchParams();

  const [state, setState] = useState({
    bankId: defaultValues.bankId,
    from: defaultValues.from,
    to: defaultValues.to,
    direction: defaultValues.direction || 'all',
  });

  useEffect(() => {
    setState({
      bankId: defaultValues.bankId,
      from: defaultValues.from,
      to: defaultValues.to,
      direction: defaultValues.direction || 'all',
    });
  }, [defaultValues.bankId, defaultValues.from, defaultValues.to, defaultValues.direction]);

  const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    const params = new URLSearchParams(searchParams.toString());

    params.set('id', state.bankId);
    if (state.from) params.set('from', state.from);
    else params.delete('from');

    if (state.to) params.set('to', state.to);
    else params.delete('to');

    if (state.direction && state.direction !== 'all') params.set('direction', state.direction);
    else params.delete('direction');

    params.delete('page');

    router.push(`${pathname}?${params.toString()}`, { scroll: false });
  };

  const handleReset = () => {
    setState({
      bankId: defaultValues.bankId,
      from: defaultValues.from,
      to: defaultValues.to,
      direction: 'all',
    });

    const params = new URLSearchParams(searchParams.toString());
    params.set('id', defaultValues.bankId);
    params.delete('from');
    params.delete('to');
    params.delete('direction');
    params.delete('page');
    router.push(`${pathname}?${params.toString()}`, { scroll: false });
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="flex w-full flex-col gap-4 rounded-2xl bg-white p-4 shadow-sm md:flex-row md:items-end"
    >
      <div className="flex flex-1 flex-col gap-2">
        <label className="text-sm font-medium text-gray-700" htmlFor="statement-account">
          Account
        </label>
        <Select
          value={state.bankId}
          onValueChange={(value) => setState((prev) => ({ ...prev, bankId: value }))}
        >
          <SelectTrigger id="statement-account">
            <SelectValue />
          </SelectTrigger>
          <SelectContent>
            {accounts.map((account) => (
              <SelectItem key={account.appwriteItemId} value={account.appwriteItemId}>
                {account.name}
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
      </div>

      <div className="flex flex-1 flex-col gap-2">
        <label className="text-sm font-medium text-gray-700" htmlFor="statement-from">
          From
        </label>
        <Input
          type="date"
          id="statement-from"
          value={state.from}
          onChange={(event) => setState((prev) => ({ ...prev, from: event.target.value }))}
        />
      </div>

      <div className="flex flex-1 flex-col gap-2">
        <label className="text-sm font-medium text-gray-700" htmlFor="statement-to">
          To
        </label>
        <Input
          type="date"
          id="statement-to"
          value={state.to}
          onChange={(event) => setState((prev) => ({ ...prev, to: event.target.value }))}
        />
      </div>

      <div className="flex flex-1 flex-col gap-2">
        <label className="text-sm font-medium text-gray-700" htmlFor="statement-direction">
          Direction
        </label>
        <Select
          value={state.direction || 'all'}
          onValueChange={(value) => setState((prev) => ({ ...prev, direction: value }))}
        >
          <SelectTrigger id="statement-direction">
            <SelectValue />
          </SelectTrigger>
          <SelectContent>
            {DIRECTIONS.map((option) => (
              <SelectItem key={option.value} value={option.value}>
                {option.label}
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
      </div>

      <div className="flex flex-col gap-2 md:w-[220px]">
        <label className="text-sm font-medium text-gray-700">Actions</label>
        <div className="flex gap-2">
          <Button type="submit" className="flex-1">
            Apply
          </Button>
          <Button type="button" variant="outline" onClick={handleReset}>
            Reset
          </Button>
        </div>
        <div className="flex gap-2">
          <Button asChild variant="ghost" className="flex-1">
            <a href={downloadLinks.csv} download>
              Export CSV
            </a>
          </Button>
          <Button asChild variant="ghost" className="flex-1">
            <a href={downloadLinks.pdf} download>
              Download PDF
            </a>
          </Button>
        </div>
      </div>
    </form>
  );
};
