<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Test\Mpandco\Rest;

use JeacCorp\Test\Mpandco\BaseTest;
use JeacCorp\Mpandco\Rest\ApiContext;

/**
 * Prueba del cliente
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ApiContextTest extends BaseTest
{
    public function testInit()
    {
        $apiContextId = "asd";
        $apiContext = new ApiContext([
            "clientId" => "asd",
            "clientSecret" => "fff",
            "use_ini" => false,
        ]);
        $routeService = $apiContext->getContainer()->get(\JeacCorp\Mpandco\Rest\RouteService::class);
        $this->assertInstanceOf(\JeacCorp\Mpandco\Rest\RouteService::class, $routeService);
        
        $this->assertEquals($apiContextId,$apiContext->getConfig()->get("clientId"));
        
        $apiContext = new ApiContext([
            "clientId" => "asd",
            "clientSecret" => "fff",
        ]);
        $this->assertEquals("1_id_8217d6084e785f4448dd4c75aabe5d81",$apiContext->getConfig()->get("clientId"));
        
        $apiContext = new ApiContext([
        ]);
        $this->assertEquals("1_id_8217d6084e785f4448dd4c75aabe5d81",$apiContext->getConfig()->get("clientId"));
    }
}
