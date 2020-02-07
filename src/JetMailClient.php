<?php


namespace Hsntngr\JetMail;

use Hsntngr\JetMail\Exceptions\JetMailApiEndpointsNotFound;
use SoapClient;
use SoapHeader;


class JetMailClient
{
    /**
     * @var SoapClient
     */
    protected $client;

    /**
     * @var MailPayload
     */
    protected $payload;

    /**
     * @return string
     */
    protected $status;

    public static function create()
    {
        return new static();
    }

    /**
     * @return $this
     * @throws \SoapFault
     */
    public function initiate()
    {
        $wswsdlurl = config('jetmail.wswsdlurl');
        $wsbaseurl = config('jetmail.wsbaseurl');
        $wsrefurl  = config('jetmail.wsrefurl');

        if (!($wswsdlurl && $wsbaseurl && $wsrefurl)) {
            throw new JetMailApiEndpointsNotFound();
        }

        $params = [
            "soap_version" => config('jetmail.soap.version'),
            "trace" => config('jetmail.soap.trace'),
            "exceptions" => config('jetmail.soap.exceptions')
        ];

        $this->client = new SoapClient($wswsdlurl, $params);
        $this->client->__setSoapHeaders = null;

        $actionHeaders = [
            new SoapHeader($wsrefurl, 'Action', 'http://tempuri.org/IMailService/SendMail'),
            new SoapHeader($wsrefurl, 'To', $wsbaseurl)
        ];

        $this->client->__setSoapHeaders($actionHeaders);

        return $this;
    }

    /**
     * @param mixed $payload
     * @return JetMailClient
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }


    public function send()
    {
        $response = $this->client->SendMail($this->payload);

        return Response::create($response->SendMailResult);
    }
}