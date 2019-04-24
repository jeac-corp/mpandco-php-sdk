<?php

namespace JeacCorp\Mpandco\Rest;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Servicio de comunicacion oauth2
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class OAuth2Service
{
    const TOKEN_ENDPOINT = "oauth/v2/token";

    public function __construct()
    {
    }
}
