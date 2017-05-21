<?php

namespace Omnipay\Nixmoney\Message;


class PurchaseRequest extends AbstractRequest
{
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
