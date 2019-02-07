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
use JeacCorp\Mpandco\Api\User\DigitalAccount;

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
    
    /**
     * Cuenta electronica de la cual se realizara el pago
     * @var \JeacCorp\Mpandco\Api\User\DigitalAccount
     */
    private $digitalAccount;
    
    public function getTransaction() {
        return $this->transaction;
    }

    public function getDigitalAccount() {
        return $this->digitalAccount;
    }

    public function setTransaction(\JeacCorp\Mpandco\Api\Payment\Transaction $transaction) {
        $this->transaction = $transaction;
        return $this;
    }

    public function setDigitalAccount(DigitalAccount $digitalAccount) {
        $this->digitalAccount = $digitalAccount;
        return $this;
    }
}
