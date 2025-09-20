export const AUTHORIZED_EMAIL_COOKIE = "horizon-authorized-email";

const normalizeEmail = (email: string) => email.trim().toLowerCase();

export const getAllowedEmails = (): string[] => {
  const raw = process.env.ALLOWED_EMAILS;
  if (!raw) return [];

  return raw
    .split(",")
    .map((value) => value.trim())
    .filter((value) => value.length > 0)
    .map((value) => value.toLowerCase());
};

export const isEmailAllowed = (email: string | null | undefined): boolean => {
  if (!email) return false;

  const allowed = getAllowedEmails();
  if (allowed.length === 0) return true; // allow everyone if list is empty

  return allowed.includes(normalizeEmail(email));
};

export const describeAllowedEmails = () => {
  const allowed = getAllowedEmails();
  return allowed.length ? allowed.join(", ") : "(any email)";
};
