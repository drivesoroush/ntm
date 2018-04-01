<?php

namespace Ntcm\Snmp\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait SnmpCredentialScope {

    /**
     * Find snmp credential of create one.
     *
     * @param        $query
     * @param array  $attributes
     *
     * @return mixed
     */
    public function scopeFindOrCreate($query, $attributes)
    {
        //$credential = $query->where('address', encode_ip($attributes['address']))->first();
        $credential = $query->where('host_id', $attributes['host_id'])->first();

        // remove the previous snmp credentials...
        if($credential) {
            $credential->delete();
        }

        // persist the new one...
        $credential = $query->create($attributes);

        // if the credential found return it...
        return $credential;
    }
}