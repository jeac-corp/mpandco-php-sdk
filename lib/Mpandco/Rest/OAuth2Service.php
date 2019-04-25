<?php

namespace JeacCorp\Mpandco\Rest;

use Symfony\Component\OptionsResolver\OptionsResolver;
use JeacCorp\Mpandco\Auth\OAuthTokenCredential;
use JeacCorp\Mpandco\Core\ConfigManager;
use GuzzleHttp\Exception\ClientException;

/**
 * Servicio de comunicacion oauth2
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class OAuth2Service
{
    /**
     * @var RestService
     */
    private $restService;

    /**
     * Token
     * @var OAuthTokenCredential
     */
    private $oAuthTokenCredential;

    function __construct(RestService $restService)
    {
        $this->restService = $restService;
        $configManager = ConfigManager::getInstance();
        $this->oAuthTokenCredential = new OAuthTokenCredential($configManager->get("clientId"), $configManager->get("clientSecret"));
    }

    /**
     * @param type $method
     * @param type $uri
     * @param array $options
     * @return \GuzzleHttp\Psr7\Response
     */
    public function request($method, $uri, array $options = [])
    {
        $restService = $this->restService;
        $config = ConfigManager::getInstance()->getConfigHashmap();
        
        $excecute = function ($method, $uri, $options,$token) use ($restService){
            $options["headers"] = [
                "Authorization" => "Bearer ".$token,
            ];
            $response = $restService->request($method, $uri, $options);
            return $response;
        };
        
        $token = $this->oAuthTokenCredential->getAccessToken($config);
        $response = null;
        try {
            $response = $excecute($method, $uri, $options,$token);
        } catch (ClientException $ex) {
            $response = $ex->getResponse();
            if($response->getStatusCode() === 401){
                $token = $this->oAuthTokenCredential->updateAccessToken($config);
                $response = $excecute($method, $uri, $options,$token);
            }
        }
        return $response;
    }

}
