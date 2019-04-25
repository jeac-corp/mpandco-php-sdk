<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Model\Payment\OAuth\ErrorResponse;

/**
 * Respuesta de excepcion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ErrorException
{
//    [JsonProperty("code")]
    public $code;

//    [JsonProperty("message")]
    public $message;

//    [JsonProperty("exception")]
    public $exception;
    
    public function __construct()
    {
        $this->exception = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
