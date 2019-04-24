<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
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
     */
    private $digitalAccountDestination;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->payTokens = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    public function getDigitalAccountDestination()
    {
        return $this->digitalAccountDestination;
    }

    public function setDigitalAccountDestination($digitalAccountDestination)
    {
        $this->digitalAccountDestination = $digitalAccountDestination;
        return $this;
    }
}
