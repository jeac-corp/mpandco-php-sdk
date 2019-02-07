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
 * Recursos asociados generados a partir de la transaccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RelatedResources extends ModelBase
{
    /**
     * Intencion de pago asociado
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction
     */
    private $transaction;
    
    /**
     * Pago asociado a la venta
     * @var \JeacCorp\Mpandco\Api\TransactionItem\Payment
     */
    private $sale;
    
    /**
     * Solicitu de pago aosciado a la intencion
     * @var \JeacCorp\Mpandco\Api\TransactionItem\Payment
     */
    private $request;
    
    public function getTransaction() {
        return $this->transaction;
    }

    public function getSale() {
        return $this->sale;
    }

    public function setTransaction(\JeacCorp\Mpandco\Api\Payment\Transaction $transaction) {
        $this->transaction = $transaction;
        return $this;
    }

    public function setSale(\JeacCorp\Mpandco\Api\TransactionItem\Payment $sale) {
        $this->sale = $sale;
        return $this;
    }
    
    public function getRequest() {
        return $this->request;
    }

    public function setRequest(\JeacCorp\Mpandco\Api\TransactionItem\Payment $request) {
        $this->request = $request;
        return $this;
    }
}