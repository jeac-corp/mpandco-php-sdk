<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api\Payment\Transaction\Amount;

use Doctrine\ORM\Mapping as ORM;
use Pandco\Bundle\AppBundle\Model\Base\ModelBase;

/**
 * Detalles del monto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="api_payment_intents_transactions_amounts_details")
 * @ORM\Entity()
 */
class Details extends ModelBase
{
    /**
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction\Amount
     * @ORM\OneToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\Transaction\Amount",inversedBy="details")
     * @ORM\JoinColumn(nullable=false)
     */
    private $amount;
    
    /**
     * Costo de Envio
     * @var float
     * @ORM\Column(name="shipping", type="decimal", precision=50, scale=18, nullable=false) 
     */
    private $shipping;
    
    /**
     * Monto de Impuestos
     * @var float
     * @ORM\Column(name="tax", type="decimal", precision=50, scale=18, nullable=false)  
     */
    private $tax;
    
    /**
     * Sub total (suma de los items)
     * @var float
     * @ORM\Column(name="sub_total", type="decimal", precision=50, scale=18, nullable=false) 
     */
    private $subTotal;

    /**
     * Set shipping
     *
     * @param string $shipping
     *
     * @return Details
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Get shipping
     *
     * @return string
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set tax
     *
     * @param string $tax
     *
     * @return Details
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set subTotal
     *
     * @param string $subTotal
     *
     * @return Details
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    /**
     * Get subTotal
     *
     * @return string
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }
    
    public function getAmount() {
        return $this->amount;
    }

    public function setAmount(\JeacCorp\Mpandco\Api\Payment\Transaction\Amount $amount) {
        $this->amount = $amount;
        return $this;
    }
}
