const parseFlag = (value: string | undefined, defaultValue: boolean) => {
  if (value === undefined || value === null) return defaultValue;

  switch (value.toLowerCase()) {
    case '1':
    case 'true':
    case 'yes':
    case 'on':
      return true;
    case '0':
    case 'false':
    case 'no':
    case 'off':
      return false;
    default:
      return defaultValue;
  }
};

export const isPlaidEnabled = () =>
  parseFlag(process.env.NEXT_PUBLIC_ENABLE_PLAID ?? process.env.ENABLE_PLAID, true);

export const isTransfersEnabled = () =>
  parseFlag(process.env.NEXT_PUBLIC_ENABLE_TRANSFERS ?? process.env.ENABLE_TRANSFERS, true);

export const getFeatureFlags = () => ({
  plaid: isPlaidEnabled(),
  transfers: isTransfersEnabled(),
});
