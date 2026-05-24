"use client";

import { usePathname } from "next/navigation";
import { useEffect } from "react";
import { useUi } from "@/lib/ui-context";

export function RouteTheme() {
  const pathname = usePathname();
  const { setHeroLight } = useUi();

  useEffect(() => {
    setHeroLight(pathname === "/");
  }, [pathname, setHeroLight]);

  return null;
}
