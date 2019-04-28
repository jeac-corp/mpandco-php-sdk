<?php

namespace JeacCorp\Mpandco\Model\Base;

use JeacCorp\Mpandco\Rest\OAuth2Service;
use JeacCorp\Mpandco\Rest\RestService;
use JMS\Serializer\SerializerInterface;
use JeacCorp\Mpandco\Model\Core\Paginator;

/**
 * Modelo de ruta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ModelRoute
{
    /**
     * @var \JeacCorp\Mpandco\Rest\OAuth2Service
     */
    protected $oAuth2Service;
    
    /**
     * @var \JeacCorp\Mpandco\Rest\RestService
     */
    protected $restService;
    
    /**
     * @var \JMS\Serializer\SerializerInterface 
     */
    protected $serializer;

    public function __construct(OAuth2Service $oAuth2Service,RestService $restService,SerializerInterface $serializer)
    {
        $this->oAuth2Service = $oAuth2Service;
        $this->restService = $restService;
        $this->serializer = $serializer;
    }
    
    protected function createPaginator($uri,$typeData,array $options = [])
    {
         $transactionResult = $this->oAuth2Service->request(Paginator::class,"GET",$uri,[
//            'query' => ['id' => $id]
        ]);
        if($transactionResult->isSuccess()){
            $paginator = $transactionResult->getValue();
            $paginator->init($this->serializer,$typeData);
        }
        return $transactionResult;
    }
}
