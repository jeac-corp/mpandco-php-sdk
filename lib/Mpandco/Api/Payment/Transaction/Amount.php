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
 * Monto de la transaccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Amount extends ModelBase
{
    /**
     * Transaccion
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction
     */
    private $transaction;
    
    /**
     * Moneda
     * @var \JeacCorp\Mpandco\Api\Master\Currency
     */
    private $currency;
    
    /**
     * Total con IVA
     * @var float
     */
    private $total;
    
    /**
     * Detalles del monto
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction\Amount\Details
     */
    private $details;
    
    public function getTransaction() {
        return $this->transaction;
    }

    public function setTransaction(\JeacCorp\Mpandco\Api\Payment\Transaction $transaction) {
        $this->transaction = $transaction;
        return $this;
    }
        
    /**
     * Set total
     *
     * @param string $total
     *
     * @return Amount
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set currency
     *
     * @param \Pandco\Bundle\AppBundle\Entity\Master\Currency $currency
     *
     * @return Amount
     */
    public function setCurrency(\Pandco\Bundle\AppBundle\Entity\Master\Currency $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \Pandco\Bundle\AppBundle\Entity\Master\Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set details
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction\Amount\Details $details
     *
     * @return Amount
     */
    public function setDetails(\JeacCorp\Mpandco\Api\Payment\Transaction\Amount\Details $details)
    {
        $details->setAmount($this);
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return \JeacCorp\Mpandco\Api\Payment\Transaction\Amount\Details
     */
    public function getDetails()
    {
        return $this->details;
    }
}
