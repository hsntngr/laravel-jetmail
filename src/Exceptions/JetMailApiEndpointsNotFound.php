<?php


namespace Hsntngr\JetMail\Exceptions;


use Throwable;

class JetMailApiEndpointsNotFound extends \Exception
{
    public function __construct()
    {
        parent::__construct('wswsdlurl, wsbaseurl ve wsrefurl bilgilerine config dosyasında bulunamadı', 0, null);
    }
}