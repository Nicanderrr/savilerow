import { Suspense } from "react";
import { AppointmentForm } from "@/components/appointments/AppointmentForm";

export const metadata = {
  title: "Book an Appointment",
};

export default function AppointmentsPage() {
  return (
    <main id="main-content" className="px-4 py-10 md:px-6 md:py-16">
      <header className="mx-auto max-w-xl text-center">
        <p className="text-xs uppercase tracking-[0.35em] text-sr-gold">Concierge</p>
        <h1 className="mt-3 font-serif text-4xl text-sr-navy">Appointments</h1>
        <p className="mt-4 text-sm text-sr-navy/80">
          Fittings, trunk shows, and virtual consultations across our global houses.
        </p>
      </header>
      <div className="mt-12">
        <Suspense fallback={<p className="text-center text-sm">Loading…</p>}>
          <AppointmentForm />
        </Suspense>
      </div>
    </main>
  );
}
