<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace JeacCorp\Mpandco\Model\Core\Paginator;

use JeacCorp\Mpandco\Api\Link;

/**
 * Enlaces del paginador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Links
{
    /**
     * Primera pagina
     * @var Link 
     */
    private $first;
    
    /**
     * Pagina actual
     * @var Link 
     */
    private $self;
    
    /**
     * Pagina siguiente
     * @var Link 
     */
    private $next;
    
    /**
     * Ultima pagina
     * @var Link 
     */
    private $last;
    
    /**
     * @return Link
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * @return Link
     */
    public function getSelf()
    {
        return $this->self;
    }

    /**
     * @return Link
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @return Link
     */
    public function getLast()
    {
        return $this->last;
    }
}
