<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Validation;

/**
 * Class NumericValidator
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class NumericValidator 
{
    /**
     * Helper method for validating an argument if it is numeric
     *
     * @param mixed     $argument
     * @param string|null $argumentName
     * @return bool
     */
    public static function validate($argument, $argumentName = null)
    {
        if (trim($argument) != null && !is_numeric($argument)) {
            throw new \InvalidArgumentException("$argumentName is not a valid numeric value");
        }
        return true;
    }
}
