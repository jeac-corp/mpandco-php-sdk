<?php

namespace JeacCorp\Mpandco\Rest;

use JeacCorp\Mpandco\Exception\InvalidRouteException;
use JeacCorp\Mpandco\Model\Base\ModelRoute;
use JeacCorp\Mpandco\Rest\Routes\RoutePaymentIntent;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use JMS\Serializer\SerializerInterface;

/**
 * Manejador de rutas
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RouteService
{
    use ContainerAwareTrait;
    
    /**
     * @var OAuth2Service
     */
    protected $oAuth2Service;
    
    /**
     * @var RestService
     */
    protected $restService;
    
    /**
     * @var SerializerInterface 
     */
    protected $serializer;
    
    public function __construct(OAuth2Service $oAuth2Service, RestService $restService,SerializerInterface $serializer)
    {
        $this->oAuth2Service = $oAuth2Service;
        $this->restService = $restService;
        $this->serializer = $serializer;
    }
    
    /**
     * @return RoutePaymentIntent
     */
    public function getPaymentIntent()
    {
        return $this->getRoute(RoutePaymentIntent::class);
    }
    /**
     * @return Routes\RouteSandbox
     */
    public function getRouteSandbox()
    {
        return $this->getRoute(Routes\RouteSandbox::class);
    }

    /**
     * Retorna la ruta
     * @param type $className
     * @return \JeacCorp\Mpandco\Rest\className
     */
    public function getRoute($className)
    {
        $reflection = new ReflectionClass($className);
        if(!$reflection->isSubclassOf(ModelRoute::class)){
            throw new InvalidRouteException(sprintf("La ruta '%s' debe heredar de '%s'",$className,ModelRoute::class));
        }
        $route = new $className($this->oAuth2Service,$this->restService, $this->serializer);
        return $route;
    }
}
