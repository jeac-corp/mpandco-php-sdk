<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api\Payment\RedirectUrls;

use Doctrine\ORM\Mapping as ORM;
use Pandco\Bundle\AppBundle\Model\Base\ModelBase;

/**
 * Historial de respuesta de las llamadas a las url de retorno
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="api_payment_intents_redirect_urls_history_responses")
 * @ORM\Entity()
 */
class HistoryResponse extends ModelBase
{
    /**
     * Asociada
     * @var \JeacCorp\Mpandco\Api\Payment\RedirectUrls
     * @ORM\ManyToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\RedirectUrls",inversedBy="historyResponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $redirectUrls;
    
    /**
     * Url llamada
     * @var string
     * @ORM\Column(type="string")
     */
    private $uri;
    
    /**
     * Metodo usado
     * @var string
     * @ORM\Column(type="string")
     */
    private $method;
    
    /**
     * Codigo de respuesta
     * @var int 
     * @ORM\Column(type="integer")
     */
    private $statusCode;
    
    /**
     * Respuesta
     * @var string 
     * @ORM\Column(type="text")
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
