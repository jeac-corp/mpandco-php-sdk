<?php

namespace JeacCorp\Mpandco\Api\Master;

use JeacCorp\Mpandco\Model\Base\ModelBase;

/**
 * Moneda
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @see https://es.wikipedia.org/wiki/ISO_4217
 */
class Currency extends ModelBase
{
     /**
     * Nombre de la moneda
     * @var string
     */
    private $name;

    /**
     * Abreviacion de la moneda
     * @var string
     */
    private $abbreviation;
    
    /**
     * Numeracion
     * @var integer
     */
    private $num;
    
    /**
     * Cantidad de Decimales
     * @var integer
     */
    private $numDecimals;
    
    public function getName()
    {
        return $this->name;
    }

    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    public function getNum()
    {
        return $this->num;
    }

    public function getNumDecimals()
    {
        return $this->numDecimals;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
        return $this;
    }

    public function setNum($num)
    {
        $this->num = $num;
        return $this;
    }

    public function setNumDecimals($numDecimals)
    {
        $this->numDecimals = $numDecimals;
        return $this;
    }
}
