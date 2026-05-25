type IconProps = { className?: string };

export function IconMenu({ className = "h-4 w-5" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 20 14" fill="none" aria-hidden>
      <path d="M0 1h20M0 7h20M0 13h20" stroke="currentColor" strokeWidth="1" />
    </svg>
  );
}

export function IconSearch({ className = "h-5 w-5" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 24 24" fill="none" aria-hidden>
      <circle cx="10" cy="10" r="7" stroke="currentColor" strokeWidth="1" />
      <path d="M15 15l6 6" stroke="currentColor" strokeWidth="1" />
    </svg>
  );
}

export function IconAccount({ className = "h-5 w-5" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 24 24" fill="none" aria-hidden>
      <circle cx="12" cy="8" r="4" stroke="currentColor" strokeWidth="1" />
      <path d="M4 21c2-4 6-6 8-6s6 2 8 6" stroke="currentColor" strokeWidth="1" />
    </svg>
  );
}

export function IconHeart({ className = "h-5 w-5", filled }: IconProps & { filled?: boolean }) {
  return (
    <svg className={className} viewBox="0 0 24 24" fill={filled ? "currentColor" : "none"} aria-hidden>
      <path
        d="M12 20s-7-4.5-9-8.5C1 8 3 4 7 4c2 0 3.5 1.5 5 3.5C13.5 5.5 15 4 17 4c4 0 6 4 4 7.5-2 4-9 8.5-9 8.5z"
        stroke="currentColor"
        strokeWidth="1"
      />
    </svg>
  );
}

export function IconBag({ className = "h-5 w-5" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 24 24" fill="none" aria-hidden>
      <path d="M6 8V6a6 6 0 1112 0v2" stroke="currentColor" strokeWidth="1" />
      <path d="M4 8h16l-1 14H5L4 8z" stroke="currentColor" strokeWidth="1" />
    </svg>
  );
}

export function IconCompare({ className = "h-4 w-4" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 16 16" fill="none" aria-hidden>
      <path d="M2 4h12M2 8h12M2 12h8" stroke="currentColor" strokeWidth="1" />
    </svg>
  );
}

export function IconChevronDown({
  className = "h-4 w-4",
  open = false,
}: IconProps & { open?: boolean }) {
  return (
    <svg
      className={`${className} transition-transform duration-200 ${open ? "rotate-180" : ""}`}
      viewBox="0 0 24 24"
      fill="none"
      aria-hidden
    >
      <path
        d="M6 9l6 6 6-6"
        stroke="currentColor"
        strokeWidth="1.5"
        strokeLinecap="round"
        strokeLinejoin="round"
      />
    </svg>
  );
}

export function IconChevronRight({ className = "h-3 w-3" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 8 12" fill="none" aria-hidden>
      <path d="M1 1l5 5-5 5" stroke="currentColor" strokeWidth="1" />
    </svg>
  );
}

export function IconFilter({ className = "h-4 w-4" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 16 16" fill="none" aria-hidden>
      <path d="M1 3h14M4 8h8M6 13h4" stroke="currentColor" strokeWidth="1.2" />
    </svg>
  );
}

export function IconGrid({ className = "h-4 w-4" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 16 16" fill="currentColor" aria-hidden>
      <rect x="1" y="1" width="6" height="6" />
      <rect x="9" y="1" width="6" height="6" />
      <rect x="1" y="9" width="6" height="6" />
      <rect x="9" y="9" width="6" height="6" />
    </svg>
  );
}

export function IconList({ className = "h-4 w-4" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 16 16" fill="currentColor" aria-hidden>
      <rect x="1" y="2" width="14" height="2" />
      <rect x="1" y="7" width="14" height="2" />
      <rect x="1" y="12" width="14" height="2" />
    </svg>
  );
}

export function IconPause({ className = "h-4 w-4" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 16 16" fill="currentColor" aria-hidden>
      <rect x="3" y="2" width="3" height="12" />
      <rect x="10" y="2" width="3" height="12" />
    </svg>
  );
}

export function IconPlay({ className = "h-4 w-4" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 16 16" fill="currentColor" aria-hidden>
      <path d="M4 2l10 6-10 6V2z" />
    </svg>
  );
}

export function IconMute({ className = "h-4 w-4" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 20 16" fill="none" aria-hidden>
      <path d="M2 6h4l4-4v12l-4-4H2V6z" stroke="currentColor" strokeWidth="1" />
      <path d="M14 5l4 6M18 5l-4 6" stroke="currentColor" strokeWidth="1" />
    </svg>
  );
}

export function IconSound({ className = "h-4 w-4" }: IconProps) {
  return (
    <svg className={className} viewBox="0 0 20 16" fill="none" aria-hidden>
      <path d="M2 6h4l4-4v12l-4-4H2V6z" stroke="currentColor" strokeWidth="1" />
      <path d="M14 6c1.5 1 2 2.5 2 4s-.5 3-2 4" stroke="currentColor" strokeWidth="1" />
    </svg>
  );
}
