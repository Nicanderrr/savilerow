"use client";

type Option = { id: string; label: string; value: string; inStock?: boolean };

export function VariantSelector({
  label,
  options,
  value,
  onChange,
}: {
  label: string;
  options: Option[];
  value: string;
  onChange: (v: string) => void;
}) {
  return (
    <div>
      <p className="text-label text-cl-muted">{label}</p>
      <div className="mt-3 flex flex-wrap gap-2">
        {options.map((opt) => {
          const selected = value === opt.value;
          const disabled = opt.inStock === false;
          return (
            <button
              key={opt.id}
              type="button"
              disabled={disabled}
              onClick={() => onChange(opt.value)}
              className={`min-w-[48px] border px-4 py-2.5 text-[12px] uppercase tracking-wider transition ${
                selected
                  ? "border-black bg-black text-white"
                  : "border-cl-gray-mid bg-white text-black hover:border-black"
              } ${disabled ? "opacity-40" : ""}`}
            >
              {opt.label}
            </button>
          );
        })}
      </div>
    </div>
  );
}
