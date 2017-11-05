<?php

namespace Ntcm\Ntm\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait HopScope {

    /**
     * Check whether this hop exists in the database or not.
     *
     * @param        $query
     *
     * @param string $firstAddress
     * @param string $secondAddress
     *
     * @return mixed
     */
    public function scopeExists($query, $firstAddress, $secondAddress)
    {
        return $query
                ->whereColumn(
                    ['address_first', $firstAddress],
                    ['address_second', $secondAddress]
                )->OrWhereColumn(
                    ['address_first', $secondAddress],
                    ['address_second', $firstAddress]
                )->count() == 0;
    }

}