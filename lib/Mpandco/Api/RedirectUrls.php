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
use JeacCorp\Mpandco\Validation\UrlValidator;

/**
 * Url callback para notificar la confirmacion o cancelacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RedirectUrls 
{
    /**
     * Url de retorno cuando la operacion es confirmada
     * @var string
     * @Type("string")
     */
    private $returnUrl;
    /**
     * Url de retorno cuando la operacion es cancelada
     * @var string
     * @Type("string")
     */
    private $cancelUrl;
    
    public function getReturnUrl() {
        return $this->returnUrl;
    }

    public function getCancelUrl() {
        return $this->cancelUrl;
    }

    public function setReturnUrl($returnUrl) {
        UrlValidator::validate($returnUrl,"returnUrl");
        $this->returnUrl = $returnUrl;
        return $this;
    }

    public function setCancelUrl($cancelUrl) {
        UrlValidator::validate($cancelUrl,"cancelUrl");
        $this->cancelUrl = $cancelUrl;
        return $this;
    }

}
