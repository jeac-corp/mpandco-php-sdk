<?php

namespace JeacCorp\Mpandco\Rest\Routes;

use JeacCorp\Mpandco\Model\Base\ModelRoute;
use JeacCorp\Mpandco\Api\Payment\PaymentIntent;

/**
 * Rutas de intencion de pago
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RoutePaymentIntent extends ModelRoute
{
    /**
     * POST: Genera una intencion de pago
     */
    const GENERATE = "api/payment-intent/.json";
    
    /**
     * GET: Obtiene una intencion de pago
     */
    const GET  = "api/payment-intent/show.json";
    
    /**
     * 
     * @param PaymentIntent $paymentIntent
     * @return \JeacCorp\Mpandco\Model\OAuth\TransactionResult PaymentIntent
     */
    public function generate(PaymentIntent $paymentIntent)
    {
        $data  = [
            "paymentintent" => [
                "intent" => $paymentIntent->getIntent(),
            ],
        ];
        if($paymentIntent->getRedirectUrls()){
            $data["paymentintent"]["redirectUrls"] = [];
            $data["paymentintent"]["redirectUrls"]["returnUrl"] = $paymentIntent->getRedirectUrls()->getReturnUrl();
            $data["paymentintent"]["redirectUrls"]["cancelUrl"] = $paymentIntent->getRedirectUrls()->getCancelUrl();
        }
        $data["paymentintent"]["transactions"] = [];
        foreach($paymentIntent->getTransactions() as $transaction){
            $t = [];
            $t["amount"]["total"] = $transaction->getAmount()->getTotal();
            $t["description"] = $transaction->getDescription();
            $t["items"] = [];
            foreach ($transaction->getItems() as $item) {
                $i = [
                    "name" => $item->getName(),
                    "price" => $item->getPrice(),
                ];
                $t["items"][] = $i;
            }
            if($transaction->getDistributions()->count() > 0){
                $t["distributions"] = [];
                foreach($transaction->getDistributions() as $distribution){
                    $d = [
                        "digitalAccountDestination" => $distribution->getDigitalAccountDestination(),
                        "amount" => $distribution->getAmount(),
                        "description" => $distribution->getDescription(),
                    ];
                    $t["distributions"][] = $d;
                }
            }
            $data["paymentintent"]["transactions"][] = $t;
        }
        if(!empty($paymentIntent->getRecipient())){
            $data["paymentintent"]["recipient"] = $paymentIntent->getRecipient();
        }
//        echo json_encode($data,JSON_PRETTY_PRINT);
        $transactionResult = $this->oAuth2Service->request(PaymentIntent::class,"POST",self::GENERATE,[
            "form_params" => $data,
        ]);
//        var_dump($transactionResult->getValue());
//        echo ((string)$transactionResult->getResponse()->getStatusCode());
//        echo ((string)$transactionResult->getResponse()->getBody());
        return $transactionResult;
    }
    
    /**
     * Obtiene una intencion de pago
     * @param type $id
     * @return \JeacCorp\Mpandco\Model\OAuth\TransactionResult
     */
    public function get($id)
    {
        $transactionResult = $this->oAuth2Service->request(PaymentIntent::class,"GET",self::GET,[
            'query' => ['id' => $id]
        ]);
        return $transactionResult;
    }
    
    /**
     * Ejecuta una intencoin de venta
     * @param PaymentIntent $paymentIntent
     * @param type $payer
     * @return \JeacCorp\Mpandco\Model\OAuth\TransactionResult
     */
    public function executeSale(PaymentIntent $paymentIntent,$payer)
    {
        $data  = [
            "payment_execution" => [
                "paymentIntent" => $paymentIntent->getId(),
                "payer" => $payer,
            ],
        ];
        
        $href = $paymentIntent->getLink("execute")->getHref();
        $transactionResult = $this->oAuth2Service->request(PaymentIntent::class,"POST",$href,[
            "form_params" => $data,
        ]);
        
        return $transactionResult;
    }
    
    /**
     * Ejecuta una intencion de solicitud
     * @param PaymentIntent $paymentIntent
     * @param type $pin
     * @param array $transactions
     * @return \JeacCorp\Mpandco\Model\OAuth\TransactionResult
     */
    public function executeRequest(PaymentIntent $paymentIntent,$pin,array $transactions = [])
    {
        if(count($transactions) === 0){
            $transactions = $paymentIntent->getTransactions();
        }
        $data  = [
            "payment_execution" => [
                "transactions" => [],
                "pin" => $pin,
            ],
        ];
        foreach ($transactions as $transaction) {
            $data["payment_execution"]["transactions"][] = [
                "id" => $transaction->getId(),
                "payToken" => $transaction->getPayTokenToUse()->getId(),
            ];
        }
        
        $href = $paymentIntent->getLink("execute")->getHref();
        $transactionResult = $this->oAuth2Service->request(PaymentIntent::class,"POST",$href,[
            "form_params" => $data,
        ]);
//        print_r($data);
        return $transactionResult;
    }
}
