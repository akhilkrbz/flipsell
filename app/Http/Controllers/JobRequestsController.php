<?php

namespace App\Http\Controllers;

use App\Models\JobRequest;
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
