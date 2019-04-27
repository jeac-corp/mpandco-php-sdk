<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Test\Mpandco\Rest;

use JeacCorp\Test\Mpandco\BaseTest;
use JeacCorp\Mpandco\Rest\Routes\RoutePaymentIntent;
use JeacCorp\Mpandco\Api\Payment\PaymentIntent;
use JeacCorp\Mpandco\Api\Payment\Transaction;
use JeacCorp\Mpandco\Api\Payment\Transaction\Item;
use JeacCorp\Mpandco\Api\Payment\Transaction\Amount;
use JeacCorp\Mpandco\Model\OAuth\TransactionResult;

/**
 * Prueba de rutas de intencion de pago
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RoutePaymentIntentTest extends BaseTest
{
    /**
     * Generar intención de pago (Botón de pago).
     */
    public function testGenerateSale()
    {
        $routePaymentIntent = $this->getRouteService()->getPaymentIntent();

        $redirectUrls = new \JeacCorp\Mpandco\Api\Payment\RedirectUrls();
        $redirectUrls->setCancelUrl("http://localhost:5000/payments/ExecutePayment.php?success=true&carId=200")
                ->setReturnUrl("http://localhost:5000/payments/ExecutePayment.php?success=false&carId=200");

        $amount = new Amount();
        $amount->setTotal("20");
        $item = new Item();
        $item
            ->setName("telefono")
            ->setPrice("7.5")
        ;
        $transaction = new Transaction();
        $transaction
                ->setDescription("Compra por eBay")
                ->setAmount($amount)
                ->addItem($item);

        $paymentIntent = new PaymentIntent();
        $paymentIntent->setIntent(PaymentIntent::INTENT_SALE);
        $paymentIntent
                ->setRedirectUrls($redirectUrls)
        ;
        $paymentIntent->addTransaction($transaction);
        
        $transactionResult = $routePaymentIntent->generate($paymentIntent);
        
        $this->checkData($transactionResult);
        $pi = $transactionResult->getValue();
        $this->assertEquals(PaymentIntent::INTENT_SALE, $pi->getIntent());
        $this->assertNotNull($pi->getLink("approval_url")->getHref(),"No se encontro el enlace de approval_url");
        
        return $transactionResult;
    }
    
    /**
     * Generar intención de pago (API de facturación).
     */
    public function testGenerateRequest()
    {
        $routeSandbox = $this->getRouteService()->getSandbox();
        $routePaymentIntent = $this->getRouteService()->getPaymentIntent();
        $steps = [
            'Given check requirement for execution',
            'Given a global client "natural" phone with "584125550002"',
            'Given a global client "natural" phone with "584125550001"',
            'Given I added "50000" to "available" balance',
            'Given a global client "business" phone with "584125550000"',
            'Given I am logged in api as "584125550000"',
            'Given I "authorized" digital account "J255500006" to received in app',
            'Given I set username "demo04" to digital account "J255500006"',
        ];
        $routeSandbox->behatStepsAction($steps);

        $redirectUrls = new \JeacCorp\Mpandco\Api\Payment\RedirectUrls();
        $redirectUrls->setCancelUrl("http://localhost:5000/payments/ExecutePayment.php?success=true&carId=200")
                ->setReturnUrl("http://localhost:5000/payments/ExecutePayment.php?success=false&carId=200");

        $amount = new Amount();
        $amount->setTotal("20");
        $item = new Item();
        $item
            ->setName("telefono")
            ->setPrice("7.5")
        ;
        $transaction = new Transaction();
        $transaction
                ->setDescription("Compra por eBay")
                ->setAmount($amount)
                ->addItem($item);

        $paymentIntent = new PaymentIntent();
        $paymentIntent
                ->setIntent(PaymentIntent::INTENT_REQUEST)
                ->setRecipient("04125550001")
                ;
        $paymentIntent
                ->setRedirectUrls($redirectUrls)
        ;
        $paymentIntent->addTransaction($transaction);
        
        $transactionResult = $routePaymentIntent->generate($paymentIntent);

        
        $this->checkData($transactionResult);
        $pi = $transactionResult->getValue();
        $this->assertEquals(PaymentIntent::INTENT_REQUEST, $pi->getIntent());
        $this->assertNull($pi->getLink("approval_url")->getHref(),"No deberia tener enlace de approval_url");
        
        return $transactionResult;
    }
    
    /**
     * Prueba que se pueda recuperar una intencion de pago
     */
    public function testGet()
    {
        $routePaymentIntent = $this->getPaymentIntent();
        
        $transactionResult = $this->testGenerateSale();
        $this->assertTrue($transactionResult->isSuccess());
        
        $pi = $transactionResult->getValue();
        
        $transactionResult = $routePaymentIntent->get($pi->getId());
        $this->assertTrue($transactionResult->isSuccess());
        $this->assertInstanceOf(PaymentIntent::class, $transactionResult->getValue());
        
        $this->checkData($transactionResult);
    }
    
    /**
     * Prueba la ejecucion de una intencion de venta
     */
    public function testExecuteSale()
    {
        $routeSandbox = $this->getRouteService()->getSandbox();
        $routePaymentIntent = $this->getRouteService()->getPaymentIntent();
        
        $transactionResult = $this->testGenerateSale();
        $this->assertTrue($transactionResult->isSuccess());
        
        $pi = $transactionResult->getValue();
        
        //Autorizar
        $response = $routeSandbox->paymentIntentAutorize($pi);
        
        $transactionResult = $routePaymentIntent->executeSale($pi,$response["payer"]);
        $this->assertTrue($transactionResult->isSuccess());
        $this->assertEquals(PaymentIntent::STATE_EXECUTED,$transactionResult->getValue()->getState());
    }
    
    /**
     * Prueba la ejecucion de una intencion de solicitud (facturacion)
     */
    public function testExecuteRequest()
    {
        $routeSandbox = $this->getRouteService()->getSandbox();
        $routePaymentIntent = $this->getRouteService()->getPaymentIntent();
        
        $transactionResult = $this->testGenerateRequest();
        $this->assertTrue($transactionResult->isSuccess());
        
        $pi = $transactionResult->getValue();
        
        $pin = "1111";
        $transactionResult = $routePaymentIntent->executeRequest($pi,$pin);
//        var_dump($transactionResult->getHttpStatus());
//        echo((string)$transactionResult->getResponse()->getBody());
        $pi = $transactionResult->getValue();
        $this->assertTrue($transactionResult->isSuccess());
        $this->assertEquals(PaymentIntent::STATE_EXECUTED,$pi->getState());
    }

    /**
     * @return RoutePaymentIntent
     */
    private function getPaymentIntent()
    {
        $routeService = $this->getRouteService();

        $routePaymentIntent = $routeService->getPaymentIntent();
        $this->assertInstanceOf(RoutePaymentIntent::class, $routePaymentIntent);
        
        return $routePaymentIntent;
    }
    
    /**
     * Verifica data
     * @param TransactionResult $transactionResult
     */
    private function checkData(TransactionResult $transactionResult)
    {
        $this->assertEquals(200, $transactionResult->getHttpStatus());
        $pi = $transactionResult->getValue();
        $this->assertInstanceOf(PaymentIntent::class,$pi);
        
        $this->assertNotNull($pi->getId());
        $this->assertEquals(PaymentIntent::STATE_CREATED, $pi->getState());
        $this->assertEquals("http://localhost:5000/payments/ExecutePayment.php?success=true&carId=200", $pi->getRedirectUrls()->getCancelUrl());
        $this->assertEquals("http://localhost:5000/payments/ExecutePayment.php?success=false&carId=200", $pi->getRedirectUrls()->getReturnUrl());
        
        $transaction = $pi->getTransactions()->get(0);
        $this->assertEquals("Compra por eBay", $transaction->getDescription());
        $this->assertEquals("20", $transaction->getAmount()->getTotal());
        $this->assertEquals("telefono", $transaction->getItems()->get(0)->getName());
        $this->assertEquals("7.5", $transaction->getItems()->get(0)->getPrice());
        
        $this->assertNotNull($pi->getLink("self")->getHref());
        $this->assertNotNull($pi->getLink("execute")->getHref(),"No se encontro el enlace de execute");
    }
}
