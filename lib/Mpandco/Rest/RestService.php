<?php

namespace JeacCorp\Mpandco\Rest;

use GuzzleHttp\Client;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JeacCorp\Mpandco\Common\UserAgent;
use JeacCorp\Mpandco\Core\AppConstants;
use JeacCorp\Mpandco\Core\ConfigManager;

/**
 * Servicio para hacer llamadas HTTPs
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RestService
{
    /**
     * @var Client
     */
    private $client;
    
    /**
     * Opciones
     * @var array
     */
    private $options;
    
  
    
    public function __construct(array $options = [])
    {
        $configManager = ConfigManager::getInstance();
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            "timeout" => $configManager->get("http.connection_time_out"),
            "allow_redirects" => false,
            "app_name" => AppConstants::SDK_NAME,
            "base_uri" => \JeacCorp\Mpandco\Auth\OAuthTokenCredential::getBaseUri($configManager->getConfigHashmap()),
        ]);
        $resolver->setDefined([
            "proxy"
        ]);
        $resolver->setRequired([
            "app_name",
        ]);
        $this->options = $resolver->resolve($options);
        $this->options["headers"] = [
            'User-Agent' => UserAgent::getValue(AppConstants::SDK_NAME,AppConstants::SDK_VERSION),
            'Accept'     => 'application/json',
        ];
        $this->client = new Client($this->options);
    }
    
    /**
     * Realiza una peticion
     * @param type $method
     * @param type $uri
     * @param array $options
     * @return \GuzzleHttp\Psr7\Response
     */
    public function request($method, $uri, array $options = []) {
//     var_dump($options);
        $response = $this->client->request($method, $uri, $options);
        
        return $response;
    }

}
