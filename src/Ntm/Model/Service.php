<?php

namespace Ntm\Model;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Service {

    private $name;

    private $product;

    private $version;

    public function __construct($name, $product, $version)
    {
        $this->name = $name;
        $this->product = $product;
        $this->version = $version;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getVersion()
    {
        return $this->version;
    }
}
