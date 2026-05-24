import { notFound } from "next/navigation";
import { CollectionPage } from "@/components/plp/CollectionPage";
import type { Gender, ProductCategory } from "@/lib/types";

const GENDERS: Gender[] = ["women", "men", "kids"];
const CATEGORIES: ProductCategory[] = [
  "suits",
  "shoes",
  "bags",
  "perfumes",
  "accessories",
];

type Props = {
  params: Promise<{ gender: string; category: string }>;
};

export function generateStaticParams() {
  return GENDERS.flatMap((gender) =>
    CATEGORIES.map((category) => ({ gender, category }))
  );
}

export default async function Page({ params }: Props) {
  const { gender, category } = await params;
  if (!GENDERS.includes(gender as Gender) || !CATEGORIES.includes(category as ProductCategory)) {
    notFound();
  }
  return (
    <CollectionPage
      gender={gender as Gender}
      category={category as ProductCategory}
    />
  );
}
