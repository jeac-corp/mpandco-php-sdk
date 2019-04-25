<?php

namespace JeacCorp\Mpandco\Rest;

use Symfony\Component\OptionsResolver\OptionsResolver;
use JeacCorp\Mpandco\Auth\OAuthTokenCredential;
use JeacCorp\Mpandco\Core\ConfigManager;
use GuzzleHttp\Exception\ClientException;
use JMS\Serializer\SerializerInterface;
use JeacCorp\Mpandco\Model\OAuth\FormErrorResponse;
use JeacCorp\Mpandco\Model\OAuth\TransactionResult;

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
    
    /**
     * @var SerializerInterface 
     */
    private $serializer;

    function __construct(RestService $restService,SerializerInterface $serializer)
    {
        $this->restService = $restService;
        $configManager = ConfigManager::getInstance();
        $this->oAuthTokenCredential = new OAuthTokenCredential($configManager->get("clientId"), $configManager->get("clientSecret"));
        $this->serializer = $serializer;
    }

    /**
     * @param type $method
     * @param type $uri
     * @param array $options
     * @return TransactionResult
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
        $value = null;
        $errorResponse = null;
        try {
            $response = $excecute($method, $uri, $options,$token);
        } catch (ClientException $ex) {
            $response = $ex->getResponse();
            if($response->getStatusCode() ===  400){
                
                $data = json_decode((string)$response->getBody(),true);
                echo json_encode($data,JSON_PRETTY_PRINT);
                $errorResponse = $this->serializer->deserialize($data,FormErrorResponse::class,"json");
            }
        }
        $rransactionResult = new TransactionResult($value,$response,$errorResponse);
        return $rransactionResult;
    }

}
