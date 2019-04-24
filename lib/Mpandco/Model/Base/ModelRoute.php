<?php

namespace JeacCorp\Mpandco\Model\Base;

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
    
    public function __construct(\JeacCorp\Mpandco\Rest\OAuth2Service $oAuth2Service, \JeacCorp\Mpandco\Rest\RestService $restService)
    {
        $this->oAuth2Service = $oAuth2Service;
        $this->restService = $restService;
    }
}
