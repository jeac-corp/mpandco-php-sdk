<?php

namespace JeacCorp\Mpandco\Rest;

use GuzzleHttp\Client;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JeacCorp\Mpandco\Common\UserAgent;
use JeacCorp\Mpandco\Core\AppConstants;

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
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            "timeout" => 30,
            "allow_redirects" => false,
        ]);
        $resolver->setDefined([
            "proxy"
        ]);
        $resolver->setRequired([
            "app_name","base_uri"
        ]);
        $this->options = $resolver->resolve($options);
        $this->options["headers"] = [
            'User-Agent' => UserAgent::getValue(AppConstants::SDK_NAME,AppConstants::SDK_VERSION),
            'Accept'     => 'application/json',
        ];
        
        $this->client = new Client($options);
    }

}
