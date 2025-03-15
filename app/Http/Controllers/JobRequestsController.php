<?php

namespace App\Http\Controllers;

use App\Models\JobRequest;
use App\Models\RequestsUpdate;
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
            $user = auth('api')->user();
            if($request->type == 1) {       //All requests

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
                        // ->where('jr.updated_at', '>=', date('Y-m-d'))
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
                    })->orderBy('jr.updated_at', 'desc');
    
                    // Execute query
                    $jobRequests = $jobRequests->get();
    
                    // return $jobRequests;

                    foreach($jobRequests as $key => $job) {
                        $jobRequests[$key]->images = array_filter([
                            $job->image_1 ? asset($job->image_1) : '', 
                            $job->image_2 ? asset($job->image_2) : '', 
                            $job->image_3 ? asset($job->image_3) : '']);
                    }
    
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
                // return $job_reqs = RequestsUpdate::where(['business_id' => $user->id, 'status' => 1])->with('accepted_job_request')->get();
                $job_reqs = JobRequest::whereHas('request_update', function($q1) use ($user) {
                    return $q1->where(['status' => 1, 'business_id' => $user->id]);
                })->with(['category', 'sub_category', 'request_update.service_provider_data.service_details'])->get();


                foreach($job_reqs as $key => $job) {
                    $job_reqs[$key]->images = array_filter([
                        $job->image_1 ? asset($job->image_1) : '', 
                        $job->image_2 ? asset($job->image_2) : '', 
                        $job->image_3 ? asset($job->image_3) : '']);
                }

                return response()->json([
                    'status'    => 200,
                    'success'   => true,
                    'data'      => $job_reqs
                ]);


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


    //userRequestList
    public function userRequestList(Request $request)
    {
        Log::info('User Job request list');
    
        try {
            $user = auth('api')->user();
            if($request->type == 1) {       //Pending
                // $job_reqs = JobRequest::User($user->id)->Pending()->with(['category', 'sub_category'])->get();


                $job_reqs = JobRequest::User($user->id)->whereDoesntHave('request_update')->with(['category', 'sub_category', 'request_update.service_provider_data.service_details'])->get();

                foreach($job_reqs as $key => $job) {
                    $job_reqs[$key]->images = array_filter([
                        $job->image_1 ? asset($job->image_1) : '', 
                        $job->image_2 ? asset($job->image_2) : '', 
                        $job->image_3 ? asset($job->image_3) : '']);
                }

                return response()->json([
                    'status'    => 200,
                    'success'   => true,
                    'data'      => $job_reqs
                ]);

            } else if($request->type == 2) {            //Accepted
                // $job_reqs = JobRequest::User($user->id)->Accepted()->with(['category', 'sub_category'])->get();

                $job_reqs = JobRequest::User($user->id)->whereHas('request_update', function($q1) use ($user) {
                    return $q1->where(['status' => 1]);
                })->with(['category', 'sub_category', 'request_update.service_provider_data.service_details'])->get();

                foreach($job_reqs as $key => $job) {
                    $job_reqs[$key]->images = array_filter([
                        $job->image_1 ? asset($job->image_1) : '', 
                        $job->image_2 ? asset($job->image_2) : '', 
                        $job->image_3 ? asset($job->image_3) : '']);
                }

                return response()->json([
                    'status'    => 200,
                    'success'   => true,
                    'data'      => $job_reqs
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

    //jobRequestDetails
    public function jobRequestDetails(Request $request)
    {
        Log::info('User Job request list');
    
        try {

            $user = auth('api')->user();

            $job_data = JobRequest::where('id', $request->request_id)->with(['category', 'sub_category', 'user_data'])->first();

            $job_data->images = array_filter([
                $job_data->image_1 ? asset($job_data->image_1) : '', 
                $job_data->image_2 ? asset($job_data->image_2) : '', 
                $job_data->image_3 ? asset($job_data->image_3) : '']);


            return response()->json([
                'status'    => 200,
                'success'   => true,
                'data'      => $job_data
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


    public function updateRequestService(Request $request)
    {
        Log::info('Registration API Hit');
    
        try {

            $user = auth('api')->user(); 

            $job_data = JobRequest::where('id', $request->request_id);
            if($job_data->exists()) {
                $job_req = $job_data->first();

                $image_1 = $job_req->image_1;
                $image_2 = $job_req->image_2;
                $image_3 = $job_req->image_3;
    
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
                    // 'user_id'           => $user->id,
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
                    // 'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now()
                ];

                DB::table('job_requests')->where('id', $request->request_id)->update($details);
                
                return response()->json([
                    'status'    => 200,
                    'success'   => true,
                    'message'   => 'Service request updated successfully.'
                ]);


            } else {
                return response()->json([
                    'status'    => 200,
                    'success'   => false,
                    'message'   => 'Service Request not found.'
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
