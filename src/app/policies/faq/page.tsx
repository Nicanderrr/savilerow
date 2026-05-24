const faqs = [
  {
    q: "How long does bespoke take?",
    a: "Typically 8–12 weeks from first fitting, depending on fabric mill and season.",
  },
  {
    q: "Do you ship internationally?",
    a: "Yes — we ship to US, UK, EU, UAE, Australia, and select additional destinations.",
  },
  {
    q: "Can I book without purchasing online?",
    a: "Absolutely. Use Appointments to request a fitting with no obligation.",
  },
];

export const metadata = { title: "FAQ" };

export default function FaqPage() {
  return (
    <main id="main-content" className="mx-auto max-w-2xl px-4 py-10 md:px-6 md:py-16">
      <h1 className="font-serif text-3xl text-sr-navy">FAQ</h1>
      <dl className="mt-10 space-y-8">
        {faqs.map((f) => (
          <div key={f.q}>
            <dt className="font-serif text-lg text-sr-navy">{f.q}</dt>
            <dd className="mt-2 text-sm text-sr-navy/80">{f.a}</dd>
          </div>
        ))}
      </dl>
    </main>
  );
}
