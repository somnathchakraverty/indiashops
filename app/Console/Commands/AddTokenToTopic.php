<?php

namespace indiashopps\Console\Commands;

use Illuminate\Console\Command;
use indiashopps\Models\FcmToken;

class AddTokenToTopic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm:add_tokens_to_topic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command adds FCM v1 tokens to default topic..';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->addBulkTokenToTopic();
    }

    public function addBulkTokenToTopic()
    {
        \DB::table('fcm_tokens')->whereRaw("token NOT REGEXP '.{11}:'")->update(['gcm_version' => 2]);
        \Log::info("Bulk Topic Add Started..!!");

        if (env('APP_ENV') == 'production') {
            $topic = FcmToken::GENERAL_TOPIC;
        } else {
            $topic = FcmToken::TEST_TOPIC;
        }

        $rows = FcmToken::where('topic_added', FcmToken::TOPIC_NOT_ADDED)
                        ->whereGcmVersion(FcmToken::WEBSITE_VERSION)
                        ->where('sw_version', "!=", 'v2')
                        ->select(['token', 'id']);

        if ($rows->count() > 0) {
            \Log::info("Total V1 Token Found ** BULK ** :: " . $rows->count());

            $rows->chunk(500, function ($tokens) use ($topic) {
                $this->bulkAddTopics($tokens, $topic);
            });
        }

        $rows = FcmToken::where('topic_added', FcmToken::TOPIC_NOT_ADDED)
                        ->whereGcmVersion(FcmToken::WEBSITE_VERSION)
                        ->where('sw_version', "=", 'v2')
                        ->select(['token', 'id']);

        if ($rows->count() > 0) {
            \Log::info("Total V2 Token Found ** BULK ** :: " . $rows->count());

            $rows->chunk(500, function ($tokens) {
                $this->bulkAddTopics($tokens, FcmToken::VERSION2_TOPIC);
            });
        }

        \Log::info("Bulk Topic Add End..!!");
    }

    public function bulkAddTopics($tokens, $topic)
    {
        $data["to"]                  = $topic;
        $data['registration_tokens'] = $tokens->pluck('token')->toArray();

        $url = "https://iid.googleapis.com/iid/v1:batchAdd";

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
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        json_decode(curl_exec($ch));
        curl_close($ch);

        foreach ($tokens as $token) {
            $token->topic_added = 2;
            $token->save();
        }
    }
}
