<?php

namespace Omnipay\Nixmoney\Message;

class RefundRequest extends AbstractRequest
{
    protected $endpoint = 'https://www.nixmoney.com/send';

    public function getAccount()
    {
        return $this->getParameter('account');
    }

    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    public function getPayeeAccount()
    {
        return $this->getParameter('payeeAccount');
    }

    public function setPayeeAccount($value)
    {
        return $this->setParameter('payeeAccount', $value);
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
        $this->validate('payeeAccount', 'amount', 'description');

        $data['PASSPHRASE'] = $this->getPassphrase();
        $data['PAYER_ACCOUNT'] = $this->getAccount();
        $data['PAYEE_ACCOUNT'] = $this->getPayeeAccount();
        $data['AMOUNT'] = $this->getAmount();
        $data['MEMO'] = $this->getDescription();

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->get($this->endpoint, null, ['query'=>$data])->send();
        return $this->response = new RefundResponse($this, $httpResponse->getBody(true));
    }
}
