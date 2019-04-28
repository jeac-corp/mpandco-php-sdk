<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Model\Base;

/**
 * Modelo con campos base
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ModelBase
{
    /**
     * @var integer
     *
     */
    protected $id;
    
    /**
     * @var \DateTime $created
     */
    protected $createdAt;

    /**
     * @var \DateTime $updated
     */
    protected $updatedAt;
    
    /**
     */
    protected $deletedAt;
    
    /**
     * @var string $createdFromIp
     */
    protected $createdFromIp;
    
    /**
     * @var string $updatedFromIp
     */
    protected $updatedFromIp;
    
    /**
     * @var string
     */
    private $_links;

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Set createdFromIp
     *
     * @param string $createdFromIp
     * @return Payment
     */
    public function setCreatedFromIp($createdFromIp) {
        $this->createdFromIp = $createdFromIp;

        return $this;
    }

    /**
     * Get createdFromIp
     *
     * @return string 
     */
    public function getCreatedFromIp() {
        return $this->createdFromIp;
    }

    /**
     * Set updatedFromIp
     *
     * @param string $updatedFromIp
     * @return Payment
     */
    public function setUpdatedFromIp($updatedFromIp) {
        $this->updatedFromIp = $updatedFromIp;

        return $this;
    }

    /**
     * Get updatedFromIp
     *
     * @return string 
     */
    public function getUpdatedFromIp() {
        return $this->updatedFromIp;
    }
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return BankAccount
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return BankAccount
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }
    
    public function getId() {
        return $this->id;
    }
    /**
     * @return \JeacCorp\Mpandco\Api\Link
     */
    public function getLink($name)
    {
        $link = new \JeacCorp\Mpandco\Api\Link();
        if(isset($this->_links[$name])){
            $link->setHref($this->_links[$name]["href"]);
            $link->setMethod($this->_links[$name]["method"]);
        }
        return $link;
    }
    
}
