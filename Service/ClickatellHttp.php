<?php

namespace Archer\ClickatellBundle\Service;

class ClickatellHttp
{
    /**
     * @var string
     */
    private $_sessionId = false;

    /**
     * @var string
     */
    private $_baseurl = 'http://api.clickatell.com';

    /**
     * @var string
     */
    private $_err = null;

    /**
     * @var int
     */
    private $_concat = 1;

    /**
     * @var string
     */
    private $_pathAuth = '/http/auth';

    /**
     * @var string
     */
    private $_pathSendMsg = '/http/sendmsg';

    /**
     * @var string
     */
    private $_pathQueryMsg = '/http/querymsg';

    /**
     * @var string
     */
    private $_pathGetBalance = '/http/getbalance';

    /**
     * @var string
     */
    private $_pathDeleteMessage = '/http/delmsg';

    /**
     * @var string
     */
    private $_pathPing = '/http/ping';

    public function __construct($user, $password, $apiId)
    {
        $this->user = $user;
        $this->password = $password;
        $this->apiId = $apiId;
    }

    /**
     * Send Message.
     *
     * @param string $to
     * @param string $message
     * @param array  $params  Other params
     *
     * @return array or false
     */
    public function sendMessage($to, $message, $params = array())
    {
        if ('UTF-8' == mb_detect_encoding($message)) {
            $params['unicode'] = 1;
        }
        $params['concat'] = $this->getConcat($message);
        $params['text'] = $message;
        $params['to'] = $to;

        return $this->getResponse($this->_pathSendMsg, $params);
    }

    /**
     * Get Concat message or last concat message.
     *
     * @param string $message text message
     *
     * @return int
     */
    public function getConcat($message = '')
    {
        if ($message) {
            if ('UTF-8' == mb_detect_encoding($message)) {
                $msglen = mb_strlen($message);
                $maxlen = 70;
            } else {
                $msglen = strlen($message);
                $maxlen = 160;
            }
            $this->_concat = (int) ceil($msglen / $maxlen);
        }

        return $this->_concat;
    }

    /**
     * returns the status of a message.
     *
     * @param type $apimsgid API Message ID
     *
     * @return
     * 001 - Message unknown
     * 002 - Message queued
     * 003 - Delivered to gateway
     * 004 - Received by recipient
     * 005 - Error with message
     * 006 - User cancelled message
     * 007 - Error delivering message
     * 008 - OK
     * 009 - Routing error
     * 010 - Message expired
     * 011 - Message queued for later delivery
     * 012 - Out of credit
     * 014 - Maximum MT limit exceeded.
     */
    public function queryMessage($apimsgid)
    {
        return $this->getResponse($this->_pathQueryMsg, array('apimsgid' => $apimsgid));
    }

    /**
     * Return the number of credits available on this particular account.
     *
     * @return type
     */
    public function getBalance()
    {
        return $this->getResponse($this->_pathGetBalance);
    }

    /**
     * This enables you to stop the delivery of a particular message.
     *
     * @param string $apimsgid
     *
     * @return type
     */
    public function deleteMsg($apimsgid)
    {
        return $this->getResponse($this->_pathDeleteMessage, array('apimsgid' => $apimsgid));
    }

    /**
     * Set session Id.
     *
     * @param type $sessionId
     *
     * @return \Archer\UserBundle\Service\ClickatellHttp
     */
    public function setSessionId($sessionId)
    {
        $this->_sessionId = $sessionId;

        return $this;
    }

    public function getSessionId($sessionId)
    {
        $this->_sessionId = $sessionId;

        return $this;
    }

    public function ping()
    {
        return $this->getResponse($this->_pathPing);
    }

    /**
     * get Error Message.
     *
     * @return string errors
     */
    public function getErrorMessage()
    {
        return $this->_err;
    }

    /**
     * @param string $path
     * @param array  $data other query
     *
     * @return array|bool|string
     */
    private function getResponse($path, $data = array())
    {
        if (!$this->_sessionId && !isset($data['api_id'])) {
            $data['user'] = $this->user;
            $data['password'] = $this->password;
            $data['api_id'] = $this->apiId;
            $this->_sessionId = $this->getResponse($this->_pathAuth, $data);
        } elseif (isset($data['api_id'])) {
            return $this->_sessionId;
        } else {
            $data['session_id'] = $this->_sessionId;
        }
        $ret = file($this->_baseurl.$path.'?'.http_build_query($data));
        $sess = explode(':', $ret[0]);
        if ($sess[0] == 'ERR') {
            $this->_err = trim($sess[1]);

            return false;
        } elseif (count($sess) == 2) {
            return trim($sess[1]);
        } else {
            //TODO Coverage Query
            if (preg_match_all("#(^|\s)([a-zA-Z]+): ([\w]+)#", $ret[0], $arr)) {
                foreach ($arr[2] as $key => $val) {
                    $ret[strtolower($val)] = $arr[3][$key];
                }
            }

            return $ret;
        }
    }
}
