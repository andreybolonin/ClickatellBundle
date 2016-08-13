<?php

namespace Archer\ClickatellBundle\Model;

/**
 * Description of Message.
 *
 * @author andrey
 */
abstract class Message implements MessageInterface
{
    /**
     * @var string
     */
    protected $apiMsgId;

    /**
     * @var string
     */
    protected $cliMsgId;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $fromPhone;

    /**
     * @var int
     */
    protected $incoming;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $toPhone;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->incoming = 0;
        $this->status = 0;
        $this->cliMsgId = hash('crc32', uniqid());
        $this->apiMsgId = md5(uniqid());
    }

    public function setApiMsgId($apiMsgId)
    {
        $this->apiMsgId = $apiMsgId;

        return $this;
    }

    public function getApiMsgId()
    {
        return $this->apiMsgId;
    }

    public function setCliMsgId($cliMsgId)
    {
        $this->cliMsgId = $cliMsgId;

        return $this;
    }

    public function getCliMsgId()
    {
        return $this->cliMsgId;
    }

    public function setCreatedAt(\DateTime $date)
    {
        $this->createdAt = $date;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setFromPhone($phoneNumber)
    {
        $this->fromPhone = $phoneNumber;

        return $this;
    }

    public function getFromPhone()
    {
        return $this->fromPhone;
    }

    public function setIncoming($incoming)
    {
        $this->incoming = $incoming;

        return $this;
    }

    public function getIncoming()
    {
        return $this->incoming;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setToPhone($phoneNumber)
    {
        $this->toPhone = $phoneNumber;

        return $this;
    }

    public function getToPhone()
    {
        return $this->toPhone;
    }
}
