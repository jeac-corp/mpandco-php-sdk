<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
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
     * @return \JeacCorp\Mpandco\Rest\ApiContext
     */
    protected function getApiContext()
    {
        $apiContext = new \JeacCorp\Mpandco\Rest\ApiContext([
        ]);
        return $apiContext;
    }
    
    /**
     * @return \JeacCorp\Mpandco\Rest\RouteService
     */
    protected function getRouteService()
    {
        $apiContext = $this->getApiContext();
        return $apiContext->getContainer()->get(\JeacCorp\Mpandco\Rest\RouteService::class);
    }
}
