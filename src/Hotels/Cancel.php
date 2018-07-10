<?php

namespace Yadahan\Innstant\Hotels;

class Cancel extends Search
{
    /**
     * The endpoint for cancel booking request.
     *
     * @var string
     */
    protected $endpoint = '/booking-cancel';

    /**
     * The booking id.
     *
     * @var int
     */
    protected $bookingID;

    /**
     * The cancel reason.
     *
     * @var string
     */
    protected $cancelReason = '';

    /**
     * Force cancel.
     *
     * @var bool
     */
    protected $force = false;

    /**
     * Is manual.
     *
     * @var bool
     */
    protected $isManual = false;

    public function __construct($id, $apiBase = 'https://book.mishor5.innstant-servers.com')
    {
        parent::__construct($apiBase);

        $this->bookingID = $id;
    }

    /**
     * Set the cancel reason.
     *
     * @param string $reason
     *
     * @return $this
     */
    public function setCancelReason(string $reason = '')
    {
        $this->cancelReason = $reason;

        return $this;
    }

    /**
     * Force cancel.
     *
     * @return $this
     */
    public function force()
    {
        $this->force = true;

        return $this;
    }

    /**
     * Is manual.
     *
     * @return $this
     */
    public function manual()
    {
        $this->isManual = true;

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
            'BookingID'    => (int) $this->bookingID,
            'CancelReason' => $this->cancelReason,
            'Force'        => $this->force,
            'IsManual'     => $this->isManual,
        ];
    }
}
