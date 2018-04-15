<?php

namespace Yadahan\Innstant;

use FluidXml\FluidXml;
use GuzzleHttp\Client;

/**
 * Class Innstant.
 */
class Innstant
{
    /**
     * The base URL for the Innstant API.
     *
     * @var string
     */
    public static $apiBase = 'http://mishor4.innstant-servers.com';

    /**
     * The version of the Innstant API to use for requests.
     *
     * @var string
     */
    public static $apiVersion = '4.0';

    /**
     * The Innstant authentication username.
     *
     * @var string
     */
    public static $username;

    /**
     * The Innstant authentication password.
     *
     * @var string
     */
    public static $password;

    /**
     * The Innstant authentication agent.
     *
     * @var string
     */
    public static $agent;

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
     * Sets the username to be used for requests.
     *
     * @param string $username
     */
    public static function setUserName($username)
    {
        self::$username = $username;
    }

    /**
     * Sets the API password to be used for requests.
     *
     * @param string $password
     */
    public static function setPassword($password)
    {
        self::$password = $password;
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

    public function request($body, $endpoint = null)
    {
        $http = new Client();

        $response = $http->request('POST', $endpoint ?: self::$apiBase, ['body' => $body]);

        return $response->getBody();
    }

    public function errorToApi($response)
    {
        $error = [
            'status' => 'error',
            'error'  => [
                'code'    => $response['error']['@attributes']['code'] ?? null,
                'content' => $response['error']['@content'] ?? null,
            ],
            'success' => $response['@attributes']['success'] ?? null,
            'time'    => $response['@attributes']['time'] ?? null,
            'session' => $response['@attributes']['session'] ?? null,
        ];

        if (isset($response['booking-options'])) {
            $error['booking-options'] = $response['booking-options'];
        }

        return $error;
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

    public function toXml()
    {
        $xml = new FluidXml('request');

        $xml->attr(['version' => self::$apiVersion])->add($this->toArray());

        return $xml;
    }

    public function xmlToArray($xml)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $root = $doc->documentElement;
        $output = $this->nodeToArray($root);
        $output['@root'] = $root->tagName;

        return $output;
    }

    public function nodeToArray($node)
    {
        $output = [];

        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;

            case XML_ELEMENT_NODE:
                for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
                    $child = $node->childNodes->item($i);
                    $v = $this->nodeToArray($child);

                    if (isset($child->tagName)) {
                        $t = $child->tagName;

                        if (! isset($output[$t])) {
                            $output[$t] = [];
                        }

                        $output[$t][] = $v;
                    } elseif ($v || $v === '0') {
                        $output = (string) $v;
                    }
                }

                if ($node->attributes->length && ! is_array($output)) {
                    $output = ['@content'=>$output];
                }

                if (is_array($output)) {
                    if ($node->attributes->length) {
                        $a = [];

                        foreach ($node->attributes as $attrName => $attrNode) {
                            $a[$attrName] = (string) $attrNode->value;
                        }

                        $output['@attributes'] = $a;
                    }

                    foreach ($output as $t => $v) {
                        if (is_array($v) && count($v) == 1 && $t != '@attributes') {
                            $output[$t] = $v[0];
                        }
                    }
                }
                break;
        }

        return $output;
    }
}
