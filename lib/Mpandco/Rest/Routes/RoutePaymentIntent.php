<?php

namespace JeacCorp\Mpandco\Rest\Routes;

use JeacCorp\Mpandco\Model\Base\ModelRoute;
use JeacCorp\Mpandco\Api\Payment\PaymentIntent;
use JeacCorp\Mpandco\Model\Core\Paginator;

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
     * GET: Obtiene un paginador con el historial de las intenciones de pagos
     */
    const PAGINATOR = "api/payment-intent/.json";
    
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
            if($transaction->getAmount()->getCurrency()){
                $t["amount"]["currency"] = $transaction->getAmount()->getCurrency()->getId();
            }
            if(($details = $transaction->getAmount()->getDetails()) !== null){
                $t["amount"]["details"] = [];
                if($details->getShipping() !== 0){
                    $t["amount"]["details"]["shipping"] = $details->getShipping();
                }
                if($details->getTax() !== 0){
                    $t["amount"]["details"]["tax"] = $details->getTax();
                }
                if($details->getSubTotal() !== 0){
                    $t["amount"]["details"]["subTotal"] = $details->getSubTotal();
                }
            }
            $t["description"] = $transaction->getDescription();
            if(!empty($transaction->getInvoiceNumber())){
                $t["invoiceNumber"] = $transaction->getInvoiceNumber();
            }
            $t["items"] = [];
            if($transaction->getDigitalAccountDestination() !== null){
                $t["digitalAccountDestination"] = $transaction->getDigitalAccountDestination()->getUsername();
            }
            foreach ($transaction->getItems() as $item) {
                $i = [
                    "name" => $item->getName(),
                    "price" => $item->getPrice(),
                ];
                if(!empty($item->getQuantity())){
                    $i["quantity"] = $item->getQuantity();
                }
                if(!empty($item->getSku())){
                    $i["sku"] = $item->getSku();
                }
                if(!empty($item->getCurrency())){
                    $i["currency"] = $item->getCurrency()->getId();
                }
                $t["items"][] = $i;
            }
            if($transaction->getDistributions()->count() > 0){
                $t["distributions"] = [];
                foreach($transaction->getDistributions() as $distribution){
                    $d = [
                        "digitalAccountDestination" => $distribution->getDigitalAccountDestination()->getUsername(),
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
     * Ejecuta una intencion de venta
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
     * Ejecuta una intencion de solicitud (facturacion)
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
    
    /**
     * Anula una intencion de pago ejecutada. (en las primeras 24 horas)
     * @param PaymentIntent $paymentIntent
     * @return \JeacCorp\Mpandco\Model\OAuth\TransactionResult
     */
    public function cancel(PaymentIntent $paymentIntent)
    {
        $data  = [
            "cancel_payment_intent" => [
                "paymentIntent" => $paymentIntent->getId(),
            ],
        ];
        $href = $paymentIntent->getLink("cancel")->getHref();
        $transactionResult = $this->oAuth2Service->request(PaymentIntent::class,"POST",$href,[
            "form_params" => $data,
        ]);
        
        return $transactionResult;
    }
    
    /**
     * Obtiene un paginador con las intenciones generadas
     * @return \JeacCorp\Mpandco\Model\OAuth\TransactionResult
     */
    public function getPaginator()
    {
        $transactionResult = $this->createPaginator(self::PAGINATOR,PaymentIntent::class);
       
        return $transactionResult;
    }
}
