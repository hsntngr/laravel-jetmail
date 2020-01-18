<?php


namespace Hsntngr\JetMail;


class Response
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public static function create($response)
    {
        return new static($response);
    }

    public function getStatId()
    {
        return $this->response->ResponseStatus->Status->StatId;
    }

    public function onSuccess(callable $callback)
    {
        if ($this->response->ResponseStatus->Status == 'SUCCESS') {
            $callback();
        }

        return $this;
    }

    public function onError(callable $callback)
    {
        if ($this->response->ResponseStatus->Status != 'SUCCESS') {
            $callback();
        }

        return $this;
    }

    public function getStatus()
    {
        return $this->response->ResponseStatus->Status;
    }

    public function getErrorMessage()
    {
        return $this->response->ResponseStatus->ErrorMessage;
    }
}