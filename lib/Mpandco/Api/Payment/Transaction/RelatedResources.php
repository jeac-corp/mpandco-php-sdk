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
 * Recursos asociados generados a partir de la transaccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="api_payment_intents_transactions_related_resources")
 * @ORM\Entity()
 */
class RelatedResources extends ModelBase
{
    /**
     * Intencion de pago asociado
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction
     * @ORM\OneToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\Transaction",inversedBy="relatedResources")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transaction;
    
    /**
     * Pago asociado a la venta
     * @var \Pandco\Bundle\AppBundle\Entity\User\TransactionItem\Payment
     * @ORM\OneToOne(targetEntity="Pandco\Bundle\AppBundle\Entity\User\TransactionItem\Payment")
     */
    private $sale;
    
    /**
     * Solicitu de pago aosciado a la intencion
     * @var \Pandco\Bundle\AppBundle\Entity\User\TransactionItem\Payment
     * @ORM\OneToOne(targetEntity="Pandco\Bundle\AppBundle\Entity\User\TransactionItem\Payment")
     */
    private $request;
    
    public function getTransaction() {
        return $this->transaction;
    }

    public function getSale() {
        return $this->sale;
    }

    public function setTransaction(\JeacCorp\Mpandco\Api\Payment\Transaction $transaction) {
        $this->transaction = $transaction;
        return $this;
    }

    public function setSale(\Pandco\Bundle\AppBundle\Entity\User\TransactionItem\Payment $sale) {
        $this->sale = $sale;
        return $this;
    }
    
    public function getRequest() {
        return $this->request;
    }

    public function setRequest(\Pandco\Bundle\AppBundle\Entity\User\TransactionItem\Payment $request) {
        $this->request = $request;
        return $this;
    }
}