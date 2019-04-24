<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Test\Mpandco\Rest;

use JeacCorp\Test\Mpandco\BaseTest;
use JeacCorp\Mpandco\Rest\Client;

/**
 * Prueba del cliente
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ClientTest extends BaseTest
{
    public function testInit()
    {
        $client = new Client();
    }
}