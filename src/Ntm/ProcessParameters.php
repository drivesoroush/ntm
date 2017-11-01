<?php

namespace Ntcm\Ntm;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait ProcessParameters {

    protected $executable = "nmap";

    protected $timeout = 60;

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
        return scans_path($this->getScanCode());
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