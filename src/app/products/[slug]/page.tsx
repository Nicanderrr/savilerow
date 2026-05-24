import { notFound } from "next/navigation";
import { PdpContent } from "@/components/commerce/PdpContent";
import { BackNav } from "@/components/layout/BackNav";
import { PRODUCTS, getProductBySlug } from "@/lib/catalog";

type Props = { params: Promise<{ slug: string }> };

export function generateStaticParams() {
  return PRODUCTS.map((p) => ({ slug: p.slug }));
}

export default async function ProductPage({ params }: Props) {
  const { slug } = await params;
  const product = getProductBySlug(slug);
  if (!product) notFound();

  const collectionHref = `/collections/${product.gender}/${product.category}`;

  return (
    <main id="main-content" className="bg-cl-white">
      <div className="mx-auto max-w-[1600px] px-6">
        <BackNav href={collectionHref} label="Back to collection" />
      </div>
      <PdpContent product={product} />
    </main>
  );
}
