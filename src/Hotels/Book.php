<?php

namespace Yadahan\Innstant\Hotels;

class Book extends Search
{
    /**
     * The endpoint for book request.
     *
     * @var string
     */
    protected $endpoint = '/book';

    /**
     * The credit card.
     *
     * @var array
     */
    protected $creditCard = [];

    /**
     * The customer.
     *
     * @var array
     */
    protected $customer = [];

    /**
     * The payment method.
     *
     * @var array
     */
    protected $paymentMethod = [];

    /**
     * The reference.
     *
     * @var array
     */
    protected $reference = [];

    /**
     * The booking request.
     *
     * @var array
     */
    protected $bookingRequest = [];

    public function __construct($apiBase = 'https://aether3-dev.innstant-servers.com')
    {
        parent::__construct($apiBase);
    }

    /**
     * Set the credit card.
     *
     * @param string $number
     * @param int    $cvc
     * @param int    $expiryMonth
     * @param int    $expiryYear
     * @param string $firstName
     * @param string $lastName
     *
     * @return $this
     */
    public function setCreditCard(string $number, int $cvc, int $expiryMonth, int $expiryYear, string $firstName, string $lastName = '')
    {
        $this->creditCard = [
            'cardNumber' => $number,
            'cvc'        => $cvc,
            'expiry'     => [
                'month' => $expiryMonth,
                'year'  => $expiryYear,
            ],
            'name'       => [
                'first' => $firstName,
                'last'  => $lastName,
            ],
        ];

        return $this;
    }

    /**
     * Set the customer.
     *
     * @param array  $contact
     * @param string $birthDate
     * @param string $firstName
     * @param string $lastName
     * @param string $title
     *
     * @return $this
     */
    public function setCustomer(array $contact, string $birthDate, string $firstName, string $lastName = '', string $title = 'M')
    {
        $this->customer = [
            'birthDate' => $birthDate,
            'contact'   => [
                'address' => $contact['address'] ?? '',
                'country' => $contact['country'] ?? 'IL',
                'email'   => $contact['email'] ?? '',
                'phone'   => $contact['phone'] ?? '',
                'state'   => $contact['state'] ?? '',
                'zip'     => $contact['zip'] ?? '',
            ],
            'name'      => [
                'first' => $firstName,
                'last'  => $lastName,
            ],
            'title'     => $title,
        ];

        return $this;
    }

    /**
     * Set the payment method.
     *
     * @param string $name
     * @param string $url
     *
     * @return $this
     */
    public function setPaymentMethod(string $name = 'account_credit', string $url = '')
    {
        switch ($name) {
            case 'credit_card':
                $this->paymentMethod = [
                    'methodName'       => 'credit_card',
                    'securePaymentUrl' => $url,
                ];
                break;

            default:
                $this->paymentMethod = [
                    'methodName' => 'account_credit',
                ];
                break;
        }

        return $this;
    }

    /**
     * Set the reference.
     *
     * @param string $agency
     * @param string $email
     *
     * @return $this
     */
    public function setReference(string $agency, string $email)
    {
        $this->reference = [
            'agency'       => $agency,
            'voucherEmail' => $email,
        ];

        return $this;
    }

    /**
     * Set the booking request.
     *
     * @param string $code
     * @param string $token
     * @param array  $pax
     *
     * @return $this
     */
    public function setBookingRequest(string $code, string $token, array $pax)
    {
        $this->bookingRequest[] = [
            'code'  => $code,
            'pax'   => $pax,
            'token' => $token,
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
        return [
            'creditCard'    => $this->creditCard,
            'customer'      => $this->customer,
            'paymentMethod' => $this->paymentMethod,
            'reference'     => $this->reference,
            'services'      => [
                [
                    'bookingRequest' => $this->bookingRequest,
                    'searchRequest'  => [
                        'client'          => [
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
                    ],
                ],
            ],
        ];
    }
}
