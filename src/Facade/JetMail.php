<?php


namespace Hsntngr\JetMail\Facade;


class JetMail extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'jetmailer';
    }
}