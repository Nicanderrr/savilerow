"use client";

import { useUi } from "@/lib/ui-context";

export function AccessibilityDrawer() {
  const {
    a11yOpen,
    setA11yOpen,
    reduceMotion,
    setReduceMotion,
    highContrast,
    setHighContrast,
  } = useUi();

  return (
    <>
      <button
        id="a11y-trigger"
        type="button"
        className="sr-only"
        onClick={() => setA11yOpen(true)}
      >
        Open accessibility settings
      </button>

      {a11yOpen && (
        <>
          <div
            className="fixed inset-0 z-[92] bg-black/40"
            onClick={() => setA11yOpen(false)}
            aria-hidden
          />
          <aside className="fixed bottom-0 left-0 right-0 z-[93] bg-cl-white p-6 shadow-2xl md:left-auto md:right-6 md:bottom-6 md:w-80 md:rounded-sm">
            <div className="flex items-center justify-between">
              <h2 className="font-serif text-xl">Accessibility</h2>
              <button
                type="button"
                onClick={() => setA11yOpen(false)}
                className="text-2xl"
                aria-label="Close accessibility"
              >
                ×
              </button>
            </div>
            <div className="mt-6 space-y-4">
              <label className="flex items-center justify-between text-[13px]">
                <span>Reduce animations</span>
                <input
                  type="checkbox"
                  checked={reduceMotion}
                  onChange={(e) => setReduceMotion(e.target.checked)}
                  className="h-5 w-5"
                />
              </label>
              <label className="flex items-center justify-between text-[13px]">
                <span>Improve contrast</span>
                <input
                  type="checkbox"
                  checked={highContrast}
                  onChange={(e) => setHighContrast(e.target.checked)}
                  className="h-5 w-5"
                />
              </label>
            </div>
          </aside>
        </>
      )}
    </>
  );
}
