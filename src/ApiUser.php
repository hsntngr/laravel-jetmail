<?php


namespace Hsntngr\JetMail;


class ApiUser
{
    /**
     * Api token
     * @var string
     */
    public $Token;

    /**
     * Api username
     * @var string
     */
    public $UserName;

    /**
     * ApiUser sınıfını örnekler
     * @return ApiUser
     */
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