<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Rest\Routes;

use JeacCorp\Mpandco\Model\Base\ModelRoute;
use JeacCorp\Mpandco\Api\TransactionItem\Payment;

/**
 * Rutas de pagos
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RoutePayment extends ModelRoute
{
    /**
     * GET: Obtiene un paginador con el historial de las intenciones de pagos
     */
    const PAGINATOR = "api/payment/.json";
    
    /**
     * Obtiene un paginador con los pagos
     * @return \JeacCorp\Mpandco\Model\OAuth\TransactionResult
     */
    public function getPaginator()
    {
        $transactionResult = $this->createPaginator(self::PAGINATOR,Payment::class);
       
        return $transactionResult;
    }
}
