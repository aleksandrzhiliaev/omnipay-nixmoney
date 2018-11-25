<?php

namespace Omnipay\Nixmoney\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Nixmoney\Support\Helpers;

class RefundResponse extends AbstractResponse
{
    protected $message;
    protected $success;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
        $this->success = false;
        $this->parseResponse();
    }

    public function isSuccessful()
    {
        return $this->success;
    }

    public function getMessage()
    {
        return $this->message;
    }

    private function parseResponse()
    {

        if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $this->data, $result, PREG_SET_ORDER)) {
            $this->message = 'Invalid response';
            $this->success = false;

            return false;
        }

        $array = [];
        foreach ($result as $item) {
            $key = $item[1];
            $array[$key] = $item[2];
        }


        if (isset($array['ERROR'])) {
            $this->message = $array['ERROR'];
            $this->success = false;

            return false;
        }

        $this->success = true;
    }

}
