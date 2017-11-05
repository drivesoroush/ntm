<?php

namespace Ntcm\Exceptions;

use Exception;

class ScanNotFoundException extends Exception {

    /**
     * @var integer error code.
     */
    protected $code = 404;

    /**
     * Create instance of class
     *
     * @param string $message
     */
    public function __construct($message = "No scan results found, you must scan a network first.")
    {
        parent::__construct($message, $this->code);
    }
}