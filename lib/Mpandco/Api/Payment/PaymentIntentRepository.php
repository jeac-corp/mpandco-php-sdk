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

use Pandco\Bundle\AppBundle\Model\Base\EntityRepository;
use Application\Sonata\UserBundle\Entity\User;

/**
 * Repositorio de Intencion de pago por API
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PaymentIntentRepository extends EntityRepository
{
    /**
     * Busca los intentos de pagos autorizado
     */
    public function findAuthorizedForUser(array $criteria = []) {
        $user = $criteria["user"];
        $qb = $this->getQueryBuilder();
        $qb
            ->innerJoin("pi.payer","pi_p")
            ->andWhere("pi.user = :user")
            ->andWhere("pi.state = :state")
            ->setParameter("state",PaymentIntent::STATE_AUTHORIZED)
            ->setParameter("user",$user)
            ;
        return $qb;
    }
    
    /**
     * Busca una intencion de pago por el pago y el recurso asociado
     * @param \Pandco\Bundle\AppBundle\Entity\User\TransactionItem\Payment $payment
     * @param type $type
     * @return type
     */
    public function findByRelatedResources(\Pandco\Bundle\AppBundle\Entity\User\TransactionItem\Payment $payment,$type)
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->innerJoin("pi.transactions","pi_t")
            ->innerJoin("pi_t.relatedResources","pi_t_rr")
            ->andWhere(sprintf("pi_t_rr.%s = :payment",$type))
            ->setMaxResults(1)
            ->setParameter("payment",$payment)
            ;
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    public function getAlias() {
        return "pi";
    }
}
