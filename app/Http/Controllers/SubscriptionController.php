<?php

namespace App\Http\Controllers;
use App\Models\Subscription;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function activatePlan(Request $request)
    {
        // Authenticate user
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        // Validate input
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'payment_id' => 'required|string'
        ]);

        // Fetch plan details
        $plan = Plan::find($request->plan_id);
        if (!$plan) {
            return response()->json(['success' => false, 'message' => 'Plan not found'], 404);
        }

        // Calculate subscription duration
        $start_date = Carbon::now();
        $end_date = Carbon::now()->addMonths($plan->month_no);

        // Insert into subscriptions table
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $request->plan_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'payment_id' => $request->payment_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Plan activated successfully',
            'subscription' => $subscription
        ]);
    }


    public function viewUserPlan()
{
    // Get the authenticated user
    $user = auth('api')->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access'
        ], 401);
    }

    // Fetch the user's latest subscription
    $subscription = Subscription::where('user_id', $user->id)->latest()->first();

    if (!$subscription) {
        return response()->json([
            'success' => false,
            'message' => 'No active subscription found'
        ]);
    }

    // Fetch the plan details
    $plan = Plan::find($subscription->plan_id);

    if (!$plan) {
        return response()->json([
            'success' => false,
            'message' => 'Plan not found'
        ]);
    }

    // Return subscription and plan details (flattened structure)
    return response()->json([
        'success' => true,
        'start_date' => $subscription->start_date,
        'end_date' => $subscription->end_date,
        'plan_name' => $plan->plan_name,
        'month_no' => $plan->month_no,
        'price' => $plan->price,
        'currency' => $plan->currency,
        'symbol' => $plan->symbol,
        'description' => $plan->description
    ]);
}

}

