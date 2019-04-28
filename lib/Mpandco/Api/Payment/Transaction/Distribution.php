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

use JeacCorp\Mpandco\Model\Payment\Transaction\ModelDistribution;

/**
 * Distribucion de dinero en cuentas autorizadas luego de ejecutar una transaccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Distribution extends ModelDistribution
{
    /**
     * Transaccion
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction
     */
    private $transaction;
    
    /**
     * Estatus
     * @var string 
     * @ORM\Column(type="string",length=20)
     */
    private $state;
    
    /**
     * Cuenta electronica a la cual se abonara el dinero
     * @var \JeacCorp\Mpandco\Api\User\DigitalAccount
     */
    private $digitalAccountDestination;
    
    /**
     * Monto de Impuestos
     * @var float
     * @ORM\Column(name="tax", type="decimal", precision=50, scale=18, nullable=false)  
     */
    private $amount;
    
    /**
     * Descripcion de la distribucion (esto le saldra en el detalle de la transaccion debe ser corto)
     * @var string
     */
    private $description;
    
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function setDigitalAccountDestination(\JeacCorp\Mpandco\Api\User\DigitalAccount $digitalAccountDestination)
    {
        $this->digitalAccountDestination = $digitalAccountDestination;
        return $this;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getTransaction()
    {
        return $this->transaction;
    }

    public function setTransaction(\JeacCorp\Mpandco\Api\Payment\Transaction $transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }
    
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return \JeacCorp\Mpandco\Api\User\DigitalAccount
     */
    public function getDigitalAccountDestination()
    {
        return $this->digitalAccountDestination;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getDescription()
    {
        return $this->description;
    }


}
