<?php


namespace Hsntngr\JetMail;


class MailPayload
{
    /**
     * @var ApiUser
     */
    public $authentication;

    /**
     * @var RegularMail
     */
    public $sendMailInput;

    public static function create()
    {
        return new static();
    }

    /**
     * @param ApiUser $authentication
     * @return MailPayload
     */
    public function setAuthentication(ApiUser $authentication): MailPayload
    {
        $this->authentication = $authentication;

        return $this;
    }

    /**
     * @param RegularMail $sendMailInput
     * @return MailPayload
     */
    public function setSendMailInput(RegularMail $sendMailInput): MailPayload
    {
        $this->sendMailInput = $sendMailInput;

        return $this;
    }


}