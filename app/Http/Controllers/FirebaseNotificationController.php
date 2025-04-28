<?php

namespace App\Http\Controllers;

use App\Models\JobRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Services\FirebaseService;

class FirebaseNotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function sendNotification_ref(Request $request)
    {
        // Device token should be passed in the request body
        $deviceToken = 'eUATkIHxSOmlR0BuOONPVS:APA91bFNdGXqPD4qwATAAag7-T80897h10OYnE37i0CRSe2AmuTG6r96SA8ehz3H6T8zCRgCTKvo9frJcReprRCPKBw0G86ZnhIE91Ny-o8R9ldZQLvBFMw'; //$request->input('device_token');
        $title = 'Test noti title';//$request->input('title');
        $body = 'Flipsell notification';//$request->input('body');
        //$data = $request->input('data', []);

        $data = [
            'order_id' => '12345',
            'screen' => 'OrderDetails'
        ];

        $response = $this->firebaseService->sendNotification($deviceToken, $title, $body, $data);

        return response()->json($response);
    }



    public function sendNotification(Request $request)
    {
        Log::info('Notification started');
        $job_reqs = JobRequest::where('notification_send', 0)->get();
        $users = User::select(['device_token'])->where('usertype', 1)->where('device_token', '!=', null)->get();
        $deviceToken = $users->pluck('device_token')->toarray();

        Log::info('job reqs');
        Log::info($job_reqs);

        Log::info('Device tokens');
        Log::info($deviceToken);


        foreach($job_reqs as $key => $job_req) {
            $title = 'New job request added';//$request->input('title');
            $body = 'New job request added';//$request->input('body');
            //$data = $request->input('data', []);
    
            $data = [
                'job_id' => $job_req->id,
                'type' => 'new_request',
                'screen' => 'JobDetails'
            ];
    
            $response = $this->firebaseService->sendNotification($deviceToken, $title, $body, $data);

            Log::info('response 1');
            Log::info($response);

            DB::table('job_requests')->where('id', $job_req->id)->update(['notification_send' => 1]);
        }

        $response = [
            'status' => 200,
            'data' => 'Notification send successfully.'
        ];

        // Device token should be passed in the request body
        //$deviceToken = 'eUATkIHxSOmlR0BuOONPVS:APA91bFNdGXqPD4qwATAAag7-T80897h10OYnE37i0CRSe2AmuTG6r96SA8ehz3H6T8zCRgCTKvo9frJcReprRCPKBw0G86ZnhIE91Ny-o8R9ldZQLvBFMw'; //$request->input('device_token');
        

        return response()->json($response);
    }


}
