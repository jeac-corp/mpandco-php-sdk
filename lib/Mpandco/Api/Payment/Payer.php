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
 * Pagador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Payer extends ModelBase
{
    /**
     * Intencion de pago
     * @var PaymentIntent
     */
    private $paymentIntent;
    
    /**
     * Usuario que realizo la autoriazacion del pago
     * @var \JeacCorp\Mpandco\Api\Payment\Payer\PayerInfo
     */
    private $payerInfo;
    
    public function getPaymentIntent() {
        return $this->paymentIntent;
    }

    public function setPaymentIntent(PaymentIntent $paymentIntent) {
        $this->paymentIntent = $paymentIntent;
        return $this;
    }
    
    public function getPayerInfo() {
        return $this->payerInfo;
    }

    public function setPayerInfo(\Application\Sonata\UserBundle\Entity\User $payerInfo) {
        $this->payerInfo = $payerInfo;
        return $this;
    }

}
