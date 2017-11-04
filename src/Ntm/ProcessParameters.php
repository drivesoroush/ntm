<?php

namespace Ntcm\Ntm;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait ProcessParameters {

    /**
     * Nmap executable command.
     *
     * @var string
     */
    protected $executable = "nmap";

    /**
     * Process execution timeout.
     *
     * @var integer
     */
    protected $timeout;

    /**
     * @param integer $timeout
     *
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @return integer
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @return string
     */
    public function getOutputFile()
    {
        return scans_path($this->getScanCode()) . ".xml";
    }

    /**
     * @return string
     */
    public function getExecutable()
    {
        return $this->executable;
    }

    /**
     * @param string $executable
     */
    public function setExecutable($executable)
    {
        $this->executable = $executable;
    }

}