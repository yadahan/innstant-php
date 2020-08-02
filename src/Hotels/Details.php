<?php

namespace Yadahan\Innstant\Hotels;

class Details extends Search
{
    /**
     * The endpoint for details request.
     *
     * @var string
     */
    protected $endpoint;

    public function __construct($hotel, $apiBase = 'https://search.mishor5.innstant-servers.com')
    {
        parent::__construct($apiBase);

        $this->endpoint = '/hotels/details/'.$hotel;
    }
}
