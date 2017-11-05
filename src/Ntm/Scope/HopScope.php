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
                ->where(function ($query) use ($firstAddress, $secondAddress) {
                    $query->where('address_first', $firstAddress)
                          ->andWhere('address_second', $secondAddress);
                })->OrWhere(function ($query) use ($firstAddress, $secondAddress) {
                    $query->where('address_first', $secondAddress)
                          ->andWhere('address_second', $firstAddress);
                })->count() != 0;
    }

}