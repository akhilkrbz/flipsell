<?php

namespace App\Services;

use Google\Auth\OAuth2;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $projectId;
    protected $clientEmail;
    protected $privateKey;

    public function __construct()
    {
        $serviceAccount = json_decode(file_get_contents(storage_path('app/firebase/service-account.json')), true);

        $this->projectId = $serviceAccount['project_id'];
        $this->clientEmail = $serviceAccount['client_email'];
        $this->privateKey = $serviceAccount['private_key'];
    }

    // Get Access Token
    private function getAccessToken()
    {
        $oauth = new OAuth2([
            'audience' => 'https://oauth2.googleapis.com/token',
            'issuer' => $this->clientEmail,
            'signingAlgorithm' => 'RS256',
            'signingKey' => $this->privateKey,
            'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
            'scope' => ['https://www.googleapis.com/auth/firebase.messaging'],
        ]);

        $token = $oauth->fetchAuthToken();
        return $token['access_token'];
    }

    // Send FCM Notification
    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        $accessToken = $this->getAccessToken();
        $response = true;
        foreach ($deviceToken as $dt) {

            $data = array_map('strval', $data);

            Log::channel('cronjob')->info('response inside notification send function data');
            Log::channel('cronjob')->info(json_encode($data));


            $message = [
                'message' => [
                    'token' => $dt,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => $data,
                ]
            ];
    
    
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post("https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send", $message);

            Log::channel('cronjob')->info('response inside notification send function');
            Log::channel('cronjob')->info($response);
        }

        return $response;
        

        // return $response->json();
    }
}
