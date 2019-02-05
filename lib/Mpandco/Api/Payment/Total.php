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

use Doctrine\ORM\Mapping as ORM;
use Pandco\Bundle\AppBundle\Model\Base\ModelBase;
use Pandco\Bundle\AppBundle\Service\Util\CurrencyUtil;

/**
 * Total
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="api_payment_intents_transactions_totals")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Total extends ModelBase
{
    /**
     * Intencion de pago
     * @var PaymentIntent
     * @ORM\OneToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\PaymentIntent",inversedBy="total")
     * @ORM\JoinColumn(nullable=false) 
     */
    private $paymentIntent;
    
    /**
     * Moneda
     * @var \Pandco\Bundle\AppBundle\Entity\Master\Currency
     * @ORM\ManyToOne(targetEntity="Pandco\Bundle\AppBundle\Entity\Master\Currency")
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency;
    
    /**
     * Totald item
     * @var float
     * @ORM\Column(name="items", type="decimal", precision=50, scale=18, nullable=false) 
     */
    private $items;
    
    /**
     * Totald de Envio
     * @var float
     * @ORM\Column(name="shipping", type="decimal", precision=50, scale=18, nullable=false) 
     */
    private $shipping;
    
    /**
     * Total de Impuestos
     * @var float
     * @ORM\Column(name="tax", type="decimal", precision=50, scale=18, nullable=false)  
     */
    private $tax;
    
    /**
     * Total (items + shipping + tax;)
     * @var float
     * @ORM\Column(name="amount", type="decimal", precision=50, scale=18, nullable=false) 
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

    public function setCurrency(\Pandco\Bundle\AppBundle\Entity\Master\Currency $currency) {
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
