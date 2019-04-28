<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api\Payment;

use JeacCorp\Mpandco\Model\Base\ModelBase;

/**
 * Transacciones del pago
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Transaction extends ModelBase
{
    /**
     * Intencion de pago asociado
     * @var PaymentIntent
     */
    private $paymentIntent;
    
    /**
     * Monto de la operacion sin IVA
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction\Amount 
     */
    private $amount;
    
    /**
     * Elementos a cobrar
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction\Item 
     */
    private $items;
    
    /**
     * Descripcion de la operacion
     * @var string
     */
    private $description;
    
    /**
     * Numero de factura asociada al pago
     * @var string
     */
    private $invoiceNumber;
    
    /**
     * Recursos generados por la transaccion
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction\RelatedResources 
     */
    private $relatedResources;
    
    /**
     * Tokens para realizar pagos
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction\PayToken
     */
    private $payTokens;
    
    /**
     * Cuenta electronica a la cual se abonara el pago
     * @var \JeacCorp\Mpandco\Api\User\DigitalAccount
     */
    private $digitalAccountDestination;
    
    /**
     * Distribucion de dinero
     * @var Transaction\Distribution 
     */
    private $distributions;
    
    /**
     * Variable volatil del token a ejecutar en la transaccion
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction\PayToken 
     */
    private $payTokenToUse;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->payTokens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->distributions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Transaction
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set invoiceNumber
     *
     * @param string $invoiceNumber
     *
     * @return Transaction
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * Get invoiceNumber
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Add item
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction\Item $item
     *
     * @return Transaction
     */
    public function addItem(\JeacCorp\Mpandco\Api\Payment\Transaction\Item $item)
    {
        $item->setTransaction($this);
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction\Item $item
     */
    public function removeItem(\JeacCorp\Mpandco\Api\Payment\Transaction\Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set paymentIntent
     *
     * @param \JeacCorp\Mpandco\Api\Payment\PaymentIntent $paymentIntent
     *
     * @return Transaction
     */
    public function setPaymentIntent(\JeacCorp\Mpandco\Api\Payment\PaymentIntent $paymentIntent)
    {
        $this->paymentIntent = $paymentIntent;

        return $this;
    }

    /**
     * Get paymentIntent
     *
     * @return \JeacCorp\Mpandco\Api\Payment\PaymentIntent
     */
    public function getPaymentIntent()
    {
        return $this->paymentIntent;
    }
    
    public function getAmount() {
        return $this->amount;
    }

    public function setAmount(\JeacCorp\Mpandco\Api\Payment\Transaction\Amount $amount) {
        $amount->setTransaction($this);
        $this->amount = $amount;
        return $this;
    }
    
    public function getRelatedResources() {
        if(!$this->relatedResources){
            $this->setRelatedResources(new Transaction\RelatedResources());
        }
        return $this->relatedResources;
    }

    public function setRelatedResources(Transaction\RelatedResources $relatedResources) {
        $relatedResources->setTransaction($this);
        $this->relatedResources = $relatedResources;
        return $this;
    }

    /**
     * Remove payToken
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction\PayToken $payToken
     */
    public function removePayToken(\JeacCorp\Mpandco\Api\Payment\Transaction\PayToken $payToken)
    {
        $this->payTokens->removeElement($payToken);
    }

    /**
     * Get payTokens
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayTokens()
    {
        return $this->payTokens;
    }
    
    /**
     * @return \JeacCorp\Mpandco\Api\User\DigitalAccount
     */
    public function getDigitalAccountDestination()
    {
        return $this->digitalAccountDestination;
    }

    public function setDigitalAccountDestination(\JeacCorp\Mpandco\Api\User\DigitalAccount $digitalAccountDestination)
    {
        $this->digitalAccountDestination = $digitalAccountDestination;
        return $this;
    }
    
    /**
     * @return Transaction\Distribution
     */
    public function getDistributions()
    {
        return $this->distributions;
    }

    public function addDistribution(Transaction\Distribution $distribution)
    {
        $distribution->setTransaction($this);
        $this->distributions[] = $distribution;
        return $this;
    }

    /**
     * Remove Distribution
     *
     * @param Transaction\Distribution
     */
    public function removeDistribution(Transaction\Distribution $distribution)
    {
        $this->distributions->removeElement($distribution);
    }
    
    /**
     * Establece el token de pago a usar
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction\PayToken $payTokenToUse
     * @return $this
     */
    public function setPayTokenToUse(\JeacCorp\Mpandco\Api\Payment\Transaction\PayToken $payTokenToUse)
    {
        $this->payTokenToUse = $payTokenToUse;
        return $this;
    }
    
    /**
     * Retorna el token de pago a usar en la transaccion
     * @return Transaction\PayToken
     * @throws \JeacCorp\Mpandco\Exception\PayTokenRequiredException
     */
    public function getPayTokenToUse()
    {
        if(empty($this->payTokenToUse)){
            if($this->payTokens->count() > 1){
                throw new \JeacCorp\Mpandco\Exception\PayTokenRequiredException($this->payTokens->count());
            }else{
                $this->payTokenToUse = $this->payTokens->get(0);
            }
        }
        return $this->payTokenToUse;
    }
}
