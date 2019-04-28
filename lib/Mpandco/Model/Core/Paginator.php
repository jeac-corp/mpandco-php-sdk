<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Model\Core;

/**
 * Paginador de elementos
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Paginator
{
    /**
     * Enlaces del paginador
     * @var Paginator\Links 
     */
    private $links;
    
    /**
     * Informacion del paginador
     * @var Paginator\Meta 
     */
    private $meta;
    
    /**
     * Datos del paginador
     * @var array 
     */
    private $data;
    
    /**
     * @var \JMS\Serializer\SerializerInterface 
     */
    private $serializer;
    
    /**
     * Tipo de data
     * @var string
     */
    private $typeData;
    
    /**
     * Data normalizada
     * @var object
     */
    private $dataNormalize = null;

    public function getLinks()
    {
        return $this->links;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function getData()
    {
        if($this->dataNormalize === null){
            $this->dataNormalize = $this->serializer->deserialize(json_encode($this->data),sprintf("array<%s>",$this->typeData),"json");
        }
        return $this->dataNormalize;
    }

    public function init(\JMS\Serializer\SerializerInterface $serializer,$typeData)
    {
        $this->serializer = $serializer;
        $this->typeData = $typeData;
        return $this;
    }
}
