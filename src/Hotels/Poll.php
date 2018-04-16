<?php

namespace Yadahan\Innstant\Hotels;

use Yadahan\Innstant\Innstant;

class Poll extends Innstant
{
    /**
     * The innstant session.
     *
     * @var string
     */
    protected $session;

    /**
     * The last result.
     *
     * @var int
     */
    protected $last;

    public function __construct($session, $last = 0)
    {
        $this->session = $session;
        $this->last = $last;
    }

    /**
     * Convert the instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'auth' => [
                'username' => self::$username,
                'password' => self::$password,
                'agent'    => self::$agent,
            ],
            'hotel-poll' => [
                '@session' => $this->session,
                '@last'    => $this->last,
            ],
        ];
    }

    /**
     * Convert the response from instance to an api clean.
     *
     * @return array
     */
    public function toApi($data)
    {
        if (isset($data['error'])) {
            return $this->errorToApi($data);
        }

        $count = $data['results']['@attributes']['count'];

        $results = [];

        if ($count) {
            $data['results']['result'] = $count == '1' ? [$data['results']['result']] : $data['results']['result'];

            if (isset($data['results']['result'])) {
                foreach ($data['results']['result'] as $key => $result) {
                    if (isset($result['non-billable-price'])) { // availability coming from direct providers
                        $price = $result['non-billable-price']['@attributes']['minCommissionablePrice'];
                        $currency = $result['non-billable-price']['@attributes']['currency'];
                        $min = $result['non-billable-price']['min-rooms']['min-room']['@attributes']['roomCount'];
                    } else { // availablity coming from innstant.travel
                        $price = $result['price']['@attributes']['minCommissionablePrice'];
                        $currency = $result['price']['@attributes']['currency'];
                    }

                    if (isset($min) && $min > 1) {
                        $price = $price / $min;
                    }

                    if (isset($result['special-deals'])) {
                        if (is_array($result['special-deals']['special-deal'])) {
                            $special = $result['special-deals']['special-deal'];
                        } else {
                            $special = [$result['special-deals']['special-deal']];
                        }
                    } else {
                        $special = null;
                    }

                    $results[] = [
                        'id'             => $result['@attributes']['id'] ?? null,
                        'providers'      => explode(',', $result['@attributes']['providers']) ?? null,
                        'minProvider'    => $result['@attributes']['minProvider'] ?? null,
                        'hasPackageRate' => $result['@attributes']['hasPackageRate'] ?? null,
                        'boards'         => explode(',', $result['@attributes']['availableBoards']),
                        'price'          => $price,
                        'currency'       => $currency,
                        'special'        => $special,
                    ];
                }
            }
        }

        return [
            'server'  => $data['job']['server'] ?? null,
            'status'  => $data['job']['@attributes']['status'] ?? null,
            'success' => $data['@attributes']['success'] ?? null,
            'time'    => $data['@attributes']['time'] ?? null,
            'session' => $data['@attributes']['session'] ?? null,
            'last'    => $data['results']['@attributes']['last'] ?? null,
            'count'   => $data['results']['@attributes']['count'] ?? null,
            'results' => $results,
        ];
    }
}
