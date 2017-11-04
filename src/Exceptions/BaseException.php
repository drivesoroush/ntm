<?php

namespace Ntcm\Exceptions;

use Exception;

class BaseException extends Exception {

    /**
     * @var integer error code.
     */
    protected $code = 400;

    /**
     * Create instance of class
     *
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($this->code, $message);
    }
}