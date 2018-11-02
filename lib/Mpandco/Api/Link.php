<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api;

use JMS\Serializer\Annotation\Type;

/**
 * Enlace
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Link 
{
    /**
     * Enlace
     * @var string
     * @Type("string")
     */
    private $href;
    /**
     * Accion
     * @var string 
     * @Type("string")
     */
    private $rel;
    /**
     * Metodo
     * @var string 
     * @Type("string")
     */
    private $method;
    
    public function getHref() {
        return $this->href;
    }

    public function getRel() {
        return $this->rel;
    }

    public function getMethod() {
        return $this->method;
    }

    public function setHref($href) {
        $this->href = $href;
        return $this;
    }

    public function setRel($rel) {
        $this->rel = $rel;
        return $this;
    }

    public function setMethod($method) {
        $this->method = $method;
        return $this;
    }
}
