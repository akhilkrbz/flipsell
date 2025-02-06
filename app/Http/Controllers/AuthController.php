<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpVerifyRequest;
use App\Models\Locations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

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
            $query  = User::where(['mobile' => $request->mobile_no, 'login_otp' => $request->otp]);
            if($query->exists()) {
                $user = $query->first();

                //LOGIN USER
                $credentials = ['mobile' => $request->mobile_no, 'password' => ''];
                // return $token = auth('api')->attempt($credentials);
                if ($token = auth('api')->attempt($credentials)) {
                    $user = auth('api')->user();
                    $refresh_token = auth('api')->fromUser($user);

                    return response()->json([
                        'status'    => 200,
                        'success'   => true,
                        'message'   => 'OTP verified successfully',
                        'user_exist'=> $user->status ? true : false,
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
                            'usertype'      => $user->usertype
                        ]
                    ]);

                    
                }
                return response()->json(['error' => 'Invalid user.'], 401);

            } else {
                return response()->json([
                    'status'    => 200,
                    'success'   => true,
                    'message'   => 'Invalid OTP'
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


    //registration
    public function registration(Request $request)
    {
        try {

            $user = auth('api')->user();

            $details = [
                'name'              => $request->name,
                'email'             => $request->email,
                'location'          => $request->location,
                'category'          => $request->category,
                'subcategory'       => $request->subcategory,
                'business_name'     => $request->business_name,
                'business_phone'    => $request->business_phone,
                'business_email'    => $request->business_email,
                'website'           => $request->website,
                'gst'               => $request->gst,
                'password'          => '',
                'status'            => 1,
                'usertype'          => $request->user_type ?: 0,
                'updated_at'        => Carbon::now(),
            ];

            $user_update = User::where('id', $user->id)->update($details);

            return response()->json([
                'status'    => 200,
                'success'   => true,
                'message'   => 'Details saved successfully.',
                'is_normal_user' => ($request->user_type == 0) ? true : false
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
}