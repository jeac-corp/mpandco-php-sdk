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

use Doctrine\ORM\Mapping as ORM;
use Pandco\Bundle\AppBundle\Model\Base\ModelBase;

/**
 * Monto de la transaccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="api_payment_intents_transactions_amounts")
 * @ORM\Entity()
 */
class Amount extends ModelBase
{
    /**
     * Transaccion
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction
     * @ORM\OneToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\Transaction",inversedBy="amount")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transaction;
    
    /**
     * Moneda
     * @var \Pandco\Bundle\AppBundle\Entity\Master\Currency
     * @ORM\ManyToOne(targetEntity="Pandco\Bundle\AppBundle\Entity\Master\Currency")
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency;
    
    /**
     * Total con IVA
     * @var float
     * @ORM\Column(name="total", type="decimal", precision=50, scale=18, nullable=false) 
     */
    private $total;
    
    /**
     * Detalles del monto
     * @var Amount\Details
     * @ORM\OneToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\Transaction\Amount\Details",cascade={"persist","remove"},mappedBy="amount")
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
