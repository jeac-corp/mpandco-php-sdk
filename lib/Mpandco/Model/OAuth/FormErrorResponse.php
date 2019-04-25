<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Model\OAuth;

/**
 * Representacion de Error 400 en formularios
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class FormErrorResponse
{
    /**
     * Codigo de error
     * @var integer 
     */
    private $code;
    
    /**
     * Mensaje de error
     * @var string 
     */
    private $message;

    /**
     * @var FormErrorResponse\Child
     */
    private $errors;

    /// Retorna el primer error encontrado de una propiedad especifica
    public function getFirstErrorForProperty($property)
    {
        return $this->errors->getFirstErrorForProperty($property);
    }

    /// Retorna el primer error encontrado
    public function getOneError()
    {
        if ($this->errors != null) {
            return $this->errors->getFirstError();
        }
        return "";
    }
    
    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
}