<?php

namespace Yadahan\Innstant;

use GuzzleHttp\Client;
use GuzzleHttp\RequestException;

/**
 * Class Innstant.
 */
class Innstant
{
    /**
     * The base URL for the mishor API.
     *
     * @var string
     */
    public static $apiBase = 'https://mishor5-dev.innstant-servers.com';

    /**
     * The aether application key.
     *
     * @var string
     */
    public static $applicationKey;

    /**
     * The aether access token.
     *
     * @var string
     */
    public static $accessToken;

    /**
     * The aether account.
     *
     * @var string
     */
    public static $account;

    /**
     * The aether agent.
     *
     * @var string
     */
    public static $agent;

    /**
     * The aether password.
     *
     * @var string
     */
    public static $password;

    /**
     * The aether customization.
     *
     * @var string
     */
    public static $customization;

    /**
     * The client ip.
     *
     * @var string|null
     */
    public static $clientIp = null;

    /**
     * The client user agent.
     *
     * @var string|null
     */
    public static $clientUserAgent = null;

    /**
     * Sets the application-key to be used for requests.
     *
     * @param string $key
     */
    public static function setApplicationKey($key)
    {
        self::$applicationKey = $key;
    }

    /**
     * Sets the access-token to be used for requests.
     *
     * @param string $token
     */
    public static function setAccessToken($token)
    {
        self::$accessToken = $token;
    }

    /**
     * Sets the API agent to be used for requests.
     *
     * @param string $agent
     */
    public static function setAgent($agent)
    {
        self::$agent = $agent;
    }

    /**
     * Sets the API clientIp to be used for requests.
     *
     * @param string $clientIp
     */
    public static function setClientIp($clientIp)
    {
        self::$clientIp = $clientIp;
    }

    /**
     * Sets the API client UserAgent to be used for requests.
     *
     * @param string $clientUserAgent
     */
    public static function setClientUserAgent($clientUserAgent)
    {
        self::$clientUserAgent = $clientUserAgent;
    }

    public function request($body, $method = 'POST')
    {
        $client = new Client();

        try {
            $response = $client->request($method, self::$apiBase.$this->endpoint, [
                'headers' => [
                    'aether-application-key' => self::$applicationKey,
                    'aether-access-token' => self::$accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $body,
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        return json_decode($response->getBody(), 1);
    }

    /**
     * Convert the instance to JSON.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->toArray(), $options);

        return $json;
    }
}
