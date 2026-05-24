/**
 * Hubble Momo mobile money integration seam.
 * Production: wire to Hubble Momo API when credentials are configured.
 * Development: sandbox mock returns a placeholder payment session.
 */

export type HubbleMomoEnv = "sandbox" | "production";

export type MomoInitRequest = {
  amount: number;
  currency: string;
  orderId: string;
  customerPhone?: string;
  description?: string;
};

export type MomoPaymentSession = {
  sessionId: string;
  status: "pending" | "completed" | "failed";
  qrCodeUrl?: string;
  deepLink?: string;
  expiresAt: string;
  message: string;
};

function getConfig() {
  const apiKey = process.env.HUBBLE_MOMO_API_KEY ?? "";
  const merchantId = process.env.HUBBLE_MOMO_MERCHANT_ID ?? "";
  const env = (process.env.HUBBLE_MOMO_ENV ?? "sandbox") as HubbleMomoEnv;
  return { apiKey, merchantId, env };
}

export function isHubbleMomoConfigured(): boolean {
  const { apiKey, merchantId } = getConfig();
  return Boolean(apiKey && merchantId);
}

/**
 * Initialize a Momo payment session.
 * Uses live API when configured; otherwise returns sandbox mock for dev/demo.
 */
export async function initMomoPayment(
  request: MomoInitRequest
): Promise<MomoPaymentSession> {
  const { apiKey, merchantId, env } = getConfig();

  if (apiKey && merchantId) {
    const baseUrl =
      env === "production"
        ? "https://api.myhubble.money/v1/momo"
        : "https://sandbox.api.myhubble.money/v1/momo";

    const res = await fetch(`${baseUrl}/payments/init`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${apiKey}`,
        "X-Merchant-Id": merchantId,
      },
      body: JSON.stringify(request),
    });

    if (!res.ok) {
      const err = await res.text().catch(() => "Unknown error");
      throw new Error(`Hubble Momo init failed (${res.status}): ${err}`);
    }

    return res.json() as Promise<MomoPaymentSession>;
  }

  const sessionId = `momo_sandbox_${Date.now()}`;
  console.info("[Hubble Momo sandbox]", {
    sessionId,
    ...request,
    env,
  });

  return {
    sessionId,
    status: "pending",
    qrCodeUrl: undefined,
    deepLink: `momo://pay?session=${sessionId}&amount=${request.amount}`,
    expiresAt: new Date(Date.now() + 15 * 60 * 1000).toISOString(),
    message: "Complete payment on your phone",
  };
}

export async function getMomoPaymentStatus(
  sessionId: string
): Promise<MomoPaymentSession["status"]> {
  const { apiKey, merchantId, env } = getConfig();

  if (apiKey && merchantId) {
    const baseUrl =
      env === "production"
        ? "https://api.myhubble.money/v1/momo"
        : "https://sandbox.api.myhubble.money/v1/momo";

    const res = await fetch(`${baseUrl}/payments/${sessionId}`, {
      headers: {
        Authorization: `Bearer ${apiKey}`,
        "X-Merchant-Id": merchantId,
      },
    });

    if (!res.ok) return "failed";
    const data = (await res.json()) as MomoPaymentSession;
    return data.status;
  }

  return "pending";
}
