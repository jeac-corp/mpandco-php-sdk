<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Rest;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use JMS\Serializer\SerializerBuilder;
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
class Client
{
    /**
     * Serializador
     * @var \JMS\Serializer\SerializerInterface 
     */
    private $serializer;
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
            "debug" => true,
            "cache_dir" => $rootDir . "/var/cache",
            "serializer_dir" => __DIR__ . "/../Resources/config/serializer",
            "clientId" => null,
            "clientSecret" => null,
        ]);
        $this->options = $resolver->resolve($options);
        $options = $this->options;

//        $this->serializer = SerializerBuilder::create()
//                ->addMetadataDir($this->options["serializer_dir"], "JeacCorp\\Mpandco")
//                ->setCacheDir($this->options["cache_dir"] . "/serializer")
//                ->setDebug($this->options["debug"])
//                ->build()
//        ;
        $containerBuilder = new ContainerBuilder();

        $file = $this->options["cache_dir"] . '/Container.php';
        $containerConfigCache = new ConfigCache($file, $this->options["debug"]);

        if ($this->options["debug"] || !$containerConfigCache->isFresh()) {
            $containerBuilder = new ContainerBuilder();
            $containerBuilder->setParameter("kernel.debug", $this->options["debug"]);
            $containerBuilder->setParameter("kernel.cache_dir", $this->options["cache_dir"]);
            $definition = new \Symfony\Component\DependencyInjection\Definition(\JMS\Serializer\SerializerInterface::class);
            $definition->setFactory(function() use ($options){
                return SerializerBuilder::create()
                        ->addMetadataDir($options["serializer_dir"], "JeacCorp\\Mpandco")
                        ->setCacheDir($options["cache_dir"] . "/serializer")
                        ->setDebug($options["debug"])
                        ->build()
                ;
            });
            $containerBuilder->setDefinition('serializer', $definition);
            $loader = new YamlFileLoader(
                $containerBuilder,
                new FileLocator(__DIR__.'/../Resources/config')
            );
            $loader->load('services.yaml');
            
            // ...
            $containerBuilder->compile();

            $dumper = new PhpDumper($containerBuilder);
            $containerConfigCache->write(
                    $dumper->dump(['class' => 'MyCachedContainer']),
                    $containerBuilder->getResources()
            );
        }

        require_once $file;
        $this->container = new \MyCachedContainer();
        
//        $paymentIntent = new \JeacCorp\Mpandco\Api\Payment\PaymentIntent();
//        $paymentIntent->setIntent("SALE");
//        $d = $this->serializer->serialize($paymentIntent,"json");
//        var_dump($d);
    }
    
    /**
     * @return \JMS\Serializer\SerializerInterface
     */
    public function getSerializer()
    {
        return $this->getContainer()->get("serializer");
    }
    
    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
    
    public function getConfig(): ConfigManager
    {
        return $this->configManager;
    }
}
