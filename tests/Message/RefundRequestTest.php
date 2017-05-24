<?php

namespace Omnipay\Nixmoney\Message;

use Guzzle\Plugin\Mock\MockPlugin;
use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{

    /**
     *
     * @var PurchaseRequest
     *
     */
    private $request;

    protected function setUp()
    {
        $mockPlugin = new MockPlugin();
        $mockPlugin->addResponse($this->getMockHttpResponse('RefundSuccess.txt'));
        $httpClient = $this->getHttpClient();
        $httpClient->addSubscriber($mockPlugin);

        $this->request = new RefundRequest($httpClient, $this->getHttpRequest());

        $this->request->setPayeeAccount('PayeeAccount');
        $this->request->setAmount('10.00');
        $this->request->setDescription('Description');
        $this->request->setPassphrase('Passphrase');
        $this->request->setAccount('Account');
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $expectedData = [
            'PASSPHRASE' => 'Passphrase',
            'PAYER_ACCOUNT' => 'Account',
            'PAYEE_ACCOUNT' => 'PayeeAccount',
            'AMOUNT' => '10.00',
            'MEMO' => 'Description',
        ];

        $this->assertEquals($expectedData, $data);
    }

    public function testSendSuccess()
    {
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testSendError()
    {
        $mockPlugin = new MockPlugin();
        $mockPlugin->addResponse($this->getMockHttpResponse('RefundError.txt'));
        $httpClient = $this->getHttpClient();
        $httpClient->addSubscriber($mockPlugin);

        $this->request = new RefundRequest($httpClient, $this->getHttpRequest());
        $this->request->setPayeeAccount('PayeeAccount');
        $this->request->setAmount('10.00');
        $this->request->setDescription('Description');

        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
    }


}