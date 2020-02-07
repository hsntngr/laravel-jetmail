<?php


namespace Hsntngr\JetMail;


use Hsntngr\JetMail\Exceptions\JetMailApiAuthCredentialsNotFound;
use Illuminate\Mail\Mailable;

class JetMail
{
    public $recipent;

    public function to($address)
    {
        $this->recipent = $address;

        return $this;
    }

    public function send($mail)
    {
        if ($mail instanceof Mailable) {
            $mail = RegularMail::buildFrom($mail);
        }

        if ($this->recipent) {
            $mail->to($this->recipent);
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