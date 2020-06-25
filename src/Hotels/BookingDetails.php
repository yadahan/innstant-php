<?php

namespace Yadahan\Innstant\Hotels;

use Yadahan\Innstant\Innstant;

class BookingDetails extends Innstant
{
    /**
     * The endpoint for details request.
     *
     * @var string
     */
    protected $endpoint;

    public function __construct($booking, $apiBase = 'https://book.mishor5.innstant-servers.com')
    {
        parent::__construct($apiBase);

        $this->endpoint = '/booking-details/'.$booking;
    }

    public function get()
    {
        return $this->request(null, 'GET');
    }
}
