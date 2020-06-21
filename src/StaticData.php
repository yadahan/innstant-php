<?php

namespace Yadahan\Innstant;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class StaticData.
 */
class StaticData
{
    /**
     * The base URL for the static data API.
     *
     * @var string
     */
    public static $apiBase;

    /**
     * The endpoint.
     *
     * @var string
     */
    public static $endpoint;

    public function __construct($endpoint, $apiBase = 'https://static-data.innstant-servers.com/')
    {
        self::$apiBase = $apiBase;
        self::$endpoint = $endpoint;
    }

    public function request($method = 'GET')
    {
        $client = new Client();

        try {
            $response = $client->request($method, self::$apiBase.self::$endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        return json_decode($response->getBody(), 1);
    }
}
