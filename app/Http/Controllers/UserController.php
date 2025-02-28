<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use App\Models\ServiceProvider;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
   
    public function getUserDetails(Request $request)
    {
        // Get authenticated user
        $user = auth('api')->user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Fetch country name from locations table
        $location = Location::where('id', $user->location)->first();
        $country_name = $location ? $location->country_name : null;
    
        $userDetails = [
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'image' => $user->image,
            'verification_image1' => $user->verification_image1,
            'verification_image2' => $user->verification_image2,
            'status' => $user->status,
            'verification_status' => $user->verification_status,
            'location' => $country_name,
            'usertype' => $user->usertype
        ];
    
        // If usertype is 1, fetch service provider details
        if ($user->usertype == 1) {
            $serviceProvider = ServiceProvider::where('user_id', $user->id)->first();
    
            if ($serviceProvider) {
                // Decode category_id and subcategory_id from JSON format
                $categoryIds = json_decode($serviceProvider->category_id, true) ?? [];
                $subcategoryIds = json_decode($serviceProvider->subcategory_id, true) ?? [];
    
                // Fetch category names
                $categories = Category::whereIn('id', $categoryIds)->pluck('category_name')->toArray();
                $subcategories = Category::whereIn('id', $subcategoryIds)->pluck('category_name')->toArray();
    
                $userDetails['service_provider'] = [
                    'category_names' => $categories,
                    'subcategory_names' => $subcategories,
                    'website' => $serviceProvider->website,
                    'business_image' => $serviceProvider->business_image,
                    'business_name' => $serviceProvider->business_name,
                    'business_phone' => $serviceProvider->business_phone,
                    'business_email' => $serviceProvider->business_email,
                    'status' => $serviceProvider->status,
                    'reg_document' => $serviceProvider->reg_document,
                    'gst_number' => $serviceProvider->gst_number,
                ];
            }
        }
    
        // Fetch user's subscription
        $subscription = Subscription::where('user_id', $user->id)->first();
    
        if ($subscription) {
            $plan = Plan::where('id', $subscription->plan_id)->first();
    
            if ($plan) {
                $userDetails['current_plan'] = [
                    'plan_name' => $plan->plan_name,
                    'month_no' => $plan->month_no,
                    'price' => $plan->price,
                    'description' => $plan->description
                ];
            }
        } else {
            $userDetails['current_plan'] = null; // If no subscription, return null
        }
    
        return response()->json($userDetails, 200);
    }

    public function photoAction(Request $request)
    {
        $userId = auth('api')->id();
    
        if (!$userId) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }
    
        $user = User::where('id', $userId)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => 'User not found'
            ], 404);
        }
    
        function storeImage($file)
        {
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Define the destination path in the public folder
            $destinationPath = public_path('assets/images');
    
            // Move the file to public/assets/images
            $file->move($destinationPath, $fileName);
    
            // Return full URL
            return asset('assets/images/' . $fileName);
        }
    
        try {
            // ✅ Handle profile/business image upload
            if ($request->hasFile('image')) {
                $imagePath = storeImage($request->file('image'));
    
                if ($request->image_type === 'business_image') {
                    $provider = ServiceProvider::where('user_id', $userId)->first();
                    if (!$provider) {
                        return response()->json([
                            'success' => false,
                            'status' => 404,
                            'message' => 'Service provider not found'
                        ], 404);
                    }
                    $provider->business_image = $imagePath;
                    $provider->save();
                } else {
                    $user->image = $imagePath;
                }
            }
    
            // ✅ Handle verification images
            if ($request->hasFile('verification_image1')) {
                $user->verification_image1 = storeImage($request->file('verification_image1'));
            }
    
            if ($request->hasFile('verification_image2')) {
                $user->verification_image2 = storeImage($request->file('verification_image2'));
            }
    
            // Save user changes
            $user->save();
    
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Images uploaded successfully',
                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    
    

}
