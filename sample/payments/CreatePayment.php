<?php

require __DIR__ . '/../bootstrap.php';

use JeacCorp\Mpandco\Api\Item;
use JeacCorp\Mpandco\Api\ItemList;
use JeacCorp\Mpandco\Api\Details;
use JeacCorp\Mpandco\Api\Amount;
use JeacCorp\Mpandco\Api\Transaction;
use JeacCorp\Mpandco\Api\RedirectUrls;
use JeacCorp\Mpandco\Api\Payment;

$item1 = new Item();
$item1
    ->setName("Cafe 40 oz")
    ->setCurrency("BSF")
    ->setSku("332341")
    ->setQuantity(1)
    ->setPrice(1.8)
    ;

$item2 = new Item();
$item2->setName('Arepa')
    ->setCurrency('BSF')
    ->setQuantity(3)
    ->setSku("44231") // Similar to `item_number` in Classic API
    ->setPrice(2)
        ;

$itemList = new ItemList();
$itemList
    ->addItem($item1)
    ->addItem($item2)
    ;

$details = new Details();
$details
    ->setShipping(200.42)
    ->setTax(10)
    ->setSubtotal(2000)
    ;

$amount = new Amount();
$amount
    ->setCurrency("BSF")
    ->setTotal(10000)
    ->setDetails($details)
    ;

$transaction = new Transaction();
$transaction
    ->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Pago de empanadas")
    ->setInvoiceNumber(uniqid())
    ;

$baseUrl = getBaseUrl();
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
    ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");

$payment = new Payment();
$payment
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));
