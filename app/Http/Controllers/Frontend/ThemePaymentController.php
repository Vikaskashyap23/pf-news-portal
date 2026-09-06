<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Models\ThemeOrder;
use App\Models\Website;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Razorpay\Api\Api;

class ThemePaymentController extends Controller
{
    /**
     * Show customer details form
     */
    public function checkout($websiteSlug, $themeId)
    {
        $website = Website::where('slug', $websiteSlug)
            ->firstOrFail();

        $theme = Theme::where('id', $themeId)
            ->where('status', 1)
            ->where('type', 'premium')
            ->firstOrFail();

        $amount = (float) $theme->price;

        if ($amount <= 0) {
            return back()->with('error', 'Invalid theme price.');
        }

        return view('frontend.themes.checkout', compact(
            'website',
            'theme'
        ));
    }

    /**
     * Validate customer details and create Razorpay order
     */
    public function startPayment(Request $request, $websiteSlug, $themeId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $website = Website::where('slug', $websiteSlug)
            ->firstOrFail();

        $theme = Theme::where('id', $themeId)
            ->where('status', 1)
            ->where('type', 'premium')
            ->firstOrFail();

        $amount = (float) $theme->price;

        if ($amount <= 0) {
            return back()->with('error', 'Invalid theme price.');
        }

        /*
         * Check whether this email already belongs to
         * an admin/staff account.
         */
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && $existingUser->role !== 'customer') {
            return back()
                ->withInput($request->except('password'))
                ->with('error', 'This email is already registered as an admin/staff account. Please use another email.');
        }

        /*
         * Store customer details temporarily in session.
         * Password is stored encrypted in the session by Laravel's
         * session mechanism and will be hashed when the customer
         * account is created after successful payment.
         */
        session([
            'theme_customer' => [

                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'customer_mobile' => $request->mobile,
                'customer_password' => Hash::make($request->password),
            ],
        ]);

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $razorpayOrder = $api->order->create([
            'receipt' => 'THEME-' . $theme->id . '-' . time(),
            'amount' => (int) round($amount * 100),
            'currency' => 'INR',
        ]);

        $order = ThemeOrder::create([
            'user_id' => null,
            'website_id' => $website->id,
            'theme_id' => $theme->id,
            'amount' => $amount,
            'gateway' => 'razorpay',
            'razorpay_order_id' => $razorpayOrder['id'],
            'status' => 'pending',
        ]);

        return view('frontend.themes.checkout', compact(
            'website',
            'theme',
            'order',
            'razorpayOrder'
        ));
    }

    /**
     * Verify payment
     */
    public function success(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $order = ThemeOrder::where(
            'razorpay_order_id',
            $request->razorpay_order_id
        )->firstOrFail();

        if ($order->status === 'paid') {
            return redirect()
                ->route('frontend.themes', $order->website->slug)
                ->with('success', 'Theme is already activated.');
        }

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {

            /*
             * Server-side Razorpay signature verification
             */
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            /*
             * Get customer details from session
             */
            $customerData = session('theme_customer');

            if (!$customerData) {
                throw new \Exception('Customer details not found.');
            }

            /*
             * Find existing customer by email.
             * If not found, create a new customer account.
             */
            $customer = User::where('email', $customerData['email'])
                ->where('role', 'customer')
                ->first();

            if (!$customer) {

                $customer = User::create([
                    'name' => $customerData['name'],
                    'email' => $customerData['email'],
                    'mobile' => $customerData['mobile'],
                    'password' => Hash::make($customerData['password']),
                    'role' => 'customer',
                    'status' => true,
                ]);

            } else {

                /*
                 * Existing customer:
                 * update name/mobile only.
                 * Existing password remains unchanged.
                 */
                $customer->update([
                    'name' => $customerData['name'],
                    'mobile' => $customerData['mobile'],
                ]);
            }

            /*
             * Link payment with customer
             */
            $order->update([
                'user_id' => $customer->id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            /*
             * Activate purchased theme
             */
            $website = $order->website;

            $website->theme_id = $order->theme_id;
            $website->save();

            /*
             * Remove customer details from session
             */
            session()->forget('theme_customer');

            return redirect()
                ->route('frontend.themes', $website->slug)
                ->with(
                    'success',
                    'Payment successful! Theme activated successfully.'
                );

        } catch (\Exception $e) {

            $order->update([
                'status' => 'failed',
            ]);

            return redirect()
                ->route(
                    'frontend.themes',
                    $order->website->slug
                )
                ->with(
                    'error',
                    'Payment verification failed.'
                );
        }
    }

    /**
     * Payment failed / cancelled
     */
    public function failed($websiteSlug)
    {
        session()->forget('theme_customer');

        return redirect()
            ->route(
                'frontend.themes',
                $websiteSlug
            )
            ->with(
                'error',
                'Payment was cancelled or failed.'
            );
    }


    public function webhook(Request $request)
{
    $webhookSecret = config('services.razorpay.webhook_secret');

    $signature = $request->header('X-Razorpay-Signature');

    if (!$signature || !$webhookSecret) {
        return response()->json([
            'message' => 'Invalid webhook configuration.'
        ], 400);
    }

    $rawBody = $request->getContent();

    $expectedSignature = hash_hmac(
        'sha256',
        $rawBody,
        $webhookSecret
    );

    if (!hash_equals($expectedSignature, $signature)) {
        return response()->json([
            'message' => 'Invalid webhook signature.'
        ], 400);
    }

    $payload = json_decode($rawBody, true);

    if (!is_array($payload)) {
        return response()->json([
            'message' => 'Invalid payload.'
        ], 400);
    }

    $event = $payload['event'] ?? null;

    if ($event !== 'order.paid') {
        return response()->json([
            'message' => 'Event ignored.'
        ], 200);
    }

    $razorpayOrderId =
        $payload['payload']['order']['entity']['id'] ?? null;

    $razorpayPaymentId =
        $payload['payload']['payment']['entity']['id'] ?? null;

    if (!$razorpayOrderId || !$razorpayPaymentId) {
        return response()->json([
            'message' => 'Missing payment information.'
        ], 400);
    }

    $order = ThemeOrder::where(
        'razorpay_order_id',
        $razorpayOrderId
    )->first();

    if (!$order) {
        return response()->json([
            'message' => 'Order not found.'
        ], 404);
    }

    // Duplicate webhook/payment protection
    if ($order->status === 'paid') {
        return response()->json([
            'message' => 'Order already processed.'
        ], 200);
    }

    $razorpayAmount =
        $payload['payload']['order']['entity']['amount'] ?? null;

    $expectedAmount = (int) round(
        ((float) $order->amount) * 100
    );

    if ((int) $razorpayAmount !== $expectedAmount) {
        return response()->json([
            'message' => 'Amount mismatch.'
        ], 400);
    }

    $order->update([
        'razorpay_payment_id' => $razorpayPaymentId,
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    $customer = User::where(
        'email',
        $order->customer_email
    )
    ->where('role', 'customer')
    ->first();

    if (!$customer) {

        $customer = User::create([
            'name' => $order->customer_name,
            'email' => $order->customer_email,
            'mobile' => $order->customer_mobile,
            'password' => $order->customer_password,
            'role' => 'customer',
            'status' => true,
        ]);

    } else {

        $customer->update([
            'name' => $order->customer_name,
            'mobile' => $order->customer_mobile,
        ]);
    }

    $order->update([
        'user_id' => $customer->id,
    ]);

    $website = $order->website;

    if ($website) {
        $website->theme_id = $order->theme_id;
        $website->save();
    }

    return response()->json([
        'message' => 'Webhook processed successfully.'
    ], 200);
}

}