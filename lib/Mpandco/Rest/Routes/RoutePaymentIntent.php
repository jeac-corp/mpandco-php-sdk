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
     * POST: Ejecuta una intencion de pago
     */
    const EXECUTE  = "api/payment-intent/execute/sale.json";
    
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
            $data["paymentintent"]["transactions"] = $t;
        }
//        echo json_encode($data,JSON_PRETTY_PRINT);
        $response = $this->oAuth2Service->request("POST",self::GENERATE,[
            "form_params" => $data,
        ]);
//        var_dump($response);
        echo ((string)$response->getStatusCode());
        echo ((string)$response->getBody());
    }
}
