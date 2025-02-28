<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpVerifyRequest;
use App\Models\Locations;
use App\Models\ServiceProvider;
use App\Models\User;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;                                                         
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function register() {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
           
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = new User;
        $user->name = request()->name;
        $user->mobile = request()->mobile_no; 
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->save();

        return response()->json($user, 201);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    //locations
    public function locations()
    {
        try {
            $locations = Locations::get();

            return response()->json([
                'status'    => 200,
                'success'   => true,
                'data'      => $locations
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success'       => false,
                'message'       => 'Something went wrong!!!',
                'exception'     => $th->getMessage(),
                'code'          => $th->getCode(),
            ]);
        }
    }


    //user_mobile_validate
    public function user_mobile_validate(LoginRequest $request)
    {
        try {
            $query = User::where('mobile', $request->mobile_no);
            $otp = '1234';//mt_rand(1000, 9999);
            if($query->exists()) {
                $user = $query->first();

                $user->login_otp = $otp;
                $user->updated_at = Carbon::now();
                $user->save();

                //SEND OTP TO MOBILE NUMBER

                return response()->json([
                    'status'    => 200,
                    'success'   => true,
                    'message'   => 'OTP send successfully.'
                ]);

            } else {
                $country = Locations::where('id', $request->country_id)->first();
                $country_code = $country->country_code;

                //ADD THE NEW USER
                $details = [
                    'name'      => 'Guest user',
                    'email'     => '',

                    'password'  => '',
                    'mobile'    => $request->mobile_no,
                    'status'    => 0,
                    'usertype'  => 0,
                    'login_otp' => $otp,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                User::create($details);

                //SEND OTP TO MOBILE NUMBER

                return response()->json([
                    'status'    => 200,
                    'success'   => true,
                    'message'   => 'OTP send successfully.'
                ]);

            }
        } catch (\Throwable $th) {
            return response()->json([
                'success'       => false,
                'message'       => 'Something went wrong!!!',
                'exception'     => $th->getMessage(),
                'code'          => $th->getCode(),
            ]);
        }
    }


    public function verify_otp(OtpVerifyRequest $request)
    {
        try {
            $query = User::where(['mobile' => $request->mobile_no, 'login_otp' => $request->otp]);
    
            if ($query->exists()) {
                $user = $query->first();
    
                // LOGIN USER
                $credentials = ['mobile' => $request->mobile_no, 'password' => ''];
    
                if ($token = auth('api')->attempt($credentials)) {
                    $user = auth('api')->user();
                    $refresh_token = auth('api')->fromUser($user);
                    $verificationStatus = $user->verification_status;

                     // ✅ Check image & verification images for usertype 0 or 2
                $imageStatus = !is_null($user->image) ? 1 : 0;
                $verificationImage1Status = !is_null($user->verification_image1) ? 1 : 0;
                $verificationImage2Status = !is_null($user->verification_image2) ? 1 : 0;

                // ✅ Check business image if usertype is 1
                $businessImageStatus = 0;
                if ($user->usertype == 1) {
                    $provider = ServiceProvider::where('user_id', $user->id)->first();
                    $businessImageStatus = ($provider && !is_null($provider->business_image)) ? 1 : 0;
                }
    
                    return response()->json([
                        'status'        => 200,
                        'success'       => true,
                        'message'       => 'OTP verified successfully',
                        'user_exist'    => $user->status ? true : false,
                        'access_token'  => $token,
                        'refresh_token' => $refresh_token,
                        'token_type'    => 'bearer',
                        'expires_in'    => auth('api')->factory()->getTTL() * 120,
                        'user'          => [
                            'id'            => $user->id,
                            'name'          => $user->name,
                            'email'         => $user->email,
                            'mobile'        => $user->mobile,
                            'status'        => $user->status,
                            'created_at'    => $user->created_at,
                            'updated_at'    => $user->updated_at,
                            'usertype'      => $user->usertype,
                            'verification_status' => $verificationStatus
                        ],
                        'selfie_image'           => $imageStatus,
                        'verification_image1'    => $verificationImage1Status,
                        'verification_image2'    => $verificationImage2Status,
                        'business_image_status'  => $businessImageStatus,
                    ]);
                }
    
                return response()->json([
                    'status'  => 401,
                    'success' => false,
                    'message' => 'Invalid user.'
                ], 401);
            } 
    
            // Handle invalid OTP case with proper error message and status code
            return response()->json([
                'status'  => 400,
                'success' => false,
                'message' => 'Invalid OTP. Please enter a valid OTP.'
            ], 400);
    
        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'message'   => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code'      => $th->getCode(),
            ], 500);
        }
    }
    

 // registration
public function registration(Request $request)
{
    Log::info('Registration API Hit');

    // Custom validation handling
    $validator = Validator::make($request->all(), [
        'user_type'           => 'required|in:0,1',
        'name'               => 'required|string|max:255',
        'email'              => 'required|email|max:255',
        'location'           => 'required|string|max:255',
        'location_latitude'  => 'required|numeric',
        'location_longitude' => 'required|numeric',
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors'  => $validator->errors(),
        ], 422);
    }

    try {
        Log::info('Registration Input Data:', $request->all());

        $user = auth('api')->user();

        DB::beginTransaction();

        // Common User Details
        $userDetails = [
            'name'      => $request->name,
            'email'     => $request->email,
            'location'  => $request->location,
            'location_latitude'  => $request->location_latitude,
            'location_longitude'  => $request->location_longitude,
            'usertype'  => $request->user_type ?: 0,
            'status'    => 1,
            'updated_at'=> Carbon::now(),
        ];

        // Update user table
        User::where('id', $user->id)->update($userDetails);

        if ($request->user_type == 1) {
            $serviceProviderDetails = [
                'category_id'      => $request->category,
                'subcategory_id'   => $request->subcategory,
                'business_name'    => $request->business_name,
                'business_phone'   => $request->business_phone,
                'business_email'   => $request->business_email,
                'website'          => $request->website,
                'gst_number'       => $request->gst,
                'updated_at'       => Carbon::now(),
            ];

            // Check if user already exists in `service_providers`
            $existingProvider = ServiceProvider::where('user_id', $user->id)->first();

            if ($existingProvider) {
                // Update existing record
                $existingProvider->update($serviceProviderDetails);
            } else {
                // Insert new record
                $serviceProviderDetails['user_id'] = $user->id;
                $serviceProviderDetails['created_at'] = Carbon::now();
                ServiceProvider::create($serviceProviderDetails);
            }

            if ($request->hasFile('reg_document')) {
                $file = $request->file('reg_document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = 'assets/images/' . $filename;
                $file->move(public_path('assets/images'), $filename);

                // Store full URL
                $fullUrl = asset($filePath);

                // Update reg_document in service provider record
                ServiceProvider::where('user_id', $user->id)->update(['reg_document' => $fullUrl]);
            }
        }

        // ✅ Check image & verification images for usertype 0 or 2
        $imageStatus = !is_null($user->image) ? 1 : 0;
        $verificationImage1Status = !is_null($user->verification_image1) ? 1 : 0;
        $verificationImage2Status = !is_null($user->verification_image2) ? 1 : 0;

        // ✅ Check business image if usertype is 1
        $businessImageStatus = 0;
        if ($request->user_type == 1) {
            $provider = ServiceProvider::where('user_id', $user->id)->first();
            $businessImageStatus = ($provider && !is_null($provider->business_image)) ? 1 : 0;
        }

        // Commit the transaction if both tables are updated successfully
        DB::commit();

        return response()->json([
            'status'          => 200,
            'success'         => true,
            'message'         => 'Details saved successfully.',
            'is_normal_user'  => ($request->user_type == 0),
            'selfie_image'    => $imageStatus,
            'verification_image1' => $verificationImage1Status,
            'verification_image2' => $verificationImage2Status,
            'business_image_status' => $businessImageStatus,
        ]);

    } catch (\Throwable $th) {
        DB::rollBack(); // Rollback transaction if any error occurs

        Log::error('Registration Error:', [
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



    public function getFirstAdmin()
    {
        $admin = Admin::select( 'email', 'mobile', 'youtube', 'whatsapp', 'facebook', 'instagram')
                      ->first();

        if (!$admin) {
            return response()->json([
                'success' => 'failure',
                'message' => 'No admin found'
            ], 404);
        }

        return response()->json([
            'success' => 'success',
            'data' => $admin
        ], 200);
    }
}