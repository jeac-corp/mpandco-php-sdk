<?php

namespace JeacCorp\Mpandco\Api\User;

use JeacCorp\Mpandco\Model\Base\ModelBase;

/**
 * Cuenta electronica
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class DigitalAccount extends ModelBase
{
    /**
     * Nombre de la cuenta electronica
     * @var string
     */
    private $name;
    
    /**
     * Nombre de usuario
     * @var string
     */
    private $username;
    
    public function __construct($username = null)
    {
        $this->username = $username;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    
}
