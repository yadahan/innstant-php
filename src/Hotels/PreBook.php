<?php

namespace Yadahan\Innstant\Hotels;

class PreBook extends Search
{
    /**
     * The endpoint for pre-book request.
     *
     * @var string
     */
    protected $endpoint = '/pre-book';

    /**
     * The array of search codes.
     *
     * @var array
     */
    protected $searchCodes = [];

    /**
     * The array of services.
     *
     * @var array
     */
    protected $services = [];

    public function __construct($apiBase = 'https://aether3-dev.innstant-servers.com')
    {
        parent::__construct($apiBase);
    }

    /**
     * Set the search codes.
     *
     * @param string $code
     * @param int    $quantity
     *
     * @return $this
     */
    public function setCode(string $code, int $quantity = 1)
    {
        $this->searchCodes[] = [
            'code'     => $code,
            'quantity' => $quantity,
        ];

        return $this;
    }

    /**
     * Set the search codes.
     *
     * @param array $codes
     *
     * @return $this
     */
    public function setCodes(array $codes)
    {
        $this->searchCodes = $codes;

        return $this;
    }

    /**
     * Set the service.
     *
     * @return $this
     */
    public function setService()
    {
        $this->services[] = [
            'searchCodes'   => $this->searchCodes,
            'searchRequest' => [
                'client' => [
                    'ip'        => self::$clientIp ?? null,
                    'userAgent' => self::$clientUserAgent ?? null,
                ],
                'currencies'      => $this->currencies,
                'customerCountry' => $this->customerCountry,
                'customFields'    => $this->customFields,
                'dates'           => $this->dates,
                'destinations'    => $this->destinations,
                'filters'         => $this->filters,
                'pax'             => $this->pax,
                'service'         => $this->service,
            ]
        ];

        return $this;
    }

    /**
     * Convert the instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $this->setService();

        return [
            'services' => $this->services
        ];
    }
}
