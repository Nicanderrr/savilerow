import { DiscoverBlocks } from "@/components/home/DiscoverBlocks";
import { ProductNameCarousel } from "@/components/home/ProductNameCarousel";
import { ServicesStrip } from "@/components/home/ServicesStrip";
import { VideoHero } from "@/components/home/VideoHero";

export default function HomePage() {
  return (
    <main id="main-content">
      <VideoHero />
      <DiscoverBlocks />
      <ProductNameCarousel />
      <section className="bg-cl-black px-6 py-20 text-white md:px-10 md:py-28">
        <div className="mx-auto max-w-3xl text-center">
          <p className="text-label opacity-80">The House</p>
          <h2 className="mt-4 font-serif text-3xl uppercase md:text-5xl">
            The world of Savile Row
          </h2>
          <p className="mt-6 text-[13px] leading-relaxed text-white/75">
            Seven generations of cutters and tailors on London&apos;s most
            famous street — from coronation morning coats to contemporary
            ready-to-wear.
          </p>
        </div>
      </section>
      <ServicesStrip />
    </main>
  );
}
