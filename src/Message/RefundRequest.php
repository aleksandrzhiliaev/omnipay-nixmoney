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

    public function getPassphrase()
    {
        return $this->getParameter('passphrase');
    }

    public function setPassphrase($value)
    {
        return $this->setParameter('passphrase', $value);
    }

    public function getPayeeAccount()
    {
        return $this->getParameter('payeeAccount');
    }

    public function setPayeeAccount($value)
    {
        return $this->setParameter('payeeAccount', $value);
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
