<?php

namespace Ntm\Model;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Hostname {

    private $name;

    private $type;

    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }
}
