<?php
// WEB APP: app/Http/Controllers/Payment/WebPaymentController.php
// Proxies payment requests from Web → Main, handles redirect + callback page

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\Support\Facades\{Http, Log, Session};

class WebPaymentController extends Controller
{
    private function mainApi(): string
    {
        return rtrim(config('api.main_app.api_base'), '/');
    }

    private function token(): string
    {
        return session('api_token', '');
    }

    // ─────────────────────────────────────────────────────────────────────
    // POST /payment/initiate
    // Called by the Web payment modal "Pay with Pesapal" button
    // ─────────────────────────────────────────────────────────────────────
    public function initiate(Request $request)
    {
        // If AJAX, return JSON validation errors instead of redirect
        $validated = $request->validate([
            'plan'         => 'required|string|in:seeker_basic,seeker_pro,seeker_elite',
            'period'       => 'required|string|in:monthly,yearly',
            'amount_usd'   => 'required|numeric|min:1',
            'currency'     => 'required|string|size:3',
            'amount_local' => 'required|numeric|min:1',
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'required|email',
            'phone'        => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:3',
        ]);

        try {
            $response = Http::withoutVerifying()
                ->withToken($this->token())
                ->timeout(30)
                ->post($this->mainApi() . '/v1/payments/initiate', $validated);

            $data = $response->json();

            if (!$response->successful() || empty($data['redirect_url'])) {
                Log::error('[WebPayment] Initiate failed', ['response' => $data]);

                // Return JSON if AJAX, otherwise redirect back
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $data['message'] ?? 'Payment initiation failed. Please try again.'
                    ], 422);
                }
                return back()->with('error', $data['message'] ?? 'Payment initiation failed.');
            }

            Session::put('payment_reference',      $data['merchant_reference']);
            Session::put('payment_plan',           $validated['plan']);
            Session::put('payment_order_tracking', $data['order_tracking_id']);

            Log::info('[WebPayment] Redirecting to Pesapal', [
                'reference'    => $data['merchant_reference'],
                'redirect_url' => $data['redirect_url'],
            ]);

            // Return redirect URL as JSON for AJAX caller
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success'      => true,
                    'redirect_url' => $data['redirect_url'],
                ]);
            }

            return redirect()->away($data['redirect_url']);

        } catch (\Exception $e) {
            Log::error('[WebPayment] Initiate exception', ['error' => $e->getMessage()]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again.'
                ], 500);
            }
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    // ─────────────────────────────────────────────────────────────────────
    // GET /payment/callback
    // Pesapal redirects customer here after payment
    // ─────────────────────────────────────────────────────────────────────
    public function callback(Request $request)
    {
        $orderTrackingId   = $request->get('OrderTrackingId');
        $merchantReference = $request->get('OrderMerchantReference');
        $reference         = $merchantReference ?? session('payment_reference');

        Log::info('[WebPayment] Callback', [
            'OrderTrackingId'       => $orderTrackingId,
            'OrderMerchantReference'=> $merchantReference,
        ]);

        // Ask Main to check Pesapal status and update the transaction
        $statusData = null;
        try {
            $res = Http::withoutVerifying()
                ->withToken($this->token())
                ->timeout(15)
                ->get($this->mainApi() . '/v1/payments/callback', [
                    'OrderTrackingId'        => $orderTrackingId,
                    'OrderMerchantReference' => $merchantReference,
                    'OrderNotificationType'  => 'CALLBACKURL',
                ]);

            $statusData = $res->json();
        } catch (\Exception $e) {
            Log::error('[WebPayment] Callback status check failed', ['error' => $e->getMessage()]);
        }

        // Pass everything to a clean result view
        return view('payment.result', [
            'status'    => $statusData['status']          ?? 'pending',
            'plan'      => $statusData['plan']            ?? session('payment_plan'),
            'amount'    => $statusData['amount']          ?? null,
            'reference' => $reference,
            'tracking'  => $orderTrackingId,
            'confirmation_code' => $statusData['confirmation_code'] ?? null,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // GET /payment/status/{reference}   (AJAX poll from result page)
    // ─────────────────────────────────────────────────────────────────────
    public function status(Request $request, string $reference)
    {
        try {
            $res = Http::withoutVerifying()
                ->withToken($this->token())
                ->timeout(15)
                ->get($this->mainApi() . '/v1/payments/status/' . $reference);

            return response()->json($res->json(), $res->status());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────
    // GET /payment/cancelled
    // ─────────────────────────────────────────────────────────────────────
    public function cancelled()
    {
        return view('payment.cancelled');
    }
}