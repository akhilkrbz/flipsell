<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info('Stripe webhook starts');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET'); // from Stripe dashboard

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

            Log::info('Stripe webhook event');
            Log::info($event);


        } catch (\Exception $e) {
            Log::info('Invalid signature');
            return response('Invalid signature', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;

            Log::info('Payment intent data');
            Log::info($intent);

            // Save to database
            $payment = \App\Models\Payment::create([
                'payment_intent_id'     => $intent->id,
                'amount_paid'           => $intent->amount / 100,
                'currency'              => $intent->currency,
                'payment_status'        => $intent->status,
                'user_id'               => $intent->metadata->user_id ?? null,
                'transaction_id'        => '',
                'receipt_url'           => '',
                'order_id'              => '',
                'plan_id'               => $intent->metadata->plan_id ?? null,
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now(),

            ]);

            if($payment) {

                $plan_data = Plan::where('id', $intent->metadata->plan_id)->first();

                $subscription_data = [
                    'plan_id'       => $intent->metadata->plan_id,
                    'user_id'       => $intent->metadata->user_id,
                    'start_date'    => Carbon::now()->format('Y-m-d'),
                    'end_date'      => Carbon::now()->addMonths($plan_data->month_no)->format('Y-m-d'),
                    'payment_id'    => $payment->id
                ];

                Subscription::create($subscription_data);
            }
        }
        Log::info('Webhook ends');
        return response()->json(['status' => 'success']);
    }
}
