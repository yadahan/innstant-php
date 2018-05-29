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

    public function __construct($hotel)
    {
        $this->endpoint = '/hotels/details/'.$hotel;
    }
}
