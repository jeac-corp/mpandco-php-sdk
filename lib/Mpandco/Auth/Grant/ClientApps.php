<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Auth\Grant;

use League\OAuth2\Client\Grant\AbstractGrant;

/**
 * Description of ClientApps
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ClientApps extends AbstractGrant
{
    /**
     * @inheritdoc
     */
    protected function getName()
    {
        return 'urn:client_apps';
    }

    /**
     * @inheritdoc
     */
    protected function getRequiredRequestParameters()
    {
        return [];
    }
}
