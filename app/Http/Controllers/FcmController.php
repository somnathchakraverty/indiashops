<?php namespace indiashopps\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use Queue;
use Illuminate\Http\Request;

use indiashopps\Models\FcmToken;
use indiashopps\Commands\FcmNotification;

class FcmController extends Controller
{

    const DEVICE_ENABLED = "1";

    private $user_count = 0;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function sendNotifications($data = '')
    {
        \Log::info("GCM Notification cron started..");

        send_slack_alert('GCM Notification cron started..');

        if (isset($data) && !empty($data) && is_object($data)) {
            $this->sendBulkNotifications($data);
        }

        \Log::info("GCM Notification cron end..");
        send_slack_alert('GCM Notification cron end..');
    }

    public function sendBulkNotifications($data)
    {
        $params = [
            'utm_fcm_source' => 'fcm'
        ];

        $post_fields = [
            'title' => $data->title,
            'body'  => $data->content,
            'icon'  => $data->image_url,
        ];

        $post_fields['title'] = urlencode($post_fields['title']);
        $post_fields['body']  = urlencode($post_fields['body']);

        if (stripos($data->click_action, 'indiashopps.com') === false) {
            $click_action = route('track_url', ['url' => urlencode($data->click_action)]);
        } else {
            $click_action = $data->click_action;
        }

        if (parse_url($click_action, PHP_URL_QUERY)) {
            $click_action = $click_action . "&" . http_build_query($params);
        } else {
            $click_action = $click_action . "?" . http_build_query($params);
        }

        $check = true;

        if (isset($data->sources)) {
            $sources = explode(",", $data->sources);

            if (count($sources) > 0) {
                $check                  = false;
                $post_fields['sources'] = $sources;
            }
        } else {
            $sources = [];
        }

        $post_fields['click_action'] = $click_action;

        if ($check || array_intersect($sources, ['hindustan_times', 'indiashopps'])) {
            $this->sendFcmMessageToTopic($post_fields);
        }

        if ($check || array_intersect($sources, ['amanlcd_ext', 'extension'])) {
            $this->sendBulkGcmNotification($post_fields);
        }
    }

    private function sendFcm($data)
    {

        if (empty(env('FCM_API_SERVER_KEY', ''))) {
            \Log::error("FCM_API_SERVER_KEY key missing.. Server::" . env('APP_ENV'));
            return false;
        }

        $params = [
            'utm_fcm_source' => 'fcm'
        ];

        $post_fields = [
            'title' => $data->title,
            'body'  => $data->content,
            'icon'  => $data->image_url,
        ];

        if (isset($data->category_id) && !empty($data->category_id)) {
            $params['category_id'] = $data->category_id;
        }

        $devices = FcmToken::whereEnabled(self::DEVICE_ENABLED)
                           ->where('updated_at', "<", Carbon::now()
                                                            ->format("Y-m-d 00:00:00"))
                           ->get();

        send_slack_alert('Total Enabled Users:: *' . $devices->count() . '*');

        try {
            foreach ($devices as $device) {
                $click_action = '';

                $params['identifier'] = $device->identifier;

                if (stripos($data->click_action, 'indiashopps.com') === false) {
                    $click_action = route('track_url', ['url' => urlencode($data->click_action)]);
                } else {
                    $click_action = $data->click_action;
                }

                if (parse_url($click_action, PHP_URL_QUERY)) {
                    $click_action = $click_action . "&" . http_build_query($params);
                } else {
                    $click_action = $click_action . "?" . http_build_query($params);
                }

                $post_fields['click_action'] = $click_action;

                if ($device->gcm_version == FcmToken::WEBSITE_VERSION) {
                    $this->sendFcmNotification($device, $post_fields);
                } else {
                    $this->sendGcmNotification($device, (object)$post_fields);
                }
            }
        }
        catch (\Exception $e) {
            \Log::error($e->getMessage() . "::" . $e->getTraceAsString());
        }

        send_slack_alert('Total Notification Sent:: *' . $this->user_count . '*');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function fcmNotificationRequest(Request $request)
    {
        $response = $this->validateFcmRequest($request);

        if ($response instanceof Response) {
            return $response;
        }

        Queue::push(new FcmNotification((object)$request->all()));

        return response(['GCM Notification Request Submitted..!!']);
    }

    public function singleNotification(Request $request)
    {
        $response = $this->validateFcmRequest($request, true);

        if ($response instanceof Response) {
            return $response;
        }

        $params = [
            'utm_fcm_source' => 'fcm'
        ];

        $post_fields = [
            'title' => $request->title,
            'body'  => $request->get('content'),
            'icon'  => $request->image_url,
        ];

        $post_fields['title'] = urlencode($post_fields['title']);
        $post_fields['body']  = urlencode($post_fields['body']);

        if (isset($request->category_id) && !empty($request->category_id)) {
            $params['category_id'] = $request->category_id;
        }

        $device = FcmToken::whereIdentifier($request->identifier)->whereEnabled(self::DEVICE_ENABLED)->first();

        if (is_null($device)) {
            return response(['Invalid/Disabled User Identifer'], 422);
        }

        $click_action = '';

        $params['identifier'] = $device->identifier;

        if (stripos($request->click_action, 'indiashopps.com') === false) {
            $click_action = route('track_url', ['url' => urlencode($request->click_action)]);
        } else {
            $click_action = $request->click_action;
        }

        if (parse_url($click_action, PHP_URL_QUERY)) {
            $click_action = $click_action . "&" . http_build_query($params);
        } else {
            $click_action = $click_action . "?" . http_build_query($params);
        }

        $post_fields['click_action'] = $click_action;

        if ($device->gcm_version == FcmToken::WEBSITE_VERSION) {
            $response = $this->sendFcmNotification($device, $post_fields);
        } else {
            $response = $this->sendGcmNotification($device, (object)$post_fields);
        }

        if ($response) {
            return response(['GCM Message sent to: ' . $request->identifier]);
        } else {
            return response(['GCM Message could not be sent to: ' . $request->identifier]);
        }
    }

    protected function sendFcmNotification(FcmToken $device, $post_fields)
    {
        $headers = [
            'Authorization: key=' . env('FCM_API_SERVER_KEY'),
            'Content-Type: application/json'
        ];

        $fields['notification'] = $post_fields;
        $fields['to']           = $device->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(json_encode($fields)));

        $response = json_decode(curl_exec($ch));

        curl_close($ch);

        if ($response->failure == 1 && collect($response->results)->first()->error == 'NotRegistered') {
            $device->enabled = '0';
            $device->save();

            return false;
        } else {
            \Log::info("GCM sent to ::" . $device->token);

            $this->user_count++; // Increasing the count for FCM sent.
            $device->touch();

            return true;
        }
    }

    protected function sendGcmNotification(FcmToken $device, $post_fields)
    {
        $API_ACCESS_KEY = "AAAAFFykH1U:APA91bEjhfBmqfp99VPtcT91Oj5-eLnWnSqY3jKc9NjVshJFNDOfzp3ofCZc12KKsemBCYhErHbgIuqya_iQjLFfPqoJJ26avJ5u7VLyhfaRlSQoqtgI14UDhYOXU6EMmH0BJxBZ_rOL";

        $fields         = [];
        $fields['data'] = [];

        $fields['data']['type']     = 3;
        $fields['data']['id']       = mt_rand();
        $fields['data']['title']    = $post_fields->title;
        $fields['data']['text']     = $post_fields->body;
        $fields['data']['link']     = $post_fields->click_action;
        $fields['data']['imageUrl'] = $post_fields->icon;

        $fields['to'] = $device->token;

        $headers = [
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(json_encode($fields)));
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);

        if ($result->failure == 1) {
            $device->enabled = '0';
            $device->save();
            return false;
        } else {
            $device->touch();
            \Log::info("GCM sent to ::" . $device->token);
            $this->user_count++; // Increasing the count for FCM sent.
            return false;
        }
    }

    public function sendBulkGcmNotification($post_fields)
    {
        $fields         = [];
        $fields['data'] = [];

        $fields['data']['type']     = 3;
        $fields['data']['id']       = mt_rand();
        $fields['data']['title']    = $post_fields['title'];
        $fields['data']['text']     = $post_fields['body'];
        $fields['data']['link']     = $post_fields['click_action'];
        $fields['data']['imageUrl'] = $post_fields['icon'];

        $rows = FcmToken::whereGcmVersion(FcmToken::EXTENSION_VERSION)
                        ->select(['token', 'id'])
                        ->whereEnabled(self::DEVICE_ENABLED)
                        ->where('updated_at', "<", Carbon::now()->format("Y-m-d 00:00:00"));

        if (isset($post_fields['sources']) && is_array($post_fields['sources'])) {
            if (count($post_fields['sources']) > 0) {
                $rows->whereIn('source', $post_fields['sources']);
            }
        }

        if ($rows->count() > 0) {
            $rows->chunk(999, function ($tokens) use ($fields) {
                $fields['registration_ids'] = $tokens->pluck('token')->toArray();

                $headers = [
                    'Authorization: key=AAAAFFykH1U:APA91bEjhfBmqfp99VPtcT91Oj5-eLnWnSqY3jKc9NjVshJFNDOfzp3ofCZc12KKsemBCYhErHbgIuqya_iQjLFfPqoJJ26avJ5u7VLyhfaRlSQoqtgI14UDhYOXU6EMmH0BJxBZ_rOL',
                    'Content-Type: application/json'
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(json_encode($fields)));
                $result = curl_exec($ch);
                curl_close($ch);

                $res = json_decode($result);

                if (isset($res->failure) && $res->failure > 0) {
                    $all_tokens = $tokens->toArray();

                    foreach ($res->results as $device_index => $error) {
                        $device = FcmToken::find($all_tokens[$device_index]['id']);

                        if (isset($error->error)) {
                            $device->enabled = '0';
                            $device->save();
                        }

                        $device->touch();
                    }
                }

                \Log::info("Bulk Message sent for BATCH");
            });
        }
    }

    public function getToken()
    {
        return response(['_token' => csrf_token()]);
    }

    private function validImage($file)
    {
        $size = getimagesize($file);
        return (strtolower(substr($size['mime'], 0, 5)) == 'image' ? true : false);
    }

    public function subscribe()
    {
        return view('v2.static.subscribe');
    }

    protected function validateFcmRequest(Request $request, $identifier = false)
    {
        $rules = [
            'title'        => 'required|min:5',
            'content'      => 'required|min:10',
            'click_action' => 'required',
            'image_url'    => 'required',
            'category_id'  => 'numeric',
        ];

        if ($identifier !== false) {
            $rules['identifier'] = 'required|min:10';
        }

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return response($messages, 422);
        }

        if (!filter_var($request->click_action, FILTER_VALIDATE_URL)) {
            $errors = new MessageBag(['image_url' => ['Invalid Image URL..']]);

            return response($errors, 422);
        }

        try {
            if (!$this->validImage($request->image_url)) {
                $errors = new MessageBag(['image_url' => ['Invalid Image URL..']]);

                return response($errors, 422);
            }
        }
        catch (\Exception $e) {
            $errors = new MessageBag(['image_url' => ['Invalid Image URL..']]);

            return response($errors, 422);
        }
    }

    public static function addFcmTokenToTopic($token)
    {
        if (empty($token) || !is_string($token)) {
            return false;
        }

        $re = "/^.{11}:/";

        preg_match($re, $token, $matches);

        if (!empty($matches)) {
            $url = "https://iid.googleapis.com/iid/v1/$token/rel" . (env('APP_ENV') == 'production') ? FcmToken::GENERAL_TOPIC : FcmToken::TEST_TOPIC;

            $fields = [];

            $headers = [
                'Authorization: key=' . env('FCM_API_SERVER_KEY'),
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_exec($ch);
            curl_close($ch);
        }
    }

    public function sendFcmMessageToTopic($post_fields, $topic = FcmToken::GENERAL_TOPIC)
    {
        $headers = [
            'Authorization: key=' . env('FCM_API_SERVER_KEY'),
            'Content-Type: application/json'
        ];

        $fields['notification'] = $post_fields;
        $fields['to']           = $topic = (env('APP_ENV') == 'production') ? $topic : FcmToken::TEST_TOPIC;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(json_encode($fields)));

        json_decode(curl_exec($ch));

        curl_close($ch);

        send_slack_alert("Bulk notifications sent to TOPIC:: " . $topic);
    }

    public function serviceWorkerSubscriber(Request $request)
    {
        $browser    = $request->get('browser');
        $token      = $request->get('token');
        $sw_version = $request->get('swv');

        if (!empty($token)) {
            $device = FcmToken::whereToken($token)->first();

            if (!is_null($device)) {
                $device->browser    = $browser;
                $device->sw_version = $sw_version;
                $device->save();
            }
        }

        return response()->json(['User token updated..!!']);
    }
}
