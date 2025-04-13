<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class FirebaseNotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        // Retrieve data from the request
        $deviceToken = $request->device_token;
        $title = $request->title ?: 'Default Title';
        $body = $request->body ?: 'Default Body' ;

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
        $serverKey = env('FCM_SERVER_KEY');

        // Send a POST request to FCM
        $response = Http::withHeaders([
            'Authorization' => 'key=' . $serverKey,
            'Content-Type'  => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $data);

        return response()->json([
            'success'  => true,
            'response' => $response->json(),
        ]);
    }
}
