<?php

namespace Ntcm\Exceptions;

use Exception;

class UnprocessableTrapException extends Exception {

    /**
     * @var integer error code.
     */
    protected $code = 400;

    /**
     * Create instance of class
     *
     * @param string $message
     */
    public function __construct($message = "Scan run failed.")
    {
        parent::__construct($message, $this->code);
    }
}