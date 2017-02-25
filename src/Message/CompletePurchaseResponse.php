<?php

namespace Omnipay\Nixmoney\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;
use Exception;

class CompletePurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return ($this->data['PAYMENT_BATCH_NUM'] != 0) ? true : false;
    }

    public function isCancelled()
    {
        return ($this->data['PAYMENT_BATCH_NUM'] == 0) ? true : false;
    }

    public function isRedirect()
    {
        return false;
    }

    public function getRedirectUrl()
    {
        return null;
    }

    public function getRedirectMethod()
    {
        return null;
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getTransactionId()
    {
        return isset($this->data['PAYMENT_ID']) ? $this->data['PAYMENT_ID'] : null;
    }

    public function getAmount()
    {
        return isset($this->data['PAYMENT_AMOUNT']) ? $this->data['PAYMENT_AMOUNT'] : null;
    }

    public function getTransactionReference()
    {
        return isset($this->data['PAYMENT_BATCH_NUM']) and $this->data['PAYMENT_BATCH_NUM'] != 0 ? $this->data['PAYMENT_BATCH_NUM'] : null;
    }

    public function getCurrency()
    {
        return $this->data['PAYMENT_UNITS'];
    }

    public function getMessage()
    {
        return null;
    }
}
