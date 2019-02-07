<?php

namespace JeacCorp\Mpandco\Api\TransactionItem;

use JeacCorp\Mpandco\Model\Base\ModelBase;

/**
 * Pago
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Payment extends ModelBase
{
    /**
     * Referencia del pago
     * @var string
     */
    private $ref;
    
    public function getRef()
    {
        return $this->ref;
    }

    public function setRef($ref)
    {
        $this->ref = $ref;
        return $this;
    }
}
