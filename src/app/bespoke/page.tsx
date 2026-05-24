import { BespokeConfigurator } from "@/components/bespoke/BespokeConfigurator";

export const metadata = {
  title: "Bespoke Suit Configurator",
};

export default function BespokePage() {
  return (
    <main id="main-content" className="px-4 py-10 md:px-6 md:py-16">
      <header className="mx-auto max-w-3xl text-center">
        <p className="text-xs uppercase tracking-[0.35em] text-sr-gold">Atelier</p>
        <h1 className="mt-3 font-serif text-4xl text-sr-navy md:text-5xl">
          Configure Your Suit
        </h1>
        <p className="mt-4 text-sm leading-relaxed text-sr-navy/80">
          Build your commission online, then request a fitting with our cutters.
          Price estimates update by market and fabric selection.
        </p>
      </header>
      <div className="mt-14">
        <BespokeConfigurator />
      </div>
    </main>
  );
}
