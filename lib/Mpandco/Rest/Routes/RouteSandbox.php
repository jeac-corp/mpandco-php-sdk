<?php

namespace JeacCorp\Mpandco\Rest\Routes;

use JeacCorp\Mpandco\Model\Base\ModelRoute;
use JeacCorp\Mpandco\Api\Payment\PaymentIntent;
use GuzzleHttp\Exception\ServerException;

/**
 * Rutas del sandbox
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RouteSandbox extends ModelRoute
{

    const TOKEN = "83a2a1f9105f810757355a843e5579d8";
    const GET_PAYMENT_INTENT_AUTORIZE = "bc38875a09308a2/payment-intent/autorize.json";

    public function paymentIntentAutorize(PaymentIntent $paymentIntent)
    {
        var_dump($paymentIntent->getId());
        $body = [];
        try {
            $response = $this->restService->request("GET", self::GET_PAYMENT_INTENT_AUTORIZE, [
                'query' => $this->buildQuery(['id' => $paymentIntent->getId()])
            ]);
            $body = json_decode((string) $response->getBody(),true);
        } catch (ServerException $ex) {
            echo (string)$ex->getResponse()->getBody();
        }
        return $body;
    }

    private function buildQuery(array $params)
    {
        return array_merge(["access_token" => self::TOKEN], $params);
    }

}
