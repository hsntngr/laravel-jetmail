<?php


namespace Hsntngr\JetMail;


class ApiUser
{
    public $Token;

    public $UserName;

    public static function create()
    {
        return new static();
    }

    /**
     *
     * Jetmail tarafından size verilen token
     *
     * @param string $Token
     * @return ApiUser
     */
    public function setToken($Token)
    {
        $this->Token = $Token;
        return $this;
    }

    /**
     * Api kullanıcı adınız
     *
     * @param string $UserName
     * @return ApiUser
     */
    public function setUserName($UserName)
    {
        $this->UserName = $UserName;
        return $this;
    }


}