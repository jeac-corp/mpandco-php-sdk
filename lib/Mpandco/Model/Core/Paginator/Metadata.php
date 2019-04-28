<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Model\Core\Paginator;

/**
 * Informacion del paginador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Metadata
{
    /**
     * Pagina actual
     * @var integer 
     */
    public $currentPage;
    
    /**
     * Maximo por pagina
     * @var integer 
     */
    public $maxPerPage;
    
    /**
     * Total de paginas
     * @var integer 
     */
    public $totalPages;
    
    /**
     * Total de resultados
     * @var integer 
     */
    public $totalResults;
    
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getMaxPerPage()
    {
        return $this->maxPerPage;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function getTotalResults()
    {
        return $this->totalResults;
    }
    
}
