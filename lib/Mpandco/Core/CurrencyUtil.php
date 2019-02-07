<?php

namespace JeacCorp\Mpandco\Core;

use JeacCorp\Mpandco\Api\Master\Currency;

/**
 * Util de moneda
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class CurrencyUtil
{
    const SCALE_DECIMAL = 2;
    
    /**
     * Formatea un número usando como decimales el .
     * @param type $amount
     * @param type $decimals
     * @return type
     */
    public static function formatAmount($amount, $decimals = 2) {
        $numberFormated = number_format($amount, $decimals, ",", ".");
        return $numberFormated;
    }

    /**
     * Formatea un número usando como decimales la coma (,)
     * @param type $amount
     * @param type $decimals
     * @return type
     */
    public static function fotmatToNumber($amount, $decimals = 2) {
        $numberFormated = number_format($amount, $decimals, ".", "");
        return (double) $numberFormated;
    }

    /**
     * Formatea un numero usando como decimales el .
     * @param type $amount
     * @param type $decimals
     * @return type
     */
    public static function formatAmountInt($amount, $decimals = 2) {
        $numberFormated = number_format($amount, $decimals, "", "");
        return $numberFormated;
    }

    /**
     * Formatea un número y le agrega la moneda
     * @param Currency $currency
     * @param type $number
     * @param type $decimals
     * @return string
     */
    public static function money(Currency $currency, $number, $decimals = 2,$html = false) {
        if (is_string($number)) {
            $number = (float) $number;
        }
        if($html === true){
            $numberFormated = sprintf("<span>%s</span> <span class='currency-code'>%s</span>",self::formatAmount($number, $decimals),$currency->getAbbreviation());
        }else{
            $numberFormated = self::formatAmount($number, $decimals) . " " . $currency->getAbbreviation();
        }
        return $numberFormated;
    }

    /**
     * Suma dos numeros decimales
     * @param type $a
     * @param type $b
     * @return type
     */
    public static function sum($a, $b) {
        return bcadd($a, $b, self::SCALE_DECIMAL);
    }

    /**
     * Resta dos numeros decimales
     * @param type $a
     * @param type $b
     * @return type
     */
    public static function sub($a, $b) {
        return bcsub($a, $b, self::SCALE_DECIMAL);
    }

    /**
     * Divide dos numeros
     */
    public static function div($a, $b) {
        return bcdiv($a, $b, self::SCALE_DECIMAL);
    }

    /**
     * Multiplica dos número
     * @param type $a
     * @param type $b
     * @return type
     */
    public static function mul($a, $b) {
        return bcmul($a, $b, self::SCALE_DECIMAL);
    }

    /**
     * Aplica porcentaje 
     * @param type $a
     * @param type $b
     * @return type
     */
    public static function percent($a, $b) {
        $result = bcmul($a, $b, self::SCALE_DECIMAL);
        return bcdiv($result, 100, self::SCALE_DECIMAL);
    }

    /**
     * Verifica si dos numeros son iguales
     * @param type $a
     * @param type $b
     * @return type
     */
    public static function isEquals($a, $b) {
        return bccomp($a, $b, self::SCALE_DECIMAL) === 0;
    }
}
