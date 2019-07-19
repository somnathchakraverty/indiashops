<?php

namespace indiashopps\Support\Buffer;

use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Message\Response;

Class Client
{
    /** @var self */
    protected static $instance = null;

    /** @var GuzzleClient */
    protected $client = null;

    const FB_PROFILE_ID = '587cce2621f4429503d11438';

    protected function __construct() { }

    protected function __clone() { }

    /**
     * @return self
     */
    protected static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * @return Client
     */
    protected static function init()
    {
        return self::getInstance();
    }

    /**
     * Returns GuzzleHttpClient
     *
     * @return GuzzleClient
     */
    public function getGuzzleClient()
    {
        if (is_null($this->client)) {
            $this->client = new GuzzleClient();
        }

        return $this->client;
    }

    /**
     * Initial the guzzle client, and sets the BASE URI..
     *
     * @author Vishal <vishal@manyainternational.com>
     * @return void
     */
    private function initialBuffer()
    {
        $client = $this->getGuzzleClient();
        $client->setBaseUrl('https://api.bufferapp.com/1/');
        $client->setDefaultOption('headers', [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ]);

    }

    /**
     * @param array $data
     * @return object
     */
    public static function publishPost(array $data)
    {
        $self = self::init();
        $self->initialBuffer();

        $post_url = 'updates/create.json';

        $post_fields['profile_ids[]'] = self::FB_PROFILE_ID;
        $post_fields['now']           = 1;
        $post_fields['text']          = $data['description'];
        $post_fields['media[photo]']  = $data['picture'];
        $post_fields['media[title]']  = $data['title'];

        try {
            /** @var Response */
            $response = $self->client->post($post_url)->addPostFields($post_fields)->send();

            if ($response->getStatusCode() == 200) {
                return $response->json();
            }

            return false;
        }
        catch (ClientErrorResponseException $e) {
            try {
                $response = $e->getResponse()->json();
                if ($response['success'] === false) {
                    send_slack_alert("FB API Error:: " . $response['message'], 'facebook_api');
                }
            }
            catch (\Exception $ee) {
                send_slack_alert("FB API Unexpected Error :: " . $e->getMessage(), 'facebook_api');
            }

            return false;
        }
    }

    /**
     * Returns Buffer Token..
     *
     * @return mixed
     * @throws \Exception
     */
    public function getToken()
    {
        $token = env("BUFFER_API_TOKEN", false);

        if ($token === false) {
            throw new \Exception("Buffer API is not configured. API Token is missing..!!");
        }

        return $token;
    }
}