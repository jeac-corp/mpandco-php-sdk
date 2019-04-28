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
 * Direcciones de redireccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RedirectUrls extends ModelBase
{
    /**
     * Intencion de pago
     * @var PaymentIntent
     */
    private $paymentIntent;
    
    /**
     * Url de retorno si la el pago se aprueba
     * @var string
     */
    private $returnUrl;
    
    /**
     * Url de retorno si la operacion se cancela
     * @var string
     */
    private $cancelUrl;
    
    /**
     * @var RedirectUrls\HistoryResponse
     */
    private $historyResponses;
    
    public function __construct()
    {
        $this->historyResponses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set returnUrl
     *
     * @param string $returnUrl
     *
     * @return RedirectUrls
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /**
     * Get returnUrl
     *
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * Set cancelUrl
     *
     * @param string $cancelUrl
     *
     * @return RedirectUrls
     */
    public function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;

        return $this;
    }

    /**
     * Get cancelUrl
     *
     * @return string
     */
    public function getCancelUrl()
    {
        return $this->cancelUrl;
    }
    
    public function getPaymentIntent() {
        return $this->paymentIntent;
    }

    public function setPaymentIntent(PaymentIntent $paymentIntent) {
        $this->paymentIntent = $paymentIntent;
        return $this;
    }
    
    /**
     * Add historyResponse
     *
     * @param \JeacCorp\Mpandco\Api\Payment\RedirectUrls\HistoryResponse $historyResponse
     *
     * @return RedirectUrls
     */
    public function addHistoryResponse(\JeacCorp\Mpandco\Api\Payment\RedirectUrls\HistoryResponse $historyResponse)
    {
        $historyResponse->setRedirectUrls($this);
        $this->historyResponses[] = $historyResponse;

        return $this;
    }

    /**
     * Remove historyResponse
     *
     * @param \JeacCorp\Mpandco\Api\Payment\RedirectUrls\HistoryResponse $historyResponse
     */
    public function removeHistoryResponse(\JeacCorp\Mpandco\Api\Payment\RedirectUrls\HistoryResponse $historyResponse)
    {
        $this->historyResponses->removeElement($historyResponse);
    }

    /**
     * Get historyResponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistoryResponses()
    {
        return $this->historyResponses;
    }
    
    /**
     * Construye una URL con el id del intent
     * @param type $property
     * @return type
     */
    public function getUrl($property) {
        $url = $this->{$property};
        $s = "?";
        if(strpos($url,$s) !== false){
            $s = "&";
        }
        $url .= $s."paymentIntent=".$this->paymentIntent->getId();
        $s = "&";
        
        $addPayer = false;
        if($this->paymentIntent->getIntent() == PaymentIntent::INTENT_SALE &&
                $this->paymentIntent->getState() === PaymentIntent::STATE_AUTHORIZED){
            $addPayer = true;
        }else if($this->paymentIntent->getIntent() == PaymentIntent::INTENT_REQUEST){
            $addPayer = true;
        }
        if($addPayer){
            $payer = $this->paymentIntent->getPayer();
            $url .= $s."payerId=".$payer->getPayerInfo()->getId();
        }
        return $url;
    }
}
