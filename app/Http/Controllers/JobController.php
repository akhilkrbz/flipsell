<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Location;
use App\Models\JobRequest;
use App\Models\RequestsUpdate;



class JobController extends Controller
{
    public function jobRequests(Request $request)
    {
        Log::info('Job Request API Hit', $request->all());
    
        try {
            // Validate the request
            $request->validate([
                'job_id' => 'required|integer|exists:job_requests,id',
                'status' => 'required|in:0,1,2', // 0 = Rejected, 1 = Pending, 2 = Accepted
            ]);
    
            // Get authenticated user
            $user = auth('api')->user();
    
            // Prepare data to insert into requests_update table
            $data = [
                'job_id' => $request->job_id,
                'business_id' => $user->id,
                'status' => $request->status,
                'accepted_time' => $request->status == 1 ? Carbon::now() : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
    
            // Insert data into requests_update table
            $requestUpdate = RequestsUpdate::create($data);
    
            return response()->json([
                'success' => true,
                'message' => 'Job request inserted successfully.',
                'request_update' => $requestUpdate
            ]);
    
        } catch (\Throwable $th) {
            Log::error('Job Request Error:', ['exception' => $th->getMessage()]);
    
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'exception' => $th->getMessage()
            ], 500);
        }
    }


public function getJobDetails(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
            ]);

            $user_id = $request->user_id;

            // Fetch user details
            $user = User::select('name', 'email', 'mobile', 'location')->where('id', $user_id)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Fetch country name from locations table
            $location = Location::where('id', $user->location)->first();
            $country_name = $location ? $location->country_name : null;

            // Fetch job requests for the user
            $jobRequests = JobRequest::where('user_id', $user_id)
                ->select('description', 'flexible', 'looking_for', 'location', 'tags', 'distance_limit','budget','created_at')
                ->get();

            return response()->json([
                'success' => true,
                'user_details' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'country_name' => $country_name
                ],
                'job_requests' => $jobRequests
            ]);
        } catch (\Throwable $th) {
            Log::error('Error fetching job details:', ['exception' => $th->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'exception' => $th->getMessage()
            ], 500);
        }
    }
}
