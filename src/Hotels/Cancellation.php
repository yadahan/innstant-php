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

    public function __construct($room, $apiBase = 'https://search.mishor5.innstant-servers.com')
    {
        parent::__construct($apiBase);

        $this->endpoint = '/hotels/cancellation/'.$room;
    }
}
