"use client";

export type FulfillmentMethod = "ship" | "pickup";

export function FulfillmentSelect({
  value,
  onChange,
}: {
  value: FulfillmentMethod;
  onChange: (v: FulfillmentMethod) => void;
}) {
  const options: { id: FulfillmentMethod; label: string; hint: string }[] = [
    { id: "ship", label: "Ship to me", hint: "Express delivery" },
    { id: "pickup", label: "In-store pickup", hint: "Savile Row, Mayfair" },
  ];

  return (
    <fieldset>
      <legend className="text-label text-cl-muted">Delivery</legend>
      <div className="mt-3 grid grid-cols-2 gap-2">
        {options.map((opt) => (
          <label
            key={opt.id}
            className={`cursor-pointer rounded-full border px-4 py-3 text-center transition ${
              value === opt.id
                ? "border-black bg-black text-white"
                : "border-cl-gray-mid text-black hover:border-black"
            }`}
          >
            <input
              type="radio"
              name="fulfillment"
              value={opt.id}
              checked={value === opt.id}
              onChange={() => onChange(opt.id)}
              className="sr-only"
            />
            <span className="block text-[11px] uppercase tracking-[0.15em]">
              {opt.label}
            </span>
            <span
              className={`mt-1 block text-[10px] normal-case tracking-normal ${
                value === opt.id ? "text-white/75" : "text-cl-muted"
              }`}
            >
              {opt.hint}
            </span>
          </label>
        ))}
      </div>
    </fieldset>
  );
}
