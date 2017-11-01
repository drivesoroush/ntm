<?php

namespace Ntcm\Ntm;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait NtmParameters {

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
    protected $verbose = true;

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
     * Make parameters array for process.
     *
     * @return array
     */
    protected function getParameters()
    {
        $parameters = [];
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
            $parameters[] = '-sS';
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