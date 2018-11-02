<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Common;

use JMS\Serializer\Annotation\Type;

/**
 * Modelo de recurso Rest
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ResourceModel 
{
    /**
     *
     * @var array
     * @Type(array<"JeacCorp\Mpandco\Api\Link">)
     */
    protected $links;
    
    public function getLink($rel)
    {
        if (is_array($this->links)) {
            foreach ($this->links as $link) {
                if ($link->getRel() == $rel) {
                    return $link->getHref();
                }
            }
        }
        return null;
    }
    
    /**
     * Append Links to the list.
     *
     * @param \PayPal\Api\Links $links
     * @return $this
     */
    public function addLink($links)
    {
        if (!$this->getLinks()) {
            return $this->setLinks(array($links));
        } else {
            return $this->setLinks(
                array_merge($this->getLinks(), array($links))
            );
        }
    }

    /**
     * Remove Links from the list.
     *
     * @param \PayPal\Api\Links $links
     * @return $this
     */
    public function removeLink($links)
    {
        return $this->setLinks(
            array_diff($this->getLinks(), array($links))
        );
    }
    
    /**
     * @return \JeacCorp\Mpandco\Api\Link
     */
    public function getLinks() {
        return $this->links;
    }

    public function setLinks(array $links) {
        $this->links = $links;
        return $this;
    }
}
