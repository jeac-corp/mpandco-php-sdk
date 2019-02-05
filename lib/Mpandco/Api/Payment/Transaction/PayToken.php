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

use Doctrine\ORM\Mapping as ORM;
use Pandco\Bundle\AppBundle\Model\Base\ModelBase;

/**
 * Token de pago para una transaccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="api_payment_intents_transactions_pay_tokens",uniqueConstraints={@ORM\UniqueConstraint(name="mapt_idx", columns={"transaction_id", "digitalAccount_id"})})
 * @ORM\Entity()
 */
class PayToken extends ModelBase
{
    /**
     * Se coloco aqui para colocarle un grupo aparte de serializacion
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;
    
    /**
     * Transaccion asociada
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction
     * @ORM\ManyToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\Transaction",inversedBy="payTokens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transaction;
    
    /**
     * Cuenta electronica de la cual se realizara el pago
     * @var \Pandco\Bundle\AppBundle\Entity\User\DigitalAccount 
     * @ORM\ManyToOne(targetEntity="Pandco\Bundle\AppBundle\Entity\User\DigitalAccount")
     * @ORM\JoinColumn(nullable=false)
     */
    private $digitalAccount;
    
    public function getTransaction() {
        return $this->transaction;
    }

    public function getDigitalAccount() {
        return $this->digitalAccount;
    }

    public function setTransaction(\JeacCorp\Mpandco\Api\Payment\Transaction $transaction) {
        $this->transaction = $transaction;
        return $this;
    }

    public function setDigitalAccount(\Pandco\Bundle\AppBundle\Entity\User\DigitalAccount $digitalAccount) {
        $this->digitalAccount = $digitalAccount;
        return $this;
    }
}
