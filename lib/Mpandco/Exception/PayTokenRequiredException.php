<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Exception;

use InvalidArgumentException;

/**
 * Error ocurre cuando hay multiples token de pago pero no se ha seleccionado ninguno
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PayTokenRequiredException extends InvalidArgumentException
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = NULL)
    {
        parent::__construct(sprintf("Debe establecer el 'PayToken' a usar en la transaccion. Hay %s disponibles.",$message), $code, $previous);
    }
}
