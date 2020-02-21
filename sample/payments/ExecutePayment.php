<?php

require __DIR__ . '/../bootstrap.php';

use JeacCorp\Mpandco\Model\OAuth\TransactionResult;

// Se verifica si se autorizo la intencion de pago
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $paymentIntentId = $_GET['paymentIntent'];
    $payerId = $_GET["payerId"];
    $transactionResult = $apiContext->getRouteService()->getPaymentIntent()->get($paymentIntentId);
    $paymentIntent = $transactionResult->getValue();
    
    $transactionResult = $apiContext->getRouteService()->getPaymentIntent()->executeSale($paymentIntent,$payerId);
    if(false){
        $transactionResult = new  TransactionResult();
    }
    ResultPrinter::printResult("Ejecucion de intencion", "Pago", $paymentIntent->getId(), $transactionResult, $transactionResult);
    
    if($transactionResult->isSuccess()){
        $paymentIntent = $transactionResult->getValue();
    }else{
        // NOTA: NO USAR RESULTPRINTER EN SU CODIGO. ES SOLO PARA EJEMPLO.
        ResultPrinter::printError("Error ejecutando la intencion de pago", null,$paymentIntent->getId(),$transactionResult);
        exit;
    }
    
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printResult("Obtener intencion de pago", "Intencion de pago", $paymentIntent->getId(), $transactionResult);

    return $paymentIntent;
}else{
    // NOTA: NO USAR RESULTPRINTER EN SU CODIGO. ES SOLO PARA EJEMPLO.
    ResultPrinter::printResult("El usuario cancelo el proceso", null);
    exit;
}