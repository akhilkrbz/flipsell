<?php

namespace App\Http\Controllers;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
{
    $plans = Plan::all()->map(function ($plan) {
        return [
            'id' => $plan->id,
            'name' => $plan->plan_name,
            'price' => $plan->price,
            'month_no' => $plan->month_no,
            'per_month_cost' => ($plan->month_no > 0) ? round($plan->price / $plan->month_no, 2) : 0, // Prevent division by zero
        ];
    });

    return response()->json([
        'success' => 'success',
        'data' => $plans
    ], 200);
}

}
