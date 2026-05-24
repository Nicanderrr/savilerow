import Image from "next/image";
import Link from "next/link";
import { PHOTOS } from "@/lib/images";

const services = [
  {
    title: "Private fittings",
    href: "/appointments",
    image: PHOTOS.fitting,
  },
  {
    title: "Visit our boutique",
    href: "/boutique",
    image: PHOTOS.store,
  },
  {
    title: "Bespoke tailoring",
    href: "/bespoke",
    image: PHOTOS.tailoring,
  },
  {
    title: "Client services",
    href: "/policies/faq",
    image: PHOTOS.contact,
  },
];

export function ServicesStrip() {
  return (
    <section className="grid grid-cols-2 md:grid-cols-4">
      {services.map((s) => (
        <Link key={s.title} href={s.href} className="group relative aspect-square overflow-hidden">
          <Image src={s.image} alt="" fill className="object-cover transition group-hover:scale-105" sizes="25vw" />
          <div className="absolute inset-0 bg-black/35" />
          <p className="absolute inset-0 flex items-center justify-center px-4 text-center font-serif text-sm uppercase tracking-wide text-white md:text-base">
            {s.title}
          </p>
        </Link>
      ))}
    </section>
  );
}
