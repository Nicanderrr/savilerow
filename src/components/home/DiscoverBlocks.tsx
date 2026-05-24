import Image from "next/image";
import Link from "next/link";
import { PHOTOS } from "@/lib/images";

const blocks = [
  {
    eyebrow: "New collection",
    title: "Spring / Summer Women",
    href: "/collections/women/suits",
    image: PHOTOS.blazerW1,
    dark: false,
  },
  {
    eyebrow: "New collection",
    title: "Spring / Summer Men",
    href: "/collections/men/suits",
    image: PHOTOS.menPromo,
    dark: false,
  },
  {
    eyebrow: "Timeless signature",
    title: "New season's bags",
    href: "/collections/women/bags",
    image: PHOTOS.bagPromo,
    dark: true,
  },
  {
    eyebrow: "New arrivals",
    title: "Latest creations",
    href: "/collections/all/products",
    image: PHOTOS.shoePromo,
    dark: false,
  },
];

export function DiscoverBlocks() {
  return (
    <section>
      {blocks.map((block) => (
        <div
          key={block.title}
          className={`grid md:grid-cols-2 ${block.dark ? "bg-cl-black text-white" : "bg-cl-white text-black"}`}
        >
          <div className="relative aspect-[4/5] md:aspect-auto md:min-h-[70vh]">
            <Image
              src={block.image}
              alt=""
              fill
              className="object-cover"
              sizes="(max-width: 768px) 100vw, 50vw"
            />
          </div>
          <div className="flex flex-col justify-center px-8 py-16 md:px-16 md:py-24">
            <p className="text-label text-inherit opacity-80">{block.eyebrow}</p>
            <h2 className="mt-4 font-serif text-3xl uppercase md:text-5xl">
              {block.title}
            </h2>
            <Link
              href={block.href}
              className={`mt-10 inline-block w-fit text-label underline-offset-4 hover:underline ${
                block.dark ? "text-white" : "text-black"
              }`}
            >
              Discover
            </Link>
          </div>
        </div>
      ))}
    </section>
  );
}
