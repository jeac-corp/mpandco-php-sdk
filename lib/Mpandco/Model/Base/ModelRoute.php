<?php

namespace JeacCorp\Mpandco\Model\Base;

use JeacCorp\Mpandco\Rest\OAuth2Service;
use JeacCorp\Mpandco\Rest\RestService;
use JMS\Serializer\SerializerInterface;

/**
 * Modelo de ruta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ModelRoute
{
    /**
     * @var \JeacCorp\Mpandco\Rest\OAuth2Service
     */
    protected $oAuth2Service;
    
    /**
     * @var \JeacCorp\Mpandco\Rest\RestService
     */
    protected $restService;
    
    /**
     * @var \JMS\Serializer\SerializerInterface 
     */
    protected $serializer;

    public function __construct(OAuth2Service $oAuth2Service,RestService $restService,SerializerInterface $serializer)
    {
        $this->oAuth2Service = $oAuth2Service;
        $this->restService = $restService;
        $this->serializer = $serializer;
    }
}
