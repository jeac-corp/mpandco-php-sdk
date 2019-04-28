<?php

require __DIR__ . '/../bootstrap.php';

use JeacCorp\Mpandco\Rest\Routes\RoutePaymentIntent;
use JeacCorp\Mpandco\Api\Payment\PaymentIntent;
use JeacCorp\Mpandco\Api\Payment\Transaction;
use JeacCorp\Mpandco\Api\Payment\Transaction\Item;
use JeacCorp\Mpandco\Api\Payment\Transaction\Amount;
use JeacCorp\Mpandco\Model\OAuth\TransactionResult;
use JeacCorp\Mpandco\Api\Payment\RedirectUrls;

$baseUrl = getBaseUrl();

$routePaymentIntent = $this->getRouteService()->getPaymentIntent();

$redirectUrls = new RedirectUrls();
$redirectUrls->setCancelUrl("$baseUrl/ExecutePayment.php?success=false")
        ->setReturnUrl("$baseUrl/ExecutePayment.php?success=true");

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
