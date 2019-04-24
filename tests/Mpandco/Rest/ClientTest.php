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
        $clientId = "asd";
        $client = new Client([
            "clientId" => "asd",
            "clientSecret" => "fff",
            "use_ini" => false,
        ]);
        $routeService = $client->getContainer()->get(\JeacCorp\Mpandco\Rest\RouteService::class);
        $this->assertInstanceOf(\JeacCorp\Mpandco\Rest\RouteService::class, $routeService);
        
        $this->assertEquals($clientId,$client->getConfig()->get("clientId"));
        
        $client = new Client([
            "clientId" => "asd",
            "clientSecret" => "fff",
        ]);
        $this->assertEquals("1_id_8217d6084e785f4448dd4c75aabe5d81",$client->getConfig()->get("clientId"));
        
        $client = new Client([
        ]);
        $this->assertEquals("1_id_8217d6084e785f4448dd4c75aabe5d81",$client->getConfig()->get("clientId"));
    }
}
