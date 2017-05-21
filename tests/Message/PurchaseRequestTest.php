<?php

namespace Omnipay\Nixmoney\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{

    /**
     *
     * @var PurchaseRequest
     *
     */
    private $request;

    protected function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
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

    public function testGetData()
    {
        $data = $this->request->getData();

        $expectedData = [
            'PAYEE_ACCOUNT' => 'Account',
            'PAYEE_NAME' => 'AccountName',
            'PAYMENT_AMOUNT' => '10.00',
            'PAYMENT_URL' => 'ReturnUrl',
            'NOPAYMENT_URL' => 'CancelUrl',
            'BAGGAGE_FIELDS' => 'BaggageFields',
            'PAYMENT_ID' => 1,
            'STATUS_URL' => 'NotifyUrl',
            'SUGGESTED_MEMO' => 'SuggestedMemo',
        ];

        $this->assertEquals($expectedData, $data);
    }

    public function testSendSuccess()
    {
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('https://www.nixmoney.com/merchant.jsp', $response->getRedirectUrl());
        $this->assertEquals('GET', $response->getRedirectMethod());
    }


}