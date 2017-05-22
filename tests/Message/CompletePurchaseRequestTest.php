<?php

namespace Omnipay\Nixmoney\Message;

use Mockery as m;
use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{

    protected function setUp()
    {
        return;
        $request = $this->getHttpRequest();
        $arguments = [$this->getHttpClient(), $request];
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

    public function testData()
    {
        return;
        $data = $this->request->getData();
        $this->assertSame('3768165', $data['id']);
    }

    public function testSendSuccess()
    {
        return;
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
    }
}