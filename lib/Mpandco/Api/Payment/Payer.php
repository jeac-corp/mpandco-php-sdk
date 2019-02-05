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

/**
 * Pagador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="api_payment_intents_payers")
 * @ORM\Entity()
 */
class Payer extends ModelBase
{
    /**
     * Intencion de pago
     * @var PaymentIntent
     * @ORM\OneToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\PaymentIntent",inversedBy="payer")
     * @ORM\JoinColumn(nullable=false) 
     */
    private $paymentIntent;
    
    /**
     * Usuario que realizo la autoriazacion del pago
     * @var \Application\Sonata\UserBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $payerInfo;
    
    /**
     * Cuenta electronica de la cual realizo el pago (este campo puede ser nulo cuando es una solicitud de pago)
     * @var \Pandco\Bundle\AppBundle\Entity\User\DigitalAccount
     * @ORM\ManyToOne(targetEntity="Pandco\Bundle\AppBundle\Entity\User\DigitalAccount")
     * @ORM\JoinColumn(nullable=true)
     */
    private $digitalAccountSource;

    public function getDigitalAccountSource() {
        return $this->digitalAccountSource;
    }

    public function setDigitalAccountSource(\Pandco\Bundle\AppBundle\Entity\User\DigitalAccount $digitalAccountSource) {
        $this->digitalAccountSource = $digitalAccountSource;
        return $this;
    }
    
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
