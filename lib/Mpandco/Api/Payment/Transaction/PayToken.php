<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api\Payment\Transaction;

use JeacCorp\Mpandco\Model\Base\ModelBase;

/**
 * Token de pago para una transaccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PayToken extends ModelBase
{
    /**
     * Transaccion asociada
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction
     */
    private $transaction;
    
    
    public function getTransaction() {
        return $this->transaction;
    }

    public function setTransaction(\JeacCorp\Mpandco\Api\Payment\Transaction $transaction) {
        $this->transaction = $transaction;
        return $this;
    }

}
