"use client";

type Option = { id: string; label: string; value: string; inStock?: boolean };

export function SizeSelect({
  label,
  options,
  value,
  onChange,
  placeholder = "Choose your size",
}: {
  label: string;
  options: Option[];
  value: string;
  onChange: (v: string) => void;
  placeholder?: string;
}) {
  return (
    <div>
      <label htmlFor="size-select" className="text-label text-cl-muted">
        {label}
      </label>
      <div className="relative mt-3">
        <select
          id="size-select"
          value={value}
          onChange={(e) => onChange(e.target.value)}
          className={`w-full appearance-none rounded-full border border-cl-gray-mid bg-white px-5 py-3.5 pr-10 text-[13px] tracking-wide focus:border-black focus:outline-none ${
            value ? "text-black" : "text-cl-muted"
          }`}
        >
          <option value="" disabled>
            {placeholder}
          </option>
          {options.map((opt) => (
            <option key={opt.id} value={opt.value} disabled={opt.inStock === false}>
              {opt.label}
              {opt.inStock === false ? " — Sold out" : ""}
            </option>
          ))}
        </select>
        <span
          className="pointer-events-none absolute right-5 top-1/2 -translate-y-1/2 text-[10px] text-cl-muted"
          aria-hidden
        >
          ▼
        </span>
      </div>
    </div>
  );
}
