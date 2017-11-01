<?php

namespace Ntm;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait NtmParameters {

    protected $osDetection = true;

    protected $serviceInfo = true;

    protected $verbose = true;

    protected $treatHostsAsOnline = true;

    protected $portScan = true;

    protected $reverseDns = true;

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

}