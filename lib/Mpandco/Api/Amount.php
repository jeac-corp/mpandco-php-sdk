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
 * Monto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Amount 
{
    /**
     * Moneda
     * @var string
     * @Type("string")
     */
    private $currency;
    /**
     * Total
     * @var double
     * @Type("double") 
     */
    private $total;
    
    /**
     * Detalles
     * @var \JeacCorp\Mpandco\Api\Details
     * @Type("JeacCorp\Mpandco\Api\Details")  
     */
    private $details;
    
    public function getCurrency() {
        return $this->currency;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getDetails() {
        return $this->details;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    public function setTotal($total) {
        NumericValidator::validate($total, "total");
        $this->total = $total;
        return $this;
    }

    public function setDetails(\JeacCorp\Mpandco\Api\Details $details) {
        $this->details = $details;
        return $this;
    }
}
