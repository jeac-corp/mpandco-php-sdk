<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Model\Payment\Transaction;

use JeacCorp\Mpandco\Model\Base\ModelBase;

/**
 * Description of ModelDistribution
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ModelDistribution extends ModelBase
{
    /**
     * Estatus: Creado
     */
    const STATE_CREATED = "created";
    
    /**
     * Estatus: Ejecutado (se abono al receptor el dinero y se ejecuto la transaccion)
     */
    const STATE_EXECUTED = "executed";
    
    /**
     * Estatus: Error (ocurrio un error y no se pudo realizar la distribucion, por lo tanto la transaccion no debe estar asociada)
     */
    const STATE_ERROR = "error";
}
