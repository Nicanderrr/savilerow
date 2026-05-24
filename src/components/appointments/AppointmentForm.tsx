"use client";

import { useSearchParams } from "next/navigation";
import { useState } from "react";
import type { AppointmentType } from "@/lib/types";

const TYPES: { id: AppointmentType; label: string }[] = [
  { id: "fitting", label: "In-store fitting" },
  { id: "trunk-show", label: "Trunk show" },
  { id: "virtual-consultation", label: "Virtual consultation" },
];

const LOCATIONS = ["Mayfair, London", "New York", "Dubai", "Sydney", "Virtual"];

export function AppointmentForm() {
  const params = useSearchParams();
  const defaultType = (params.get("type") as AppointmentType) || "fitting";
  const [type, setType] = useState<AppointmentType>(defaultType);
  const [submitted, setSubmitted] = useState(false);
  const [form, setForm] = useState({
    firstName: "",
    lastName: "",
    email: "",
    phone: "",
    location: LOCATIONS[0],
    date: "",
    time: "",
    notes: "",
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setSubmitted(true);
  };

  if (submitted) {
    return (
      <div className="mx-auto max-w-lg text-center">
        <h2 className="font-serif text-2xl text-sr-navy">Request received</h2>
        <p className="mt-4 text-sr-navy/80">
          Our concierge will confirm your {TYPES.find((t) => t.id === type)?.label.toLowerCase()} shortly.
          Calendar integration (Booxi / Calendly) can be wired at the marked hook below.
        </p>
      </div>
    );
  }

  return (
    <form onSubmit={handleSubmit} className="mx-auto max-w-xl space-y-6">
      <div
        id="calendar-integration-hook"
        className="rounded border border-dashed border-sr-gold/50 bg-sr-cream-dark/30 p-4 text-center text-sm text-sr-navy/70"
        data-integration="booxi|calendly"
      >
        Calendar widget placeholder — embed Booxi or Calendly iframe here.
      </div>

      <fieldset className="space-y-2">
        <legend className="text-xs uppercase tracking-widest text-sr-navy">Appointment type</legend>
        {TYPES.map((t) => (
          <label key={t.id} className="flex items-center gap-2">
            <input
              type="radio"
              name="type"
              checked={type === t.id}
              onChange={() => setType(t.id)}
            />
            {t.label}
          </label>
        ))}
      </fieldset>

      <div className="grid gap-4 sm:grid-cols-2">
        <input
          required
          placeholder="First name"
          value={form.firstName}
          onChange={(e) => setForm({ ...form, firstName: e.target.value })}
          className="border border-sr-cream-dark bg-transparent px-3 py-2"
        />
        <input
          required
          placeholder="Last name"
          value={form.lastName}
          onChange={(e) => setForm({ ...form, lastName: e.target.value })}
          className="border border-sr-cream-dark bg-transparent px-3 py-2"
        />
      </div>
      <input
        required
        type="email"
        placeholder="Email"
        value={form.email}
        onChange={(e) => setForm({ ...form, email: e.target.value })}
        className="w-full border border-sr-cream-dark bg-transparent px-3 py-2"
      />
      <input
        placeholder="Phone"
        value={form.phone}
        onChange={(e) => setForm({ ...form, phone: e.target.value })}
        className="w-full border border-sr-cream-dark bg-transparent px-3 py-2"
      />
      <select
        value={form.location}
        onChange={(e) => setForm({ ...form, location: e.target.value })}
        className="w-full border border-sr-cream-dark bg-transparent px-3 py-2"
      >
        {LOCATIONS.map((l) => (
          <option key={l} value={l}>
            {l}
          </option>
        ))}
      </select>
      <div className="grid gap-4 sm:grid-cols-2">
        <input
          required
          type="date"
          value={form.date}
          onChange={(e) => setForm({ ...form, date: e.target.value })}
          className="border border-sr-cream-dark bg-transparent px-3 py-2"
          aria-label="Preferred date"
        />
        <input
          required
          type="time"
          value={form.time}
          onChange={(e) => setForm({ ...form, time: e.target.value })}
          className="border border-sr-cream-dark bg-transparent px-3 py-2"
          aria-label="Preferred time"
        />
      </div>
      <textarea
        placeholder="Notes (garments, occasion, bespoke reference)"
        value={form.notes}
        onChange={(e) => setForm({ ...form, notes: e.target.value })}
        rows={4}
        className="w-full border border-sr-cream-dark bg-transparent px-3 py-2"
      />
      <button
        type="submit"
        className="w-full bg-sr-navy py-4 text-xs uppercase tracking-[0.3em] text-sr-cream"
      >
        Request appointment
      </button>
    </form>
  );
}
