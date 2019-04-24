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
    public function testGenerate()
    {
        $routeService = $this->getRouteService();

        $routePaymentIntent = $routeService->getPaymentIntent();
        $this->assertInstanceOf(RoutePaymentIntent::class, $routePaymentIntent);

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
        
        $routePaymentIntent->generate($paymentIntent);
    }

}
