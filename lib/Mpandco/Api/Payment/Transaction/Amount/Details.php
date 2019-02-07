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

use JeacCorp\Mpandco\Model\Base\ModelBase;

/**
 * Detalles del monto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Details extends ModelBase
{
    /**
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction\Amount
     */
    private $amount;
    
    /**
     * Costo de Envio
     * @var float
     */
    private $shipping;
    
    /**
     * Monto de Impuestos
     * @var float
     */
    private $tax;
    
    /**
     * Sub total (suma de los items)
     * @var float
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
