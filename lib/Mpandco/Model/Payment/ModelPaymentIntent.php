<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Model\Payment;

use JeacCorp\Mpandco\Model\Base\ModelBase;

/**
 * Modelo: Intencion de pago por API
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ModelPaymentIntent extends ModelBase
{
    /**
     * Intento de pago: Venta (se usa cuando un cliente emite un pago a otro por motivo de venta (carrito de compra))
     */
    const INTENT_SALE = "sale";
    /**
     * Intento de pago: Solicitud de pago (se le envia la solicitud a un cliente y lo puede pagar mediante la app, web o ingresando el pin en la caja (si esta autorizado))
     */
    const INTENT_REQUEST = "request";
    
    /**
     * Intento de pago: Autorizacion (se usa para que un cliente externo autorice un pago automatico cada cierto tiempo)
     */
    const INTENT_AUTHORIZE = "authorize";
    
    /**
     * Intento de pago: Orden (Orden de pago que se envia por correo electronico para que la pagen con un boton de pago)
     */
    const INTENT_ORDER = "order";
    
    /**
     * Estatus: Creado
     */
    const STATE_CREATED = "created";
    /**
     * Estatus: Ejecutado (se abono al emisor y se desconto al que autorizo el pago)
     */
    const STATE_EXECUTED = "executed";
    /**
     * Estatus: Autorizado (El cliente autorizo el debito)
     */
    const STATE_AUTHORIZED = "authorized";
    /**
     * Estatus: Cancelado
     */
    const STATE_CANCELED = "canceled";
    
    /**
     * Estatus: Anulado (se reversa el pago)
     */
    const STATE_ANNULLED = "annulled";
    
    /**
     * Resumen de la intencion
     * @return string
     */
    public function getSummaryDescription() {
        $descriptions = [];
        foreach ($this->getTransactions() as $transaction) {
            $descriptions[] = $transaction->getDescription();
        }
        $description = implode(",", $descriptions);
        return $description;
    }
}