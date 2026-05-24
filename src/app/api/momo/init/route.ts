import { NextResponse } from "next/server";
import { initMomoPayment, type MomoInitRequest } from "@/lib/hubble-momo";

export async function POST(req: Request) {
  try {
    const body = (await req.json()) as MomoInitRequest;
    if (!body.amount || !body.currency || !body.orderId) {
      return NextResponse.json(
        { error: "amount, currency, and orderId are required" },
        { status: 400 }
      );
    }
    const session = await initMomoPayment(body);
    return NextResponse.json(session);
  } catch (e) {
    const message = e instanceof Error ? e.message : "Payment init failed";
    return NextResponse.json({ error: message }, { status: 500 });
  }
}
