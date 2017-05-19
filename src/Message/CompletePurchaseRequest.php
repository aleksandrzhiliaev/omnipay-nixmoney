<?php

namespace Omnipay\Nixmoney\Message;

use Omnipay\Common\Exception\InvalidResponseException;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getAccount()
    {
        return $this->getParameter('account');
    }

    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    public function getAccountName()
    {
        return $this->getParameter('accountName');
    }

    public function setAccountName($value)
    {
        return $this->setParameter('accountName', $value);
    }

    public function getBaggageFields()
    {
        return $this->getParameter('baggageFields');
    }

    public function setBaggageFields($value)
    {
        return $this->setParameter('baggageFields', $value);
    }

    public function getSuggestedMemo()
    {
        return $this->getParameter('suggestedMemo');
    }

    public function setSuggestedMemo($value)
    {
        return $this->setParameter('suggestedMemo', $value);
    }

    public function getPasswordMd5()
    {
        return $this->getParameter('passwordMd5');
    }

    public function setPasswordMd5($value)
    {
        return $this->setParameter('passwordMd5', $value);
    }

    public function getPassphrase()
    {
        return $this->getParameter('passphrase');
    }

    public function setPassphrase($value)
    {
        return $this->setParameter('passphrase', $value);
    }

    public function getPaymentId()
    {
        return $this->getParameter('paymentId');
    }

    public function setPaymentId($value)
    {
        return $this->setParameter('paymentId', $value);
    }

    public function getData()
    {
        $theirHash = (string) $this->httpRequest->request->get('V2_HASH');
        $ourHash = $this->createResponseHash($this->httpRequest->request->all());

        if ($theirHash !== $ourHash) {
            throw new InvalidResponseException("Callback hash does not match expected value");
        }

        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    public function createResponseHash($parameters)
    {

        $alternate_password_hash = strtoupper($this->getPasswordMd5());
        $fingerprint = "{$parameters['PAYMENT_ID']}:{$parameters['PAYEE_ACCOUNT']}:{$parameters['PAYMENT_AMOUNT']}:{$parameters['PAYMENT_UNITS']}:{$parameters['PAYMENT_BATCH_NUM']}:{$parameters['PAYER_ACCOUNT']}:{$alternate_password_hash}:{$parameters['TIMESTAMPGMT']}";

        return strtoupper(md5($fingerprint));
    }
}
