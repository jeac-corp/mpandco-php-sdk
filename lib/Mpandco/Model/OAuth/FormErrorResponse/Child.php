<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Model\OAuth\FormErrorResponse;

/**
 * Representa un error anidado
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Child
{
    /**
     * Errores
     * @var array
     */
    private $errors = [];
   /**
    *
    * @var \Doctrine\Common\Collections\ArrayCollection 
    */
    private $children;
    
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Retorna todos los errores
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Error anidado por indice
     * @param type $key
     * @return Child
     */
    public function getChildren($key)
    {
        return $this->children->get($key);
    }
    
    /**
     * ¿Contiene error la propiedad?
     * @return bool
     */
    public function hasErrors()
    {
        $result = (is_array($this->errors) && count($this->errors) > 0);
        if($result === false && $this->children !== null && $this->children->count() > 0){
            foreach ($this->children as $child) {
                $result = $child->hasErrors();
                if($result === true){
                    break;
                }
            }
        }
        return $result;
    }
    
    /**
     * Obtiene el primer error
     * @return string|null
     */
    public function getFirstError()
    {
        $error = null;
        if(count($this->errors) > 0){
            $error = reset($this->errors);
        }else if($this->children !== null && $this->children->count() > 0){
            foreach ($this->children as $child) {
                if($child->hasErrors()){
                    $error = $child->getFirstError();
                    break;
                }
            }
        }
        return $error;
    }
    
    /**
     * Optiene el primer error de una propiedad
     * @param type $property
     * @return string|null
     */
    public function getFirstErrorForProperty($property)
    {
        $error = null;
        if($this->children !== null && $this->children->count() > 0 && $this->children->containsKey($property)){
            $error = $this->children->get($property)->getFirstError();
        }
        return $error;
    }
}
