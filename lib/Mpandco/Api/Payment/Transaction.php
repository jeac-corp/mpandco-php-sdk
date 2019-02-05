<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api\Payment;

use Doctrine\ORM\Mapping as ORM;
use Pandco\Bundle\AppBundle\Model\Base\ModelBase;

/**
 * Transacciones del pago
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="api_payment_intents_transactions")
 * @ORM\Entity()
 */
class Transaction extends ModelBase
{
    /**
     * Se coloco aqui para colocarle un grupo aparte de serializacion
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;
    
    /**
     * Intencion de pago asociado
     * @var PaymentIntent
     * @ORM\ManyToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\PaymentIntent",inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentIntent;
    
    /**
     * Monto de la operacion sin IVA
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction\Amount 
     * @ORM\OneToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\Transaction\Amount",cascade={"persist","remove"},mappedBy="transaction")
     */
    private $amount;
    
    /**
     * Elementos a cobrar
     * @var \JeacCorp\Mpandco\Api\Payment\Transaction\Item 
     * @ORM\OneToMany(targetEntity="JeacCorp\Mpandco\Api\Payment\Transaction\Item",mappedBy="transaction",cascade={"persist","remove"})
     */
    private $items;
    
    /**
     * Descripcion de la operacion
     * @var string
     * @ORM\Column(type="string",length=100) 
     */
    private $description;
    
    /**
     * Numero de factura asociada al pago
     * @var string
     * @ORM\Column(type="string",length=100,nullable=true) 
     */
    private $invoiceNumber;
    
    /**
     * Recursos generados por la transaccion
     * @var Transaction\RelatedResources 
     * @ORM\OneToOne(targetEntity="JeacCorp\Mpandco\Api\Payment\Transaction\RelatedResources",mappedBy="transaction",cascade={"persist","remove"})
     */
    private $relatedResources;
    
    /**
     * Tokens para realizar pagos
     * @var Transaction\PayToken 
     * @ORM\OneToMany(targetEntity="JeacCorp\Mpandco\Api\Payment\Transaction\PayToken",mappedBy="transaction",cascade={"persist","remove"})
     */
    private $payTokens;
    
    /**
     * Cuenta electronica a la cual se abonara el pago
     * @var \Pandco\Bundle\AppBundle\Entity\User\DigitalAccount
     * @ORM\ManyToOne(targetEntity="Pandco\Bundle\AppBundle\Entity\User\DigitalAccount")
     * @ORM\JoinColumn(nullable=false)
     */
    private $digitalAccountDestination;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->payTokens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Transaction
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set invoiceNumber
     *
     * @param string $invoiceNumber
     *
     * @return Transaction
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * Get invoiceNumber
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Add item
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction\Item $item
     *
     * @return Transaction
     */
    public function addItem(\JeacCorp\Mpandco\Api\Payment\Transaction\Item $item)
    {
        $item->setTransaction($this);
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction\Item $item
     */
    public function removeItem(\JeacCorp\Mpandco\Api\Payment\Transaction\Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set paymentIntent
     *
     * @param \JeacCorp\Mpandco\Api\Payment\PaymentIntent $paymentIntent
     *
     * @return Transaction
     */
    public function setPaymentIntent(\JeacCorp\Mpandco\Api\Payment\PaymentIntent $paymentIntent)
    {
        $this->paymentIntent = $paymentIntent;

        return $this;
    }

    /**
     * Get paymentIntent
     *
     * @return \JeacCorp\Mpandco\Api\Payment\PaymentIntent
     */
    public function getPaymentIntent()
    {
        return $this->paymentIntent;
    }
    
    public function getAmount() {
        return $this->amount;
    }

    public function setAmount(\JeacCorp\Mpandco\Api\Payment\Transaction\Amount $amount) {
        $amount->setTransaction($this);
        $this->amount = $amount;
        return $this;
    }
    
    public function getRelatedResources() {
        if(!$this->relatedResources){
            $this->setRelatedResources(new Transaction\RelatedResources());
        }
        return $this->relatedResources;
    }

    public function setRelatedResources(Transaction\RelatedResources $relatedResources) {
        $relatedResources->setTransaction($this);
        $this->relatedResources = $relatedResources;
        return $this;
    }

    /**
     * Add payToken
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction\PayToken $payToken
     *
     * @return Transaction
     */
    public function addPayToken(\JeacCorp\Mpandco\Api\Payment\Transaction\PayToken $payToken)
    {
        $payToken->setTransaction($this);
        $this->payTokens[] = $payToken;

        return $this;
    }

    /**
     * Remove payToken
     *
     * @param \JeacCorp\Mpandco\Api\Payment\Transaction\PayToken $payToken
     */
    public function removePayToken(\JeacCorp\Mpandco\Api\Payment\Transaction\PayToken $payToken)
    {
        $this->payTokens->removeElement($payToken);
    }

    /**
     * Get payTokens
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayTokens()
    {
        return $this->payTokens;
    }
    
    public function getDigitalAccountDestination()
    {
        return $this->digitalAccountDestination;
    }

    public function setDigitalAccountDestination(\Pandco\Bundle\AppBundle\Entity\User\DigitalAccount $digitalAccountDestination)
    {
        $this->digitalAccountDestination = $digitalAccountDestination;
        return $this;
    }
}
