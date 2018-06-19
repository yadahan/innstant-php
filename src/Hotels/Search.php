<?php

namespace Yadahan\Innstant\Hotels;

use Yadahan\Innstant\Innstant;

class Search extends Innstant
{
    /**
     * The endpoint for search request.
     *
     * @var string
     */
    protected $endpoint = '/hotels/search';

    /**
     * The array of currencies.
     *
     * @var array
     */
    protected $currencies = [];

    /**
     * The customer country.
     *
     * @var string
     */
    protected $customerCountry = 'IL';

    /**
     * The array of custom fields.
     *
     * @var array
     */
    protected $customFields = [];

    /**
     * The array of dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The array of destinations.
     *
     * @var array
     */
    protected $destinations = [];

    /**
     * The array of filters.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * The array of pax.
     *
     * @var array
     */
    protected $pax = [];

    /**
     * The timeout.
     *
     * @var int
     */
    protected $timeout = 12;

    /**
     * The service.
     *
     * @var string
     */
    protected $service = 'hotels';

    public function __construct($apiBase = 'https://search.mishor5.innstant-servers.com')
    {
        parent::__construct($apiBase);
    }

    /**
     * Set the currencies.
     *
     * @param array $currencies
     *
     * @return $this
     */
    public function setCurrencies($currencies)
    {
        $this->currencies = $currencies;

        return $this;
    }

    /**
     * Set the customer country.
     *
     * @param string $country
     *
     * @return $this
     */
    public function setCustomerCountry(string $country)
    {
        $this->customerCountry = $country;

        return $this;
    }

    /**
     * Set the destinations.
     *
     * @param int    $id
     * @param string $type
     *
     * @return $this
     */
    public function setDestination(int $id, string $type = 'location')
    {
        $this->destinations[] = [
            'id'   => $id,
            'type' => $type,
        ];

        return $this;
    }

    /**
     * Set the dates.
     *
     * @param string $from
     * @param string $to
     *
     * @return $this
     */
    public function setDates(string $from, string $to)
    {
        $this->dates = [
            'from' => $from,
            'to'   => $to,
        ];

        return $this;
    }

    /**
     * Set the filters.
     *
     * @param string $name
     * @param bool   $value
     *
     * @return $this
     */
    public function setFilter(string $name, bool $value = true)
    {
        $this->filters[] = [
            'name'  => $name,
            'value' => $value,
        ];

        return $this;
    }

    /**
     * Set the pax.
     *
     * @param int   $adults
     * @param array $children
     *
     * @return $this
     */
    public function setPax(int $adults, array $children)
    {
        $this->pax[] = [
            'adults'   => $adults,
            'children' => $children,
        ];

        return $this;
    }

    /**
     * Set the pax.
     *
     * @param array $paxes
     *
     * @return $this
     */
    public function setPaxes(array $paxes)
    {
        $this->pax = $paxes;

        return $this;
    }

    /**
     * Convert the instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
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
            'timeout'         => $this->timeout,
        ];
    }
}
