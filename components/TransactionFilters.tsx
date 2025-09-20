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

const DIRECTIONS = [
  { value: 'all', label: 'All' },
  { value: 'credit', label: 'Credits' },
  { value: 'debit', label: 'Debits' },
];

type TransactionFiltersProps = {
  defaultValues: {
    bankId: string;
    from?: string;
    to?: string;
    direction?: string;
  };
  exportUrl: string;
};

export const TransactionFilters = ({ defaultValues, exportUrl }: TransactionFiltersProps) => {
  const router = useRouter();
  const pathname = usePathname();
  const searchParams = useSearchParams();

  const [state, setState] = useState({
    from: defaultValues.from || '',
    to: defaultValues.to || '',
    direction: defaultValues.direction || 'all',
  });

  useEffect(() => {
    setState({
      from: defaultValues.from || '',
      to: defaultValues.to || '',
      direction: defaultValues.direction || 'all',
    });
  }, [defaultValues.from, defaultValues.to, defaultValues.direction, defaultValues.bankId]);

  const applyFilters = (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    const params = new URLSearchParams(searchParams.toString());

    params.set('id', defaultValues.bankId);

    if (state.from) params.set('from', state.from);
    else params.delete('from');

    if (state.to) params.set('to', state.to);
    else params.delete('to');

    if (state.direction && state.direction !== 'all') params.set('direction', state.direction);
    else params.delete('direction');

    params.delete('page');

    router.push(`${pathname}?${params.toString()}`, { scroll: false });
  };

  const resetFilters = () => {
    setState({ from: '', to: '', direction: 'all' });
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
      onSubmit={applyFilters}
      className="flex w-full flex-col gap-3 rounded-2xl bg-white p-4 shadow-sm md:flex-row md:items-end"
    >
      <div className="flex flex-1 flex-col gap-2">
        <label className="text-sm font-medium text-gray-700" htmlFor="filter-from">
          From
        </label>
        <Input
          id="filter-from"
          type="date"
          value={state.from}
          onChange={(event) => setState((prev) => ({ ...prev, from: event.target.value }))}
        />
      </div>

      <div className="flex flex-1 flex-col gap-2">
        <label className="text-sm font-medium text-gray-700" htmlFor="filter-to">
          To
        </label>
        <Input
          id="filter-to"
          type="date"
          value={state.to}
          onChange={(event) => setState((prev) => ({ ...prev, to: event.target.value }))}
        />
      </div>

      <div className="flex flex-1 flex-col gap-2">
        <label className="text-sm font-medium text-gray-700" htmlFor="filter-direction">
          Direction
        </label>
        <Select
          value={state.direction}
          onValueChange={(value) => setState((prev) => ({ ...prev, direction: value }))}
        >
          <SelectTrigger id="filter-direction">
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
          <Button type="button" variant="outline" onClick={resetFilters}>
            Reset
          </Button>
        </div>
        <Button asChild variant="ghost">
          <a href={exportUrl} download>
            Export CSV
          </a>
        </Button>
      </div>
    </form>
  );
};
