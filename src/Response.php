<?php


namespace Hsntngr\JetMail;


class Response
{
    /**
     * JetMail Response
     * @var object
     */
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Response sınıfını örnekler
     *
     * @param $response
     * @return Response
     */
    public static function create($response)
    {
        return new static($response);
    }

    /**
     * Gönderilen maile jet mail tarafından verilen
     * stat id değerini getirir
     *
     * @return mixed
     */
    public function getStatId()
    {
        return $this->response->ResponseStatus->StatId;
    }

    /**
     * Mail gönderiminin başarılı olması durumunda çalıştırılır
     *
     * @param callable $callback
     * @return Response
     */
    public function onSuccess(callable $callback)
    {
        if ($this->response->ResponseStatus->Status == 'SUCCESS') {
            $callback();
        }

        return $this;
    }

    /**
     * Mail gönderiminin başarısız olması durumunda çalıştırılır
     *
     * @param callable $callback
     * @return Response
     */
    public function onError(callable $callback)
    {
        if ($this->response->ResponseStatus->Status != 'SUCCESS') {
            $callback();
        }

        return $this;
    }

    /**
     * Mail gönderiminin sonucu getirir
     *
     * @return string (SUCCESS | ERROR)
     */
    public function getStatus()
    {
        return $this->response->ResponseStatus->Status;
    }

    /**
     * Mail gönderiminin başarısız olması durumunda hata
     * mesajını getirir.
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->response->ResponseStatus->ErrorMessage;
    }
}