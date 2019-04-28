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
use JeacCorp\Mpandco\Core\CurrencyUtil;

/**
 * Total
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Total extends ModelBase
{
    /**
     * Intencion de pago
     * @var PaymentIntent
     */
    private $paymentIntent;
    
    /**
     * Moneda
     * @var \JeacCorp\Mpandco\Api\Master\Currency
     */
    private $currency;
    
    /**
     * Totald item
     * @var float
     */
    private $items;
    
    /**
     * Totald de Envio
     * @var float
     */
    private $shipping;
    
    /**
     * Total de Impuestos
     * @var float
     */
    private $tax;
    
    /**
     * Total (items + shipping + tax)
     * @var float
     */
    private $amount;
    
    public function getCurrency() {
        return $this->currency;
    }

    public function getItems() {
        return $this->items;
    }

    public function getShipping() {
        return $this->shipping;
    }

    public function getTax() {
        return $this->tax;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setCurrency(\JeacCorp\Mpandco\Api\Master\Currency $currency) {
        $this->currency = $currency;
        return $this;
    }

    public function setItems($items) {
        $this->items = $items;
        return $this;
    }

    public function setShipping($shipping) {
        $this->shipping = $shipping;
        return $this;
    }

    public function setTax($tax) {
        $this->tax = $tax;
        return $this;
    }
    
    public function getPaymentIntent() {
        return $this->paymentIntent;
    }

    public function setPaymentIntent(PaymentIntent $paymentIntent) {
        $this->paymentIntent = $paymentIntent;
        return $this;
    }
        
    public function totalize() {
        $total = $this->items;
        $total = CurrencyUtil::sum($total,$this->shipping);
        $total = CurrencyUtil::sum($total,$this->tax);
        $this->amount = $total;
    }
    
}
