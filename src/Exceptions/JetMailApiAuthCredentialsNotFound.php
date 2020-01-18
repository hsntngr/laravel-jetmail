<?php


namespace Hsntngr\JetMail\Exceptions;


use Throwable;

class JetMailApiAuthCredentialsNotFound extends \Exception
{
    public function __construct()
    {
        parent::__construct('Kullanıcı Adı ve Token Bilgisi Bulunamadı', 0, null);
    }
}