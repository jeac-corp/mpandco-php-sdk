<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api\Payment\RedirectUrls;

use JeacCorp\Mpandco\Model\Base\ModelBase;

/**
 * Historial de respuesta de las llamadas a las url de retorno
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class HistoryResponse extends ModelBase
{
    /**
     * Asociada
     * @var \JeacCorp\Mpandco\Api\Payment\RedirectUrls
     */
    private $redirectUrls;
    
    /**
     * Url llamada
     * @var string
     */
    private $uri;
    
    /**
     * Metodo usado
     * @var string
     */
    private $method;
    
    /**
     * Codigo de respuesta
     * @var int 
     */
    private $statusCode;
    
    /**
     * Respuesta
     * @var string 
     */
    private $body;
    
    public function getRedirectUrls()
    {
        return $this->redirectUrls;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setRedirectUrls(\JeacCorp\Mpandco\Api\Payment\RedirectUrls $redirectUrls)
    {
        $this->redirectUrls = $redirectUrls;
        return $this;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }
    
    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
}
