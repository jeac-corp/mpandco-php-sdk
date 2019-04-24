<?php

namespace JeacCorp\Mpandco\Rest;

use JeacCorp\Mpandco\Exception\InvalidRouteException;

/**
 * Manejador de rutas
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RouteService
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
    
    /**
     * @return Routes\RoutePaymentIntent
     */
    public function getPaymentIntent()
    {
        return $this->getRoute(Routes\RoutePaymentIntent::class);
    }

    /**
     * Retorna la ruta
     * @param type $className
     * @return \JeacCorp\Mpandco\Rest\className
     */
    public function getRoute($className)
    {
        $reflection = new \ReflectionClass($className);
        if(!$reflection->isSubclassOf(\JeacCorp\Mpandco\Model\Base\ModelRoute::class)){
            throw new InvalidRouteException(sprintf("La ruta '%s' debe heredar de '%s'",$className,\JeacCorp\Mpandco\Model\Base\ModelRoute::class));
        }
        $route = new $className($this->oAuth2Service,$this->restService);
        return $route;
    }
}
