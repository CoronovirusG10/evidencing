# Horizon Theming & Rebranding Guide

This guide captures the key places to adjust when rebranding the Horizon private banking experience. The current palette reflects a deep-navy private bank aesthetic aligned to the new `brand` tokens inside `tailwind.config.ts`.

## 1. Tailwind brand tokens

The Tailwind theme extension includes a dedicated `brand` color scale (`brand-25` → `brand-900`) plus updated gradients and shadows. To tweak primary colors or shadows, edit `tailwind.config.ts`:

```ts
extend: {
  colors: {
    brand: {
      25: '#F4F7FB',
      50: '#E7EEFA',
      300: '#8EAEE4',
      500: '#2F6BDF',
      700: '#173F8E',
      900: '#0F295A',
    },
  },
  backgroundImage: {
    'bank-gradient': 'linear-gradient(135deg, #173F8E 0%, #2F6BDF 50%, #61A6FA 100%)',
    'bank-gradient-soft': 'linear-gradient(120deg, rgba(23,63,142,0.08) 0%, rgba(47,107,223,0.08) 100%)',
  },
}
```

Update these values to align with your brand palette. Use `brand` tokens in components to ensure consistency.

## 2. Typography

- Global fonts are registered in `app/layout.tsx` (Inter + IBM Plex Sans/Serif).
- Update the `IBM_Plex_Sans` or `IBM_Plex_Serif` imports to switch to alternate font families.
- Many headline/body styles rely on utility classes defined in `app/globals.css` (`.text-24`, `.header-box-title`, etc.). Adjust these utility classes for global typography changes.

## 3. Navigation & surfaces

Key components styled with the new palette:

- `components/Sidebar.tsx`: active nav items use the `bank-gradient` background and white text. Replace `bg-bank-gradient` or tweak `legal` links to match your palette.
- `app/globals.css`: the `.home`, `.transactions`, `.payment-transfer`, and `.sidebar` utility classes control primary page backgrounds. Update them to suit dark/light brand preferences.<br>
- `components/TransactionsTable.tsx`: direction badges use styles from `transactionDirectionStyles` in `constants/index.ts`. Update those palette entries for credit/debit badges.

## 4. Legal banner & disclaimer

- `components/LegalBanner.tsx` renders the regulatory notice reused on the dashboard and statements page. Adjust copy or the CTA link there.
- The `/legal/disclaimer` route lives in `app/(root)/legal/disclaimer/page.tsx`. Use this page to surface jurisdiction-specific wording. For regional deployments (e.g., UAE), swap or localize the sections.

## 5. Manual transaction & filters palette

- `components/ManualTransactionSheet.tsx` uses brand-outlined buttons and select inputs. Modify the `Button` variant in `components/ui/button.tsx` or pass `variant` props to align with different branding.
- `components/TransactionFilters.tsx` and `components/StatementFilters.tsx` wrap filter forms in white cards with `brand` accents; adjust the form container classes if you move to a dark theme.

## 6. Assets

The sidebar uses SVG icons from `public/icons`. Replace `logo.svg` and other icons with branded assets if required. For gradient backgrounds, supply updated assets in `public/icons/gradient-mesh.svg` or replace `bank-gradient` definitions.

---

After updating branding assets:

1. Restart the dev server (`npm run dev`) to pick up Tailwind changes.
2. Run `npm run lint` to ensure the design tweaks didn’t break lint rules.
3. Refresh the statements and transaction pages to validate legal banners render correctly.

For multi-brand support, consider extracting palette values into environment-driven configuration and toggling with CSS variables.
