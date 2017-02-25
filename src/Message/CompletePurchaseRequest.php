<?php

namespace Omnipay\Nixmoney\Message;

use Omnipay\Common\Exception\InvalidResponseException;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getPasswordMd5()
    {
        return $this->getParameter('passwordMd5');
    }

    public function setPasswordMd5($value)
    {
        return $this->setParameter('passwordMd5', $value);
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
