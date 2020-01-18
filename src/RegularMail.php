<?php


namespace Hsntngr\JetMail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

class RegularMail
{
    public $Emailaddress;
    public $ReplyToEmail;
    public $SendFromEmail;
    public $SendFromName;
    public $StartTime;
    public $Format = 'b';
    public $HtmlBody;
    public $TextBody;
    public $Subject;
    public $View;
    public $ViewData;

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

    public function to($address)
    {
        $this->Emailaddress = [$address];

        return $this;
    }

    public function replyTo($address)
    {
        $this->ReplyToEmail = $address;

        return $this;
    }

    public function from($email, $name)
    {
        $this->SendFromEmail = $email;
        $this->SendFromName = $name;

        return $this;
    }

    public function subject($subject)
    {
        $this->Subject = $subject;

        return $this;
    }

    public function laterByJetMail($minutes)
    {
        $this->StartTime = Carbon::now()
            ->addMinutes($minutes)
            ->format('ddMMyyyyHHmmss');

        return $this;
    }

    public function view($view, $data = [])
    {
        $this->View = $view;
        $this->ViewData = $data;

        return $this;
    }

    public function text($text)
    {
        $this->TextBody = $text;

        return $this;
    }

    public function html($html)
    {
        $this->HtmlBody = $html;

        return $this;
    }

    public function render()
    {
        if ($this->TextBody) {
            return $this->TextBody;
        }

        if ($this->HtmlBody) {
            return $this->HtmlBody;
        }

        return View::make($this->View, $this->ViewData);
    }

    protected function build()
    {
        return $this;
    }
}