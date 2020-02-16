<?php


namespace Hsntngr\JetMail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

class RegularMail
{
    /**
     * Alıcı mail adresleri
     * @var array
     */
    public $Emailaddress = [];

    /**
     * Cevabın yönlendirileceği mail adresi
     * @var string
     */
    public $ReplyToEmail;

    /**
     * Gönderici mail adresi
     * @var string
     */
    public $SendFromEmail;

    /**
     * Gönderici ismi
     * @var string
     */
    public $SendFromName;

    /**
     * Mailin gönderileceği tarih
     * @var string
     */
    public $StartTime;

    /**
     * Mail Formatı
     * @var string
     */
    public $Format = 'b';

    /**
     * Html Mail İçeriği
     * @var string
     */
    public $HtmlBody;

    /**
     * Text Mail İçeriği
     * @var string
     */
    public $TextBody;

    /**
     * Mail Başlığı
     * @var string
     */
    public $Subject;

    /**
     * Mailin oluşturulacağı view
     * @var string
     */
    public $View;

    /**
     * Mail oluşturulurken kullanılacak view parametreleri
     * @var array
     */
    public $ViewData = [];

    /**
     * Laravelin kendi mail maillerini jet maile dönüştürür.
     * @param Mailable $mail
     * @return RegularMail
     */
    public static function buildFrom(Mailable $mail)
    {
        $mail->build();

        $jetmail = new static();

        $jetmail->to($mail->to);
        $jetmail->from(
            optional($mail->from)->address,
            optional($mail->from)->name
        );
        $jetmail->subject($mail->subject);
        $viewData = array_merge($mail->viewData, get_object_vars($mail));
        $jetmail->html(View::make($mail->view, $viewData)->render());

        return $jetmail;
    }

    /**
     * Alıcı Mail adresi
     * @param $address
     * @return RegularMail
     */
    public function to($address)
    {
        if (is_array($address)) {
            $this->Emailaddress = $address;
        }

        if (is_string($address)) {
            array_push($this->Emailaddress, $address);
        }

        if (is_object($address)) {
            if ($address instanceof \ArrayAccess) {
                $this->recipient = array_merge($this->Emailaddress,  (array) $address);
            } else {
                array_push($this->Emailaddress, (string) $address);
            }
        }

        return $this;
    }

    /**
     * Cevabın yönlendirileceği mail adresi
     * @param $address
     * @return RegularMail
     */
    public function replyTo($address)
    {
        $this->ReplyToEmail = $address;

        return $this;
    }

    /**
     * Gönderici mail adresi ve ismi
     * @param $email
     * @param $name
     * @return RegularMail
     */
    public function from($email, $name)
    {
        $this->SendFromEmail = $email;
        $this->SendFromName = $name;

        return $this;
    }

    /**
     * Mail başlığı
     * @param $subject
     * @return RegularMail
     */
    public function subject($subject)
    {
        $this->Subject = $subject;

        return $this;
    }

    /**
     * Mailin teslim edileceği tarihi erteler
     * @param $minutes
     * @return RegularMail
     */
    public function delayByJetMail($minutes)
    {
        $this->StartTime = Carbon::now()
            ->addMinutes($minutes)
            ->format('ddMMyyyyHHmmss');

        return $this;
    }

    /**
     * Mail gövdesinin oluşturulacağı view ve
     * viewe ait parametreler
     * @param $view
     * @param array $data
     * @return RegularMail
     */
    public function view($view, $data = [])
    {
        $this->View = $view;
        $this->ViewData = $data;

        return $this;
    }

    /**
     * Mail text gövdesi
     * @param $text
     * @return RegularMail
     */
    public function text($text)
    {
        $this->TextBody = $text;

        return $this;
    }

    /**
     * Mail html gövdesi
     * @param $html
     * @return RegularMail
     */
    public function html($html)
    {
        $this->HtmlBody = $html;

        return $this;
    }

    /**
     * Girilen view ve parametreleri
     * kullanarak html oluşturur
     *
     * @return string
     */
    public function render()
    {
        if ($this->TextBody) {
            return $this->TextBody;
        }

        if ($this->HtmlBody) {
            return $this->HtmlBody;
        }

        return View::make($this->View, $this->ViewData)->render();
    }

    /**
     * Girilen bilgilerden Jet Mail oluşturur
     * @return RegularMail
     */
    protected function build()
    {
        return $this;
    }
}