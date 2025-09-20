export type RateLimitConfig = {
  limit: number;
  window: number; // ms
};

export type RateLimitResult = {
  success: boolean;
  remaining: number;
  reset: number;
};

const DEFAULT_CONFIG: RateLimitConfig = {
  limit: 5,
  window: 60_000,
};

type RateLimitState = {
  count: number;
  reset: number;
};

const getStore = () => {
  const globalStore = globalThis as typeof globalThis & {
    __HORIZON_RATE_LIMIT__?: Map<string, RateLimitState>;
  };

  if (!globalStore.__HORIZON_RATE_LIMIT__) {
    globalStore.__HORIZON_RATE_LIMIT__ = new Map();
  }

  return globalStore.__HORIZON_RATE_LIMIT__;
};

export const consumeRateLimit = (
  key: string,
  config: RateLimitConfig = DEFAULT_CONFIG
): RateLimitResult => {
  const store = getStore();
  const now = Date.now();
  const existing = store.get(key);

  if (existing && now < existing.reset) {
    if (existing.count >= config.limit) {
      return {
        success: false,
        remaining: 0,
        reset: existing.reset,
      };
    }

    const nextCount = existing.count + 1;
    store.set(key, { count: nextCount, reset: existing.reset });
    return {
      success: true,
      remaining: Math.max(config.limit - nextCount, 0),
      reset: existing.reset,
    };
  }

  const reset = now + config.window;
  store.set(key, { count: 1, reset });
  return {
    success: true,
    remaining: config.limit - 1,
    reset,
  };
};
