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

/**
 * Lista de elementos a cobrar
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ItemList 
{
    /**
     * Lista de items
     * @var \JeacCorp\Mpandco\Api\Item 
     * @Type(array<JeacCorp\Mpandco\Api\Item>)
     */
    private $items;
    

    public function __construct() {
        $this->items = [];
    }
    
    public function addItem(Item $item) {
        $this->items[] = $item;
        return $this;
    }
    
    public function removeItem(Item $item) {
        $this->items = array_diff($this->items,[$item]);
    }
    
    function getItems() {
        return $this->items;
    }
}
