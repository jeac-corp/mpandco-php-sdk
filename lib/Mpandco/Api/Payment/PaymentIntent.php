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

use JeacCorp\Mpandco\Model\Payment\ModelPaymentIntent;

/**
 * Intencion de pago API
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PaymentIntent extends ModelPaymentIntent
{
//    use \Pandco\Bundle\AppBundle\Model\Base\Traits\UserTrait;
    
    /**
     * Pagador que autoriza a debitar
     * @var Payer
     */
    private $payer;

    /**
     * Intento de pago
     * @var string self::INTENT_*
     */
    private $intent;
    
    /**
     * Estatus
     * @var string 
     */
    private $state;
    
    /**
     * @var RedirectUrls
     */
    private $redirectUrls;
    
    /**
     * @var Total
     */
    private $total;
    
    /**
     * @var Transaction
     */
    private $transactions;
    
    /**
     * Persona que recibe la solicitud de pago
     * @var string
     */
    private $recipient;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set intent
     *
     * @param string $intent
     *
     * @return Payment
     */
    public function setIntent($intent)
    {
        $this->intent = $intent;

        return $this;
    }

    /**
     * Get intent
     *
     * @return string
     */
    public function getIntent()
    {
        return $this->intent;
    }

    /**
     * Set redirectUrls
     *
     * @param \JeacCorp\Mpandco\Api\Payment\RedirectUrls $redirectUrls
     *
     * @return Payment
     */
    public function setRedirectUrls(\JeacCorp\Mpandco\Api\Payment\RedirectUrls $redirectUrls)
    {
        $redirectUrls->setPaymentIntent($this);
        $this->redirectUrls = $redirectUrls;

        return $this;
    }

    /**
     * Get redirectUrls
     *
     * @return \JeacCorp\Mpandco\Api\Payment\RedirectUrls
     */
    public function getRedirectUrls()
    {
        return $this->redirectUrls;
    }

    /**
     * Add transaction
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction $transaction
     *
     * @return Payment
     */
    public function addTransaction(\JeacCorp\Mpandco\Api\Payment\Transaction $transaction)
    {
        $transaction->setPaymentIntent($this);
        $this->transactions[] = $transaction;

        return $this;
    }

    /**
     * Remove transaction
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction $transaction
     */
    public function removeTransaction(\JeacCorp\Mpandco\Api\Payment\Transaction $transaction)
    {
        $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }
    
    public function getPayer() {
        if($this->payer === null){
            $this->setPayer(new Payer());
        }
        return $this->payer;
    }

    public function setPayer(Payer $payer) {
        $payer->setPaymentIntent($this);
        $this->payer = $payer;
        return $this;
    }
    
    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
        return $this;
    }
    
    public function getTotal() {
        if(!$this->total){
            $this->total = new Total();
            $this->total->setPaymentIntent($this);
        }
        return $this->total;
    }
    
    public function getRecipient() {
        return $this->recipient;
    }

    public function setRecipient($recipient = null) {
        $this->recipient = $recipient;
        return $this;
    }
    
    public function getOAuthApp() {
        return $this->oAuthApp;
    }

    public function setOAuthApp(\Pandco\Bundle\AppBundle\Entity\Auth\OAuthApp $oAuthApp) {
        $this->oAuthApp = $oAuthApp;
        return $this;
    }
            
    public function totalize() {
        $total = $this->getTotal();
        $currency = null;
        $shipping = $tax =  $subTotal = 0.0;
        foreach ($this->transactions as $transaction) {
            $amount = $transaction->getAmount();
            if($currency === null){
                $currency = $amount->getCurrency();
            }
            $shipping = CurrencyUtil::sum($shipping,$amount->getDetails()->getShipping());
            $tax = CurrencyUtil::sum($tax,$amount->getDetails()->getTax());
            $subTotal = CurrencyUtil::sum($subTotal,$amount->getDetails()->getSubTotal());
        }
        $total->setCurrency($currency);
        $total->setShipping($shipping);
        $total->setTax($tax);
        $total->setItems($subTotal);
        $total->totalize();
    }
}
