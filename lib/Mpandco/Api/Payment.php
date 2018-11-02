<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Api;

use JMS\Serializer\Annotation\Type;
use JeacCorp\Mpandco\Core\AppConstants;
use JeacCorp\Mpandco\Common\ResourceModel;

/**
 * Pago
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Payment extends ResourceModel
{
    /**
     * Status: The transaction was successfully created.
     */
    const STATUS_CREATED  = "created";
    /**
     * Status: The buyer approved the transaction.
     */
    const STATUS_APPROVED  = "approved";
    /**
     * Status: The transaction request failed.
     */
    const STATUS_FAILED  = "failed";
    
    const STATUS_IN_PROGRESS  = "in_progress";
    
    /**
     * Id del pago
     * @var string
     * @Type("string")
     */
    protected $id;
    
    /**
     * Transacciones asociadas al pago
     * @var array 
     * @Type(array<"JeacCorp\Mpandco\Api\Transaction">)
     */
    protected $transactions;
    
    /**
     * The state of the payment, authorization, or order transaction. 
     * Valid Values: self::STATUS_*
     */
    protected $status;
    
    /**
     * Mensaje para la persona que paga
     * @var string
     */
    protected $noteToPayer;
    
    /**
     * Url las cuales va a responder el pago
     * @var RedirectUrls
     */
    protected $redirectUrls;
    
    /**
     * Failure reason code returned when the payment failed for some valid reasons.
     * Valid Values: ["UNABLE_TO_COMPLETE_TRANSACTION","PAYER_CANNOT_PAY","CANNOT_PAY_THIS_PAYEE"]
     */
    protected $failureReason;
    
    /**
     * Fecha de creacion
     * @var \DateTime
     * @example 2018-06-26 00:11:35 (Y-m-d H:i:s)
     */
    protected $createdAt;
    
    /**
     * Fecha de actualizacoin
     * @var \DateTime
     * @example 2018-06-26 00:11:35 (Y-m-d H:i:s)
     */
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getTransactions() {
        return $this->transactions;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function getNoteToPayer() {
        return $this->noteToPayer;
    }

    public function getRedirectUrls() {
        return $this->redirectUrls;
    }

    public function getFailureReason() {
        return $this->failureReason;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setNoteToPayer($noteToPayer) {
        $this->noteToPayer = $noteToPayer;
        return $this;
    }

    public function setRedirectUrls(RedirectUrls $redirectUrls) {
        $this->redirectUrls = $redirectUrls;
        return $this;
    }

    public function setFailureReason($failureReason) {
        $this->failureReason = $failureReason;
        return $this;
    }

    public function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Establece las transacciones
     * @param array $transactions
     * @return \JeacCorp\Mpandco\Api\Payment
     */
    public function setTransactions(array $transactions) {
        $this->transactions = $transactions;
        return $this;
    }
    
    /**
     * Agrega una transaccion
     * @param \JeacCorp\Mpandco\Api\Transaction $transaction
     */
    public function addTransaction(Transaction $transaction) {
        $this->transactions[] = $transaction;
        return $this;
    }
    
    /**
     * Elimina una transaccion de la lista
     * @param type $transaction
     * @return type
     */
    public function removeTransaction(Transaction $transaction)
    {
        return $this->setTransactions(
            array_diff($this->getTransactions(), array($transaction))
        );
    }
    
    /**
     * Get Approval Link
     *
     * @return null|string
     */
    public function getApprovalLink()
    {
        return $this->getLink(AppConstants::APPROVAL_URL);
    }
    
    
    
}
