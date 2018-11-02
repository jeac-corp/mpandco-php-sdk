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
 * Transaccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Transaction 
{
    /**
     * Monto
     * @var Amount
     * @Type("JeacCorp\Mpandco\Api\Amount")
     */
    private $amount;
    
    /**
     * Lista de items
     * @var ItemList
     * @Type("JeacCorp\Mpandco\Api\ItemList") 
     */
    private $itemList;
    
    /**
     * Descripcion del pago
     * @var string
     * @Type("string")
     */
    private $description;
    
    /**
     * Identificador unico de la factura
     * @var string 
     * @Type("string")
     */
    private $invoiceNumber;
    
    public function getAmount() {
        return $this->amount;
    }

    public function getItemList() {
        return $this->itemList;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getInvoiceNumber() {
        return $this->invoiceNumber;
    }

    public function setAmount(Amount $amount) {
        $this->amount = $amount;
        return $this;
    }

    public function setItemList(ItemList $itemList) {
        $this->itemList = $itemList;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setInvoiceNumber($invoiceNumber) {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

}
