<?php

namespace JeacCorp\Mpandco\Common;

use Symfony\Component\DependencyInjection\ContainerInterface;
use JMS\Serializer\SerializerBuilder;

/**
 * Clase factory para construir servicios complejos de forma mas sencilla
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class FactoryService
{
    public static function createSerializer(ContainerInterface $container)
    {
        return SerializerBuilder::create()
                        ->addMetadataDir($container->getParameter("serializer.dir"), "JeacCorp\\Mpandco")
                        ->setCacheDir($container->getParameter("kernel.cache_dir") . "/serializer")
                        ->setDebug($container->getParameter("kernel.debug"))
                        ->build()
                ;
    }
}
