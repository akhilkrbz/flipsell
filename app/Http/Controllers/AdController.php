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
    
        // Group ads by 'add_set'
        $groupedAds = $ads->groupBy('add_set');
    
        // Transform the grouped ads to the desired structure
        $formattedAds = $groupedAds->mapWithKeys(function ($ads, $addSet) {
            return [
                $addSet => $ads->flatMap(function ($ad) {
                    return [
                        ['image' => $ad->image, 'link' => $ad->link],
                        ['image' => $ad->image1, 'link' => $ad->link1],
                        ['image' => $ad->image2, 'link' => $ad->link2]
                    ];
                })->values() // Reset keys for each ad set
            ];
        });
    
        // Return the response with a success message and the formatted ads data
        return response()->json([
            'success' => "success",
            'message' => 'Ads fetched successfully.',
            'data' => $formattedAds
        ]);
    }
    
    

}



