export const metadata = { title: "Shipping" };

export default function ShippingPolicyPage() {
  return (
    <PolicyLayout title="Shipping">
      <p>Complimentary standard delivery on orders over threshold by market (UK £500, US $600, EU €550).</p>
      <h2 className="mt-8 font-serif text-xl text-sr-navy">Global tiers</h2>
      <ul className="mt-4 list-inside list-disc space-y-2">
        <li>Standard — 5–7 business days</li>
        <li>Express — 2–3 business days</li>
        <li>White-glove — UAE metro, by appointment</li>
      </ul>
      <p className="mt-6">
        Duties and import taxes may apply outside VAT-inclusive markets. Full breakdown shown at checkout.
      </p>
    </PolicyLayout>
  );
}

function PolicyLayout({
  title,
  children,
}: {
  title: string;
  children: React.ReactNode;
}) {
  return (
    <main id="main-content" className="mx-auto max-w-2xl px-4 py-10 md:px-6 md:py-16">
      <h1 className="font-serif text-3xl text-sr-navy">{title}</h1>
      <div className="prose prose-sm mt-8 max-w-none space-y-4 text-sr-navy/85">{children}</div>
    </main>
  );
}
