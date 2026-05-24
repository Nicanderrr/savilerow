import Image from "next/image";
import Link from "next/link";
import { PHOTOS } from "@/lib/images";

export const metadata = {
  title: "Visit Our Boutique",
};

export default function BoutiquePage() {
  return (
    <main id="main-content" className="bg-cl-white">
      <div className="relative aspect-[21/9] w-full bg-cl-gray md:aspect-[3/1]">
        <Image
          src={PHOTOS.store}
          alt="Savile Row boutique on Savile Row, Mayfair"
          fill
          className="object-cover"
          priority
          sizes="100vw"
        />
        <div className="absolute inset-0 bg-black/30" />
      </div>
      <div className="mx-auto max-w-2xl px-6 py-16 text-center md:py-24">
        <p className="text-label text-cl-muted">Mayfair · London</p>
        <h1 className="mt-4 font-serif text-3xl uppercase md:text-5xl">
          Visit our boutique
        </h1>
        <p className="mt-6 text-[13px] leading-relaxed text-cl-muted">
          Experience tailoring, shoes, and leather goods in our historic house on
          Savile Row. Private fittings and consultations are available by
          appointment.
        </p>
        <address className="mt-8 not-italic text-[13px] leading-relaxed">
          <strong className="font-normal">Savile Row</strong>
          <br />
          12 Savile Row
          <br />
          London W1S 3PR
          <br />
          United Kingdom
        </address>
        <p className="mt-4 text-[13px] text-cl-muted">
          <a href="tel:+442073287000" className="hover:text-black">
            +44 20 7328 7000
          </a>
        </p>
        <Link href="/appointments" className="btn-red mt-10 inline-block">
          Book an appointment
        </Link>
      </div>
    </main>
  );
}
