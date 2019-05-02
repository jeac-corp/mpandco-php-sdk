<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Rest;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use JeacCorp\Mpandco\Core\ConfigManager;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Cliente que realizara todos los llamados
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ApiContext
{
    private $options = null;
    
    /**
     * @var ConfigManager 
     */
    private $configManager;


    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function __construct(array $configs = [],array $options = [])
    {
        $rootDir = dirname(__DIR__, 3);
        $this->configManager = ConfigManager::getInstance($configs);
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            "debug" => false,
            "cache_dir" => $rootDir . "/var/cache",
        ]);
        $this->options = $resolver->resolve($options);

        $containerBuilder = new ContainerBuilder();

        $file = $this->options["cache_dir"] . '/Container.php';
        $containerConfigCache = new ConfigCache($file, $this->options["debug"]);

        if ($this->options["debug"] || !$containerConfigCache->isFresh()) {
            $containerBuilder = new ContainerBuilder();
            $containerBuilder->setParameter("kernel.debug", $this->options["debug"]);
            $containerBuilder->setParameter("kernel.cache_dir", $this->options["cache_dir"]);
            $containerBuilder->setParameter("kernel.root_dir", $rootDir);
            
            $loader = new YamlFileLoader(
                $containerBuilder,
                new FileLocator(__DIR__.'/../Resources/config')
            );
            $loader->load('services.yaml');
            
            $containerBuilder->compile();

            $dumper = new PhpDumper($containerBuilder);
            $containerConfigCache->write(
                    $dumper->dump(['class' => 'MyCachedContainer']),
                    $containerBuilder->getResources()
            );
        }

        require_once $file;
        $this->container = new \MyCachedContainer();
        
    }
    
    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
    
    public function get($id)
    {
        return $this->container->get($id);
    }
    
    /**
     * @return \JMS\Serializer\SerializerInterface
     */
    public function getSerializer()
    {
        return $this->container->get(\JMS\Serializer\SerializerInterface::class);
    }
    
    /**
     * Serializa un objeto a un string en json
     * @param type $data
     * @return type
     */
    public function serialize(\JeacCorp\Mpandco\Model\Base\ModelBase $data)
    {
        $serialized = $this->getSerializer()->serialize($data, "json");
        return $serialized;
    }
    
    /**
     * Desserializa un string en formato json a un objeto
     * @param type $data
     * @return type
     */
    public function deserialize($data,$type)
    {
        $deserialized = $this->getSerializer()->deserialize($data,$type,"json");
        return $deserialized;
    }
    
    /**
     * @return ConfigManager
     */
    public function getConfig()
    {
        return $this->configManager;
    }
    
    /**
     * @return \JeacCorp\Mpandco\Rest\RouteService
     */
    public function getRouteService()
    {
        return $this->get(\JeacCorp\Mpandco\Rest\RouteService::class);
    }
}
