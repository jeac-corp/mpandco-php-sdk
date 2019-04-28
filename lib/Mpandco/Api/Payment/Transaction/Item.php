<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api\Payment\Transaction;

use JeacCorp\Mpandco\Model\Base\ModelBase;

/**
 * Detalles del item a pagar
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Item extends ModelBase
{
    /**
     * Transaccion asociada
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction
     */
    private $transaction;
    
    /**
     * Nombre del item (cafe, pantalon)
     * @var string
     */
    private $name;
    
    /**
     * Cantidad de items
     * @var int
     */
    private $quantity;
    
    /**
     * Moneda
     * @var \JeacCorp\Mpandco\Api\Master\Currency
     */
    private $currency;
    
    /**
     * Numero del producto o identificador
     * @var string 
     */
    private $sku;
    
    /**
     * Precio sin IVA
     * @var float 
     */
    private $price;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Item
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set sku
     *
     * @param string $sku
     *
     * @return Item
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set transaction
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction $transaction
     *
     * @return Item
     */
    public function setTransaction(\JeacCorp\Mpandco\Api\Payment\Transaction $transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction
     *
     * @return \JeacCorp\Mpandco\Api\Payment\Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Set currency
     *
     * @param \Pandco\Bundle\AppBundle\Entity\Master\Currency $currency
     *
     * @return Item
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
}
