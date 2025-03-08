<?php

namespace App\Http\Controllers;

use App\Models\JobRequest;
use App\Models\ServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobRequestsController extends Controller
{
    public function RequestService(Request $request)
    {
        Log::info('Registration API Hit');
    
        try {

            $user = auth('api')->user(); 

            $image_1 = '';
            $image_2 = '';
            $image_3 = '';

            if($request->hasFile('image_1')){
                $c = $request->file('image_1');
                $filename = uniqid() . '.' . $c->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/images');
                $c->move($destinationPath, $filename);
                $image_1 = '/uploads/images/' . $filename;
            }

            if($request->hasFile('image_2')){
                $c = $request->file('image_2');
                $filename = uniqid() . '.' . $c->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/images');
                $c->move($destinationPath, $filename);
                $image_2 = '/uploads/images/' . $filename;
            }

            if($request->hasFile('image_3')){
                $c = $request->file('image_3');
                $filename = uniqid() . '.' . $c->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/images');
                $c->move($destinationPath, $filename);
                $image_3 = '/uploads/images/' . $filename;
            }

            $details = [
                'budget'            => $request->budget,
                'category_id'       => $request->category_id,
                'subcategory_id'    => $request->subcategory_id,
                'description'       => $request->description,
                'flexible'          => $request->flexible,
                'looking_for'       => $request->looking_for,
                'location'          => $request->location,
                'location_langitude'          => $request->location_langitude,
                'location_longitude'          => $request->location_longitude,
                'tags'              => $request->tags,
                'distance_limit'    => $request->distance_limit,
                'user_id'           => $user->id,
                'status'            => 0,
                'business_id'       => $request->business_id,
                'job_date'          => $request->job_date ? Carbon::createFromFormat('d-m-Y H:i:s', $request->job_date)->format('Y-m-d H:i:s') : '',
                'job_date_flexible' => $request->job_date_flexible,
                'address'           => $request->address,
                'image_1'           => $image_1,
                'image_2'           => $image_2,
                'image_3'           => $image_3,
                'full_screen_image' => $request->full_screen_image,
                'connect_type'      => $request->connect_type,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ];
            
            JobRequest::create($details);

            return response()->json([
                'status'    => 200,
                'success'   => true,
                'message'   => 'Service requested successfully.'
            ]);


        } catch (\Throwable $th) {
    
            Log::error('Error:', [
                'exception' => $th->getMessage(),
                'code'      => $th->getCode(),
            ]);
    
            return response()->json([
                'success'   => false,
                'message'   => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code'      => $th->getCode(),
            ]);
        }
    }


    public function requestList(Request $request)
    {
        Log::info('Job request list');
    
        try {
            if($request->type == 1) {       //All requests
                $user = auth('api')->user();

                // $user_service_details = ServiceProvider::where('user_id', $user->id)->first();
                // $user_subcat_ids = $user_service_details->subcategory_id;

                // $user_latitude = $user->location_latitude;
                // $user_longitude = $user->location_longitude;

                // $jobRequests = DB::table('job_requests as jr')
                // ->select('jr.*', DB::raw('(6371 * acos(cos(radians(jr.location_langitude)) 
                //         * cos(radians('.$user_latitude.')) 
                //         * cos(radians('.$user_longitude.') - radians(jr.location_longitude)) 
                //         + sin(radians(jr.location_langitude)) 
                //         * sin(radians('.$user_latitude.')))) AS distance'))
                // ->whereRaw('(6371 * acos(cos(radians(jr.location_langitude)) 
                //         * cos(radians('.$user_latitude.')) 
                //         * cos(radians('.$user_longitude.') - radians(jr.location_longitude)) 
                //         + sin(radians(jr.location_langitude)) 
                //         * sin(radians('.$user_latitude.')))) <= jr.distance_limit')
                // ->whereIn('jr.subcategory_id', $user_subcat_ids)
                // ->where('jr.accepted_time', null)
                // ->get();

                if($user->id) {
                    $user_service_details = ServiceProvider::where('user_id', $user->id)->first();
                    $user_subcat_ids = $user_service_details->subcategory_id ? json_decode($user_service_details->subcategory_id, true) : [];
    
                    $user_latitude = $user->location_latitude;
                    $user_longitude = $user->location_longitude;
    
                    // Base query
                    $jobRequests = DB::table('job_requests as jr')
                        ->select('jr.*', DB::raw('(6371 * acos(cos(radians(jr.location_langitude)) 
                                * cos(radians('.$user_latitude.')) 
                                * cos(radians('.$user_longitude.') - radians(jr.location_longitude)) 
                                + sin(radians(jr.location_langitude)) 
                                * sin(radians('.$user_latitude.')))) AS distance'))
                        ->whereIn('jr.subcategory_id', (array)$user_subcat_ids)
                        ->where('jr.updated_at', '>=', date('Y-m-d'))
                        ->where('jr.accepted_time', null);
    
                    // Apply distance condition only if distance_limit > 0
                    $jobRequests = $jobRequests->where(function ($query) use ($user_latitude, $user_longitude) {
                        $query->where('jr.distance_limit', 0)
                            ->orWhereRaw('(6371 * acos(cos(radians(jr.location_langitude)) 
                                * cos(radians(?)) 
                                * cos(radians(?) - radians(jr.location_longitude)) 
                                + sin(radians(jr.location_langitude)) 
                                * sin(radians(?)))) <= jr.distance_limit', 
                                [$user_latitude, $user_longitude, $user_latitude]);
                    });
    
                    // Execute query
                    $jobRequests = $jobRequests->get();
    
                    // return $jobRequests;
    
                    return response()->json([
                        'status'    => 200,
                        'success'   => true,
                        'data'      => $jobRequests
                    ]);
                } else {
                    return response()->json([
                        'status'    => 200,
                        'success'   => false,
                        'message'      => 'User not found'
                    ]);
                }
                


            } else if($request->type == 2) {    //Accepted requests
                // $job_reqs = JobRequest::where('accepted_time', '!=', null)->
            } else {
                return response()->json([
                    'status'    => 200,
                    'success'   => false,
                    'message'   => 'Invalid type.'
                ]);
            }
        } catch (\Throwable $th) {
    
            Log::error('Error:', [
                'exception' => $th->getMessage(),
                'code'      => $th->getCode(),
            ]);
    
            return response()->json([
                'success'   => false,
                'message'   => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code'      => $th->getCode(),
            ]);
        }
    }
}
