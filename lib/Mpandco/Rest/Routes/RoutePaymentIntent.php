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
        
    }
}
