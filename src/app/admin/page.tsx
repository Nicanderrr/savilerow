import { notFound } from "next/navigation";
import { AdminPanel } from "@/components/admin/AdminPanel";

export const metadata = { title: "Admin" };

export default function AdminPage() {
  if (process.env.ENABLE_ADMIN !== "true") {
    notFound();
  }
  return (
    <main id="main-content" className="mx-auto max-w-4xl px-4 py-10 md:px-6">
      <h1 className="font-serif text-3xl text-sr-navy">Product admin (mock)</h1>
      <p className="mt-2 text-sm text-sr-navy/70">
        Protected by ENABLE_ADMIN=true. See docs/admin.md for headless CMS integration.
      </p>
      <AdminPanel />
    </main>
  );
}
