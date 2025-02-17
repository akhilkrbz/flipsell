<?php

namespace App\Http\Controllers;
use App\Models\Ad;

use Illuminate\Http\Request;

class AdController extends Controller
{
    public function getAllAds()
    {
        // Get all records from the ads table
        $ads = Ad::all();

        // Transform each ad to change the keys and include id, image, and link
        $ads = $ads->map(function($ad) {
            return [
                'id' => $ad->id, 
                'image1' => $ad->image,  // Example of image column if needed
                'link2' => $ad->link,         // Include the ad ID
                'image2' => $ad->image1,
                'link2' => $ad->link1,
                'image3' => $ad->image2,
                'link3' => $ad->link2,
                 // Example of link column if needed
            ];
        });

        // Return the response with a success message and the ads data
        return response()->json([
            'success' => "success",       // Success flag
            'message' => 'Ads fetched successfully.', // Success message
            'data' => $ads           // The transformed ads data
        ]);
    }
}
