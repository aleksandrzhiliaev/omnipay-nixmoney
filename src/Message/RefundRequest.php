<?php

namespace Omnipay\Nixmoney\Message;

class RefundRequest extends AbstractRequest
{
    protected $endpoint = 'https://www.nixmoney.com/send';

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
