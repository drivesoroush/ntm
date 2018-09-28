<?php

namespace Ntcm\Ntm;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait NtmParameters {

    /**
     * Script timeout for nmap.
     *
     * @var integer
     */
    protected $scriptTimeout;

    /**
     * Host timeout in seconds.
     *
     * @var integer
     */
    protected $hostTimeout;

    /**
     * @var boolean
     */
    protected $osDetection = true;

    /**
     * @var boolean
     */
    protected $serviceInfo = true;

    /**
     * @var boolean
     */
    protected $verbose = false;

    /**
     * @var boolean
     */
    protected $treatHostsAsOnline = true;

    /**
     * @var boolean
     */
    protected $portScan = true;

    /**
     * @var boolean
     */
    protected $reverseDns = true;

    /**
     * @var boolean
     */
    protected $traceroute = true;

    /**
     * @var integer
     */
    protected $userId;

    /**
     * @param bool $traceroute
     *
     * @return $this
     */
    public function setTraceroute($traceroute)
    {
        $this->traceroute = $traceroute;

        return $this;
    }

    /**
     * @param bool $reverseDns
     *
     * @return $this
     */
    public function setReverseDns($reverseDns)
    {
        $this->reverseDns = $reverseDns;

        return $this;
    }

    /**
     * @param bool $portScan
     *
     * @return $this
     */
    public function setPortScan($portScan)
    {
        $this->portScan = $portScan;

        return $this;
    }

    /**
     * @param bool $osDetection
     *
     * @return $this
     */
    public function setOsDetection($osDetection)
    {
        $this->osDetection = $osDetection;

        return $this;
    }

    /**
     * @param bool $serviceInfo
     *
     * @return $this
     */
    public function setServiceInfo($serviceInfo)
    {
        $this->serviceInfo = $serviceInfo;

        return $this;
    }

    /**
     * @param bool $verbose
     *
     * @return $this
     */
    public function setVerbose($verbose)
    {
        $this->verbose = $verbose;

        return $this;
    }

    /**
     * @param bool $treatHostsAsOnline
     *
     * @return $this
     */
    public function setTreatHostsAsOnline($treatHostsAsOnline)
    {
        $this->treatHostsAsOnline = $treatHostsAsOnline;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     *
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getScriptTimeout()
    {
        return $this->scriptTimeout;
    }

    /**
     * @param int $scriptTimeout
     */
    public function setScriptTimeout(int $scriptTimeout)
    {
        $this->scriptTimeout = $scriptTimeout;
    }

    /**
     * @return int
     */
    public function getHostTimeout()
    {
        return $this->hostTimeout;
    }

    /**
     * @param int $hostTimeout
     */
    public function setHostTimeout(int $hostTimeout)
    {
        $this->hostTimeout = $hostTimeout;
    }

    /**
     * Make parameters array for process.
     *
     * @return array
     */
    protected function getParameters()
    {
        $parameters = [];

        if($this->scriptTimeout) {
            $parameters[] = "--script-timeout {$this->scriptTimeout}";
        }

        if($this->hostTimeout) {
            $parameters[] = "--host-timeout {$this->hostTimeout}";
        }

        if($this->osDetection) {
            $parameters[] = '-O';
        }

        if($this->serviceInfo) {
            $parameters[] = '-sV';
        }

        if($this->verbose) {
            $parameters[] = '-v';
        }

        if($this->portScan) {
            $wellKnownPorts = config('ntm.scan.ports', '1-1000');

            $parameters[] = "-p {$wellKnownPorts}";
        } else if( ! empty($this->ports)) {
            $parameters[] = '-p ' . implode(',', $this->ports);
        }

        if($this->reverseDns) {
            $parameters[] = '-n';
        }

        if($this->treatHostsAsOnline) {
            $parameters[] = '-Pn';
        }

        if($this->traceroute) {
            $parameters[] = '--traceroute';
        }

        $parameters[] = '-oX';

        return $parameters;
    }
}