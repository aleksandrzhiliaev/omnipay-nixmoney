<?php

namespace Omnipay\Nixmoney\Message;

use Omnipay\Common\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
{
    private $endpoint = 'https://www.nixmoney.com/merchant.jsp';

    public function getEndpoint()
    {
        return $this->endpoint;
    }

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

    public function getData()
    {
        $this->validate('account', 'accountName', 'currency', 'amount');

        $data['PAYEE_ACCOUNT'] = $this->getAccount();
        $data['PAYEE_NAME'] = $this->getAccountName();
        $data['PAYMENT_AMOUNT'] = $this->getAmount();
        $data['PAYMENT_URL'] = $this->getReturnUrl();
        $data['NOPAYMENT_URL'] = $this->getCancelUrl();
        $data['BAGGAGE_FIELDS'] = $this->getBaggageFields();
        $data['PAYMENT_ID'] = $this->getTransactionId();
        $data['STATUS_URL'] = $this->getNotifyUrl();
        $data['SUGGESTED_MEMO'] = $this->getSuggestedMemo();

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data, $this->getEndpoint());
    }
}
