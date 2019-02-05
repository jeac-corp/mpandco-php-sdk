<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api\Payment\Payer;

use Doctrine\ORM\Mapping as ORM;
use Pandco\Bundle\AppBundle\Model\Base\ModelBase;

/**
 * Informacion del pagador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="api_payment_intents_payers_infos")
 * @ORM\Entity()
 */
class PayerInfo extends ModelBase 
{
    /**
     * Correo electronico
     * @var string
     * @ORM\Column()
     */
    private $email;
    
    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $payer;
    
    /**
     * Telefono
     * @var string
     * @ORM\Column()
     */
    private $phone;
    
    /**
     * Pais
     * @var \Pandco\Bundle\AppBundle\Entity\Master\Country
     * @ORM\ManyToOne(targetEntity="Pandco\Bundle\AppBundle\Entity\Master\Country")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;
    
}
