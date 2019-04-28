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

/**
 * Pruebas de las rutas de pagos
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RoutePaymentTest extends BaseTest
{
    /**
     * Prueba que se retorne el paginador
     */
    public function testPaginator()
    {
        $routePayment = $this->getRouteService()->getPayment();
        $transactionResult = $routePayment->getPaginator();
//        echo((string)$transactionResult);
        $paginator = $transactionResult->getValue();
//        if(false){
//            $paginator = new \JeacCorp\Mpandco\Model\Core\Paginator();
//        }
        $links = $paginator->getLinks();
        $this->assertNotNull($links->getFirst()->getHref());
        $this->assertNotNull($links->getLast()->getHref());
        $this->assertNotNull($links->getSelf()->getHref());
        
        $meta = $paginator->getMeta();
        $this->assertNotNull($meta->getCurrentPage());
        $this->assertNotNull($meta->getMaxPerPage());
        $this->assertNotNull($meta->getTotalPages());
        $this->assertNotNull($meta->getTotalResults());
    }
}
