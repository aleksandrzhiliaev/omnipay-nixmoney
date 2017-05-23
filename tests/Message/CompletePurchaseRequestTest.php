<?php

namespace Omnipay\Nixmoney\Message;

use Mockery as m;
use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseRequestTest extends TestCase
{

    private $request;

    protected function setUp()
    {
        $arguments = [$this->getHttpClient(), $this->getHttpRequest()];
        $this->request = m::mock('Omnipay\Nixmoney\Message\CompletePurchaseRequest[getEndpoint]', $arguments);
        $this->request->setAccount('Account');
        $this->request->setAccountName('AccountName');
        $this->request->setBaggageFields('BaggageFields');
        $this->request->setSuggestedMemo('SuggestedMemo');
        $this->request->setPasswordMd5('PasswordMd5');
        $this->request->setPassphrase('Passphrase');
        $this->request->setCurrency('Currency');
        $this->request->setPayeeAccount('PayeeAccount');
        $this->request->setAmount('10.00');
        $this->request->setReturnUrl('ReturnUrl');
        $this->request->setCancelUrl('CancelUrl');
        $this->request->setNotifyUrl('NotifyUrl');
        $this->request->setTransactionId(1);
    }

    public function testCreateResponseHash()
    {
        $parameters = [
            'PAYMENT_ID' => '1488022447',
            'PAYEE_ACCOUNT' => 'U38224612324582',
            'PAYMENT_AMOUNT' => '0.10',
            'PAYMENT_UNITS' => 'USD',
            'PAYMENT_BATCH_NUM' => '636723',
            'PAYER_ACCOUNT' => 'U04174047283211',
            'TIMESTAMPGMT' => '1488022539',
        ];

        $alternatePasswordHash = strtoupper($this->request->getPasswordMd5());

        $expectedFingerpring = "{$parameters['PAYMENT_ID']}:{$parameters['PAYEE_ACCOUNT']}:{$parameters['PAYMENT_AMOUNT']}:{$parameters['PAYMENT_UNITS']}:{$parameters['PAYMENT_BATCH_NUM']}:{$parameters['PAYER_ACCOUNT']}:{$alternatePasswordHash}:{$parameters['TIMESTAMPGMT']}";

        $fingerprint = $this->request->createResponseHash($parameters);
        $this->assertEquals(strtoupper(md5($expectedFingerpring)), $fingerprint);
    }

    public function testSendSuccess()
    {
        $httpRequest = new HttpRequest([], [
            'PAYEE_ACCOUNT' => 'U38224612324582',
            'PAYMENT_ID' => '1488022447',
            'PAYMENT_AMOUNT' => '0.10',
            'PAYMENT_UNITS' => 'USD',
            'PAYMENT_BATCH_NUM' => '636723',
            'PAYER_ACCOUNT' => 'U04174047283211',
            'TIMESTAMPGMT' => '1488022539',
            'V2_HASH' => '6B710987345141E1E4FE634E4FD8B962',
        ]);
        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request->setPasswordMd5('PasswordMd5');
        $response = $request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('1488022447', $response->getTransactionId());
        $this->assertEquals('0.10', $response->getAmount());
        $this->assertEquals('USD', $response->getCurrency());
    }

}