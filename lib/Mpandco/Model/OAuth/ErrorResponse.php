<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Model\Payment\OAuth;

use JeacCorp\Mpandco\Model\Payment\OAuth\ErrorResponse\ErrorException;

/**
 * Representacion de Error 400 en formularios
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ErrorResponse
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
     * @var Child
     */
    private $errors;

    /**
     * @var ErrorException
     */
    private $error;

    /// <summary>
    /// Retorna el primer error encontrado de una propiedad especifica
    /// </summary>
    /// <returns>The first error for property.</returns>
    /// <param name="property">Property.</param>
    public function getFirstErrorForProperty($property)
    {
        return $this->errors->getFirstErrorForProperty($property);
    }

    /// <summary>
    /// Retorna el primer error encontrado
    /// </summary>
    /// <returns>The one error.</returns>
    public function getOneError()
    {
        //Util.log(TAG , "getOneError");
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

}