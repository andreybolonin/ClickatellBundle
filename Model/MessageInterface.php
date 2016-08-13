<?php

namespace Archer\ClickatellBundle\Model;

/**
 * @author andrey
 */
interface MessageInterface
{
    /**
     * get Message Text.
     *
     * @return string
     */
    public function getText();

    /**
     * Set Message Text.
     *
     * @param string $text
     *
     * @return self
     */
    public function setText($text);

    /**
     * get Phone To.
     *
     * @return string
     */
    public function getToPhone();

    /**
     * Set Phone To.
     *
     * @param string $phoneNumber
     *
     * @return self
     */
    public function setToPhone($phoneNumber);

    /**
     * get Phone to.
     *
     * @return string Phone From
     */
    public function getFromPhone();

    /**
     * Set Phone From.
     *
     * @param string $phoneNumber
     *
     * @return self
     */
    public function setFromPhone($phoneNumber);

    /**
     * get Api Message Id.
     *
     * @return string
     */
    public function getApiMsgId();

    /**
     * Set Api Message Id.
     *
     * @param string $apiMsgId
     *
     * @return self
     */
    public function setApiMsgId($apiMsgId);

    /**
     * get Client Messge Id.
     *
     * @return string
     */
    public function getCliMsgId();

    /**
     * Set Client Message Id.
     *
     * @param string $cliMsgId
     *
     * @return self
     */
    public function setCliMsgId($cliMsgId);

    /**
     * Get Message Status.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set Message Status.
     *
     * @param string $status
     *
     * @return self
     */
    public function setStatus($status);

    /**
     * Get Incoming Message.
     *
     * @return int
     */
    public function getIncoming();

    /**
     * Set Message Incoming.
     *
     * @param int $incoming
     *
     * @return self
     */
    public function setIncoming($incoming);

    /**
     * Get Timestamp Message.
     *
     * @return int
     */
    public function getTimestamp();

    /**
     * Set Message Timestamp.
     *
     * @param int $timestamp
     *
     * @return self
     */
    public function setTimestamp($timestamp);

    /**
     * get Created At message.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * set Created At Message.
     *
     * @param \DateTime $date
     * 
     * @return self
     */
    public function setCreatedAt(\DateTime $date);
}
