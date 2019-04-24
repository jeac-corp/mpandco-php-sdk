<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Test\Mpandco;

use PHPUnit\Framework\TestCase;

/**
 * Base para tests
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class BaseTest extends TestCase
{
    /**
     * @return \JeacCorp\Mpandco\Rest\Client
     */
    protected function getClient()
    {
        $client = new \JeacCorp\Mpandco\Rest\Client([
        ]);
        return $client;
    }
    
    /**
     * @return \JeacCorp\Mpandco\Rest\RouteService
     */
    protected function getRouteService()
    {
        $client = $this->getClient();
        return $client->getContainer()->get(\JeacCorp\Mpandco\Rest\RouteService::class);
    }
}
