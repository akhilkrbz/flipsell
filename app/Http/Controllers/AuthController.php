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
use App\Models\Subcategory;


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
                    'email'     => null,

                    'password'  => '',
                    'mobile'    => $request->mobile_no,
                    'status'    => 0,
                    'usertype'  => 0,
                    'country_id' => $request->country_id, 
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
                    $imageStatus = !is_null($user->image) ? true : false;
                    $verificationImage1Status = !is_null($user->verification_image1) ? true : false;
                    $verificationImage2Status = !is_null($user->verification_image2) ? true : false;
    
                    // ✅ Check business image and reg_document if usertype is 1
                    $businessImageStatus = false;
                    $regDocumentStatus = false;
                    if ($user->usertype == 1) {
                        $provider = ServiceProvider::where('user_id', $user->id)->first();
                        $businessImageStatus = ($provider && !is_null($provider->business_image)) ? true : false;
                        $regDocumentStatus = ($provider && !is_null($provider->reg_document)) ? true : false;
                    }
    
                    // ✅ Determine image_verification_completed status as true or false
                    $imageVerificationCompleted = false;
                    if ($user->usertype == 0) {
                        $imageVerificationCompleted = ($imageStatus && $verificationImage1Status && $verificationImage2Status) ? true : false;
                    } elseif ($user->usertype == 1) {
                        $imageVerificationCompleted = ($imageStatus && $verificationImage1Status && $verificationImage2Status && $regDocumentStatus && $businessImageStatus) ? true : false;
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
                            'id'                    => $user->id,
                            'name'                  => $user->name,
                            'email'                 => $user->email,
                            'mobile'                => $user->mobile,
                            'status'                => $user->status,
                            'created_at'            => $user->created_at,
                            'updated_at'            => $user->updated_at,
                            'usertype'              => $user->usertype,
                            'verification_status'   => $verificationStatus
                        ],
                        'image_verification_completed' => $imageVerificationCompleted,
                        'selfie_image'                => $imageStatus,
                        'verification_image1'         => $verificationImage1Status,
                        'verification_image2'         => $verificationImage2Status,
                        'business_image_status'       => $businessImageStatus,
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


            $subcategories = is_string($request->subcategory) ? json_decode($request->subcategory, true) : $request->subcategory;

            Log::info('Raw Subcategory Data:', ['subcategory' => $request->subcategory]);
            Log::info('Processed Subcategory Data:', ['subcategory' => $subcategories]);
            
            if (!empty($subcategories) && is_array($subcategories)) {
                Log::info('Processing Subcategories:', ['subcategory' => $subcategories]);
            
                foreach ($subcategories as $subcatId) {
                    Log::info("Checking subcategory ID:", ['subcatId' => $subcatId]);
            
                    if (empty($subcatId)) {
                        Log::warning('Skipping empty subcategory');
                        continue;
                    }
            
                    $existingSubcategory = Subcategory::where('user_id', $user->id)
                        ->where('subcategory', $subcatId)
                        ->first();
            
                    if (!$existingSubcategory) {
                        Log::info("Inserting new subcategory:", ['user_id' => $user->id, 'subcategory' => $subcatId]);
            
                        Subcategory::create([
                            'subcategory' => $subcatId,
                            'user_id'     => $user->id,
                            'chosen'      => 1, // Default value
                        ]);
                    } else {
                        Log::info("Subcategory already exists:", ['user_id' => $user->id, 'subcategory' => $subcatId]);
                    }
                }
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



    public function profile_update(Request $request)
{
    try {
        // Get authenticated user
        $user = auth('api')->user();

        if (!$user) {
            Log::error('Unauthorized access attempt.');
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        // Define validation rules for the users table
        $userRules = [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'location' => 'sometimes|string|max:255',
            'location_latitude' => 'sometimes',
            'location_longitude' => 'sometimes',
            'address' => 'sometimes|string|max:500',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'verification_image1' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'verification_image2' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Define validation rules for the service_providers table if usertype is 1
        $providerRules = [];
        if ($user->usertype == 1) {
            $providerRules = [
                'business_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'reg_document' => 'sometimes|file|mimes:pdf,doc,docx|max:2048',
                'gst_number' => 'sometimes|string|max:20',
                'website' => 'sometimes|url',
                'category_id' => 'sometimes',
                'subcategory_id' => 'sometimes',
            ];
        }

        // Merge rules and validate the request
        $validatedData = $request->validate(array_merge($userRules, $providerRules));

        // Log validated data
        Log::info('Validated data:', $validatedData);

        // Handle file uploads
        $filePaths = [];
        foreach (['image', 'verification_image1', 'verification_image2', 'business_image', 'reg_document'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = 'assets/images/' . $field;
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($path), $fileName);
                $filePaths[$field] = asset($path . '/' . $fileName);
                Log::info("Uploaded file for $field: " . $filePaths[$field]);
            }
        }

        // Update user profile in the users table
        $userData = array_intersect_key($validatedData, array_flip(array_keys($userRules)));
        $userData = array_merge($userData, array_intersect_key($filePaths, $userData));
        DB::table('users')->where('id', $user->id)->update($userData);
        Log::info('User profile updated:', $userData);

        // Insert or update service provider profile if usertype is 1
        if ($user->usertype == 1) {
            $providerData = array_intersect_key($validatedData, array_flip(array_keys($providerRules)));
            $providerFilePaths = array_intersect_key($filePaths, $providerData);
            $serviceProviderData = array_merge($providerData, $providerFilePaths);
            $serviceProviderData['user_id'] = $user->id; // Add user ID to associate

            // Check if service provider entry exists
            $existingProvider = DB::table('service_providers')->where('user_id', $user->id)->first();

            if ($existingProvider) {
                // Update if exists
                DB::table('service_providers')->where('user_id', $user->id)->update($serviceProviderData);
                Log::info('Service provider profile updated:', $serviceProviderData);
            } else {
                // Insert if not exists
                DB::table('service_providers')->insert($serviceProviderData);
                Log::info('Service provider profile created:', $serviceProviderData);
            }
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Profile updated successfully.',
            'data' => array_merge($userData, $serviceProviderData ?? [])
        ]);
    } catch (\Exception $e) {
        Log::error('Error in profile_update:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => 'An error occurred while updating the profile.',
            
        ], 500);
    }
}

}