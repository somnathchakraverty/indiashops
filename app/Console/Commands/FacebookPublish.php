<?php

namespace indiashopps\Console\Commands;

use Carbon\Carbon;
use Facebook\Facebook;
use Illuminate\Console\Command;
use indiashopps\Models\FacebookPost;
use indiashopps\Support\Buffer\Client;
use indiashopps\Support\Image;

class FacebookPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:publish_post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes post on Facebook from the Post Queue every hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $fb_client;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            if (env('FB_AUTOPOST_DISABLED', false) === false) {
                $post = FacebookPost::orderBy('created_at', 'ASC')->first();

                if (!is_null($post)) {
                    $this->publish($post);
                } else {
                    send_slack_alert("No Product in the queue !", 'facebook_api');
                }
            }
        }
        catch (\Exception $e) {
            send_slack_alert('FB API ERROR :: ' . $e->getMessage() . " :: " . $e->getFile() . " :: " . $e->getLine(), 'facebook_api');
        }
    }

    private function publish($post)
    {
        $product = app('solr')->wherePid($post->product_id)->getProduct(true);
        $file    = Image::processImage($product->product_detail);
        $data    = $this->preparePostParams($post, $product->product_detail, $file);

        if ($data) {

            $response = Client::publishPost($data);

            if (isset($response['success']) && $response['success'] == true) {
                send_slack_alert("Facebook Post Publish for Product ID: " . $post->product_id . " Product:: " . $product->product_detail->name, 'facebook_api');
                $post->delete();

                $this->info("POST PUBLISHED..");
            } else {
                send_slack_alert("FB API. Post NOT Published..Response " . json_encode($response), 'facebook_api');
            }
        } else {
            send_slack_alert("No data found / processed.. ", 'facebook_api');
        }
    }

    private function getRefreshedAccessToken()
    {
        $access_token = env('FB_ACCESS_TOKEN');
        $longlive     = $this->fb_client->getOAuth2Client()->getLongLivedAccessToken($access_token);

        $access_token = $longlive->getValue();
        changeEnv(['FB_ACCESS_TOKEN' => $access_token]);

        return $access_token;
    }

    protected function preparePostParams($post, $product, $image_path)
    {
        $p = json_decode($post->params);

        if (isset($p->title, $p->link, $p->content)) {

            if (env('APP_ENV') != 'production') {
                $product_url = str_replace(env('APP_URL'), 'https://www.indiashopps.com', product_url($product));
                $image       = 'https://i.imgur.com/JXi56ub.png';
            } else {
                $product_url = product_url($product);
                $image       = $image_path;
            }

            $search  = ['{PRODUCT_NAME}', '{PRODUCT_PRICE}', '{PRODUCT_URL}'];
            $replace = [$product->name, number_format($product->saleprice), product_url($product)];
            $content = str_replace($search, $replace, $p->content);

            if (stripos($content, '{PAGE_LINK}') !== false) {
                $content = str_replace('{PAGE_LINK}', $p->link, $content);
            } else {
                $content .= " " . $p->link;
            }
            
            $data = [
                'link'        => $product_url,
                'title'       => $p->title,
                'picture'     => $image,
                'description' => $content,
            ];

            return $data;
        } else {
            send_slack_alert('Facebook Post Error, Invalid Value POST ID :: ' . $post->id, "facebook_api");
            return false;
        }
    }
}
