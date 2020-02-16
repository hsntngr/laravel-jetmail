<?php


namespace Hsntngr\JetMail;


use Hsntngr\JetMail\Exceptions\JetMailApiAuthCredentialsNotFound;
use Illuminate\Mail\Mailable;

class JetMail
{
    /**
     * @var array
     */
    public $recipient = [];

    public function to($address)
    {
        if (is_array($address)) {
            $this->recipient = $address;
        }

        if (is_string($address)) {
            array_push($this->recipient, $address);
        }

        if (is_object($address)) {
            if ($address instanceof \ArrayAccess) {
                $this->recipient = array_merge($this->recipient,  (array) $address);
            } else {
                array_push($this->recipient, (string) $address);
            }
        }

        return $this;
    }

    public function send($mail)
    {
        if ($mail instanceof Mailable) {
            $mail = RegularMail::buildFrom($mail);
        }

        if ($this->recipient) {
            $mail->to($this->recipient);
        }

        $this->prepare($mail);

        $token = config('jetmail.auth.token');
        $username = config('jetmail.auth.username');

        if (!($token && $username)) {
            throw new JetMailApiAuthCredentialsNotFound();
        }

        $apiUser = ApiUser::create()
            ->setToken($token)
            ->setUserName($username);

        $payload = MailPayload::create()
            ->setAuthentication($apiUser)
            ->setSendMailInput($mail);


        return JetMailClient::create()
            ->initiate()
            ->setPayload($payload)
            ->send();
    }

    public function prepare(RegularMail &$mail)
    {
        if (is_null($mail->SendFromEmail)) {
            $mail->SendFromEmail = config('jetmail.from.address') ?? config('mail.address');
        }

        if (is_null($mail->SendFromName)) {
            $mail->SendFromName = config('jetmail.from.name') ?? config('mail.name');
        }
    }
}