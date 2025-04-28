<?php

namespace App\Http\Controllers;

use App\Models\JobRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseNotificationController extends Controller
{
    public function sendNotification(Request $request)
    {

        try {
            // $pending_reqs = JobRequest::where('notification_send', 0)->get();

            // foreach($pending_reqs as $pr) {
                // Retrieve data from the request
                $deviceToken = 'dduC9REzTUGBs4Y8hfD-8J:APA91bGkSU4YS5dTy4VeNVKJ46LhJdardcZgp-T0Vy6eNQj_WNrug8j4iWDH5eua1lPVel_ouHGHjfaQZ9_mEnaBybT3hjPLPxFWLAk-fG9hIZlXNBNwotE';//$request->device_token;
                $title = 'Flipsell job request notification';
                $body = 'This is a test notification send by flipsell dev' ;

                // Prepare the notification payload
                $data = [
                    // For a single device, you can use "to".
                    // For multiple devices, replace with "registration_ids" => [$deviceToken1, $deviceToken2, ...]
                    'to' => $deviceToken,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                        'sound' => 'default',
                    ],
                    'data' => [
                        'customData' => 'value1',
                    ],
                    'priority' => 'high',
                ];

                // Get the Firebase server key from environment
                $serverKey = '700165384192'; //env('FCM_SERVER_KEY'); //
                // Send a POST request to FCM
                $response = Http::withHeaders([
                    'Authorization' => 'key=' . $serverKey,
                    'Content-Type'  => 'application/json',
                ])->post('https://fcm.googleapis.com/fcm/send', $data);

                return response()->json([
                    'success'  => true,
                    'response' => $response,
                ]);
            // }
            
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
