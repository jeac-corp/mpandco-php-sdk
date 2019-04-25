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

use GuzzleHttp\Psr7\Response;

/**
 * Resultado de transaccion ejecutada
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class TransactionResult
{
    /**
     * La peticion se ejecuto correctamente?
     * @var bool
     */
    private $success;
    
    /**
     * Codigo http de respuesta
     * @var int
     */
    private $httpStatus;
    
    /**
     * Valor solicitado deserializado
     * @var object
     */
    private $value;
    
    /**
     * Valor plano de respuesta
     * @var \GuzzleHttp\Psr7\Response
     */
    private $rawValue;
    
    /**
     * Error en respuesta de formulario
     * @var FormErrorResponse
     */
    private $errorResponse;
    
    public function __construct($value,Response $rawValue, FormErrorResponse $errorResponse = null)
    {
        $this->success = ($rawValue->getStatusCode() >= 200 && $rawValue->getStatusCode() <= 299);
        $this->httpStatus = $rawValue->getStatusCode();
        $this->value = $value;
        $this->rawValue = $rawValue;
        $this->errorResponse = $errorResponse;
    }
    
    public function isSuccess()
    {
        return $this->success;
    }

    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getRawValue()
    {
        return $this->rawValue;
    }

    public function getErrorResponse()
    {
        return $this->errorResponse;
    }
}
