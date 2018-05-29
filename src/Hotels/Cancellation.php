<?php

namespace Yadahan\Innstant\Hotels;

class Cancellation extends Search
{
    /**
     * The endpoint for cancellation request.
     *
     * @var string
     */
    protected $endpoint;

    public function __construct($room)
    {
        $this->endpoint = '/hotels/cancellation/'.$room;
    }
}
