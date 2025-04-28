<?php

namespace App\Http\Controllers;

use App\Models\Payment;
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
        Log::channel('webhook')->info('Stripe webhook starts');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET'); // from Stripe dashboard

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

            Log::channel('webhook')->info('Stripe webhook event');
            Log::channel('webhook')->info($event);


        } catch (\Exception $e) {
            Log::channel('webhook')->info('Invalid signature');
            return response('Invalid signature', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;

            Log::channel('webhook')->info('Payment intent data');
            Log::channel('webhook')->info($intent);
            Log::channel('webhook')->info($intent->id);
            Log::channel('webhook')->info($intent->amount);

            $payment_details = [
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
            ];

            Log::channel('webhook')->info('Payment data');
            Log::channel('webhook')->info(json_encode($payment_details));

            // Save to database
            $payment = Payment::create($payment_details);

            Log::channel('webhook')->info('Payment data save');
            Log::channel('webhook')->info($payment);

            if($payment) {

                Log::channel('webhook')->info('Payment data saved');
                Log::channel('webhook')->info($payment);

                $plan_data = Plan::where('id', $intent->metadata->plan_id)->first();

                Log::channel('webhook')->info('plan data');
                Log::channel('webhook')->info($plan_data);

                $subscription_data = [
                    'plan_id'       => $intent->metadata->plan_id,
                    'user_id'       => $intent->metadata->user_id,
                    'start_date'    => Carbon::now()->format('Y-m-d'),
                    'end_date'      => Carbon::now()->addMonths($plan_data->month_no)->format('Y-m-d'),
                    'payment_id'    => $payment->id
                ];

                Log::channel('webhook')->info('subscription data');
                Log::channel('webhook')->info(json_encode($subscription_data));

                $saveSub = Subscription::create($subscription_data);

                Log::channel('webhook')->info('subscription data save');
                Log::channel('webhook')->info($saveSub);
            }
        }
        Log::channel('webhook')->info('Webhook ends');
        return response()->json(['status' => 'success']);
    }
}
