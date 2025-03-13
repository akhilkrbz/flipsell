<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Validator;

class NotificationPreferenceController extends Controller
{
    public function notificationPreferences()
    {
        try {
            // Get authenticated user
            $user = auth('api')->user();
    
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access',
                ], 401);
            }
    
            // Fetch all main categories (where sub_of is NULL or 0)
            $categories = Category::whereNull('sub_of')
                ->orWhere('sub_of', 0)
                ->get();
    
            // Map categories with subcategories
            $data = $categories->map(function ($category) use ($user) {
                // Fetch subcategories for each category where sub_of is not null or 0
                $subcategories = Category::where('sub_of', $category->id)->get();
    
                // Map subcategories with chosen status
                $subcategoriesData = $subcategories->map(function ($subcategory) use ($user) {
                    $chosen = Subcategory::where('user_id', $user->id)
                        ->where('subcategory', $subcategory->id)
                        ->where('chosen', 1)
                        ->exists() ? 1 : 0;
    
                    return [
                        'id' => $subcategory->id,
                        'name' => $subcategory->category_name,
                        'chosen' => $chosen,
                    ];
                });
    
                return [
                    'id' => $category->id,
                    'name' => $category->category_name,
                    'subcategories' => $subcategoriesData,
                ];
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Notification Preferences Fetched Successfully',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'exception' => $th->getMessage(),
            ], 500);
        }
    }
    

public function updateNotificationStatus(Request $request)
{
    $user = auth('api')->user(); // Get authenticated user

    // Validate the request
    $validator = Validator::make($request->all(), [
        'subcategory' => 'required|exists:categories,id',
        'chosen'      => 'required|in:0,1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422);
    }

    try {
        // Check if the subcategory exists for the user
        $subcategory = Subcategory::where('user_id', $user->id)
            ->where('subcategory', $request->subcategory)
            ->first();

        if ($subcategory) {
            // Update existing record
            $subcategory->update(['chosen' => $request->chosen]);
        } else {
            // Insert new record
            Subcategory::create([
                'user_id'     => $user->id,
                'subcategory' => $request->subcategory,
                'chosen'      => $request->chosen,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification status updated successfully',
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'success'   => false,
            'message'   => 'Something went wrong!',
            'exception' => $th->getMessage(),
        ], 500);
    }
}



}
