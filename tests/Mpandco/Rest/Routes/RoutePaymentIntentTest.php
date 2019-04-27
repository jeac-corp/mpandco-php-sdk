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
     * @return RoutePaymentIntent
     */
    private function getRoutePaymentIntent()
    {
        $routeService = $this->getRouteService();

        $routePaymentIntent = $routeService->getPaymentIntent();
        $this->assertInstanceOf(RoutePaymentIntent::class, $routePaymentIntent);
        
        return $routePaymentIntent;
    }
    
    private function checkData(TransactionResult $transactionResult)
    {
        $this->assertEquals(200, $transactionResult->getHttpStatus());
        $pi = $transactionResult->getValue();
        $this->assertInstanceOf(PaymentIntent::class,$pi);
        
        $this->assertNotNull($pi->getId());
//        $this->assertEquals(PaymentIntent::INTENT_SALE, $pi->getIntent());
        $this->assertEquals(PaymentIntent::STATE_CREATED, $pi->getState());
        $this->assertEquals("http://localhost:5000/payments/ExecutePayment.php?success=true&carId=200", $pi->getRedirectUrls()->getCancelUrl());
        $this->assertEquals("http://localhost:5000/payments/ExecutePayment.php?success=false&carId=200", $pi->getRedirectUrls()->getReturnUrl());
        
        $transaction = $pi->getTransactions()->get(0);
        $this->assertEquals("Compra por eBay", $transaction->getDescription());
        $this->assertEquals("20", $transaction->getAmount()->getTotal());
        $this->assertEquals("telefono", $transaction->getItems()->get(0)->getName());
        $this->assertEquals("7.5", $transaction->getItems()->get(0)->getPrice());
        
        $this->assertNotNull($pi->getLink("self")->getHref());
        $this->assertNotNull($pi->getLink("execute")->getHref());
        $this->assertNotNull($pi->getLink("approval_url")->getHref());
    }


    /**
     * Generar intención de pago (Botón de pago).
     */
    public function testGenerateSale()
    {
        $routePaymentIntent = $this->getRoutePaymentIntent();

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
        
        return $transactionResult;
    }
    
    /**
     * Generar intención de pago (API de facturación).
     */
    public function testGenerateRequest()
    {
        $routePaymentIntent = $this->getRoutePaymentIntent();

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
                ->setRecipient("V25550099")
                ;
        $paymentIntent
                ->setRedirectUrls($redirectUrls)
        ;
        $paymentIntent->addTransaction($transaction);
        
        $transactionResult = $routePaymentIntent->generate($paymentIntent);
        var_dump($transactionResult->getErrorResponse()->getOneError());
        
        $this->checkData($transactionResult);
        
        return $transactionResult;
    }
    
    /**
     * Prueba que se pueda recuperar una intencion de pago
     */
    public function testGet()
    {
        $routePaymentIntent = $this->getRoutePaymentIntent();
        
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
        $routeService = $this->getRouteService();
        $routeSandbox = $routeService->getRouteSandbox();
        $routePaymentIntent = $this->getRoutePaymentIntent();
        
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
     * Prueba la ejecucion de una intencion de solicitud
     */
    public function testExecuteRequest()
    {
        $routeService = $this->getRouteService();
        $routeSandbox = $routeService->getRouteSandbox();
        $routePaymentIntent = $this->getRoutePaymentIntent();
        
        $transactionResult = $this->testGenerateSale();
        $this->assertTrue($transactionResult->isSuccess());
        
        $pi = $transactionResult->getValue();
        
        //Autorizar
        $response = $routeSandbox->paymentIntentAutorize($pi);
        
        $transactionResult = $routePaymentIntent->executeSale($pi,$response["payer"]);
        $this->assertTrue($transactionResult->isSuccess());
        $this->assertEquals(PaymentIntent::STATE_EXECUTED,$transactionResult->getValue()->getState());
    }

}
