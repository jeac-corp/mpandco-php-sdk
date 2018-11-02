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

use InvalidArgumentException;
use JMS\Serializer\Annotation\Type;
USE JeacCorp\Mpandco\Validation\NumericValidator;

/**
 * Item de pago
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Item 
{
    /**
     * Numero o referencia de su item
     * @var string
     * @Type("string")
     */
    private $sku;
    /**
     * Nombre del item
     * @var string
     * @Type("string")
     */
    private $name;
    
    /**
     * Cantidad
     * @var integer
     * @Type("integer")
     */
    private $quantity;
    
    /**
     * Moneda (VEF,USD)
     * @see https://es.wikipedia.org/wiki/ISO_4217
     * @var string
     * @Type("string")
     */
    private $currency;
    /**
     * Precio neto
     * @var double
     * @Type("double")
     */
    private $price;
    
    public function getSku() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setSku($sku) {
        $this->sku = $sku;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setQuantity($quantity) {
        if(!is_int($quantity)){
            throw new InvalidArgumentException(sprintf("The quantity must be of the integer type. Given %s",  gettype($quantity)));
        }
        $this->quantity = $quantity;
        return $this;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    public function setPrice($price) {
        NumericValidator::validate($price,"price");
        $this->price = $price;
        return $this;
    }


}
