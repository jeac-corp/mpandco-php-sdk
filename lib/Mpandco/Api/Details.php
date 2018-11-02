<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api;

use JMS\Serializer\Annotation\Type;

/**
 * Detalle de la operacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Details 
{
    /**
     * Costo de envio
     * @var double
     * @Type("double")
     */
    private $shipping;
    
    /**
     * Monto del Iva
     * @var double
     * @Type("double")
     */
    private $tax;
    
    /**
     * Sub total
     * @var double
     * @Type("double")
     */
    private $subtotal;
    
    public function getShipping() {
        return $this->shipping;
    }

    public function getTax() {
        return $this->tax;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function setShipping($shipping) {
        NumericValidator::validate($shipping,"shipping");
        $this->shipping = $shipping;
        return $this;
    }

    public function setTax($tax) {
        NumericValidator::validate($tax,"tax");
        $this->tax = $tax;
        return $this;
    }

    public function setSubtotal($subtotal) {
        NumericValidator::validate($subtotal,"subtotal");
        $this->subtotal = $subtotal;
        return $this;
    }
}
