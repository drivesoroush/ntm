<?php

namespace Ntm\Model;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Address {

    CONST TYPE_IPV4 = 'ipv4';
    CONST TYPE_MAC = 'mac';

    private $address;

    private $type;

    private $vendor;

    public function __construct($address, $type = self::TYPE_IPV4, $vendor = '')
    {
        $this->address = $address;
        $this->type = $type;
        $this->vendor = $vendor;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }
}
