<?php

namespace JeacCorp\Mpandco\Rest;

use Symfony\Component\OptionsResolver\OptionsResolver;
use JeacCorp\Mpandco\Auth\OAuthTokenCredential;
use JeacCorp\Mpandco\Core\ConfigManager;

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
        $token = $this->oAuthTokenCredential->getAccessToken(ConfigManager::getInstance()->getConfigHashmap());
//        var_dump($token);
        $options["headers"] = [
            "Authorization" => "Bearer ".$token,
        ];

        $response = $this->restService->request($method, $uri, $options);

        return $response;
    }

}
