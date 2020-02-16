<?php


namespace Hsntngr\JetMail;


class MailPayload
{
    /**
     * Api kimlik bilgileri
     * @var ApiUser
     */
    public $authentication;

    /**
     * Gönderilecek mail
     * @var RegularMail
     */
    public $sendMailInput;

    /**
     * MailPayload sınıfını örnekler
     * @return MailPayload
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Kullanıcı kimlik bilgilerini set et
     * @param ApiUser $authentication
     * @return MailPayload
     */
    public function setAuthentication(ApiUser $authentication): MailPayload
    {
        $this->authentication = $authentication;

        return $this;
    }

    /**
     * Gönderilecek Maili set et
     * @param RegularMail $sendMailInput
     * @return MailPayload
     */
    public function setSendMailInput(RegularMail $sendMailInput): MailPayload
    {
        $this->sendMailInput = $sendMailInput;

        return $this;
    }


}