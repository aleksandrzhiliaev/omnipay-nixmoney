<?php

namespace Omnipay\Nixmoney;

use Omnipay\Common\AbstractGateway;

/**
 * Gateway Class
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Nixmoney';
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

    public function getDefaultParameters()
    {
        return array(
            'account' => '',
            'accountName' => '',
            'passphrase' => '',
            'baggageFields' => '',
            'paymentId' => '',
            'suggestedMemo' => '',
        );
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nixmoney\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nixmoney\Message\CompletePurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nixmoney\Message\RefundRequest', $parameters);
    }
}
