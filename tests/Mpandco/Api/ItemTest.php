<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Test\Mpandco\Api;

use JeacCorp\Test\Mpandco\BaseTest;
use JeacCorp\Mpandco\Api\Item;
use InvalidArgumentException;
use Exception;

/**
 * Description of ItemTest
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ItemTest extends BaseTest
{
    public function testQuantityTypeString() {
        $item = new Item();
        $item->setQuantity(5);
        $this->assertEquals(5, $item->getQuantity());
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The quantity must be of the integer type. Given string");
        $item->setQuantity("5");
    }
    public function testQuantityTypeDouble() {
        $item = new Item();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The quantity must be of the integer type. Given double");
        $item->setQuantity(5.5);
    }
    
    public function testPriceString() {
        $price = "54,32";
        $item = new Item();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf("price is not a valid numeric value",gettype($price)));
        $item->setPrice($price);
    }
    public function testPriceSuccess() {
        $item = new Item();
        $item->setPrice(4.2);
        $this->assertEquals(4.2,$item->getPrice());
        $item->setPrice(5);
        $this->assertEquals(5,$item->getPrice());
    }
    
}
