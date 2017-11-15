<?php

namespace Ntcm\Snmp;

use Nelisys\Snmp as SnmpLibrary;
use Ntcm\Snmp\Model\Mib;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Snmp {

    /**
     * @return Snmp
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Scan a host with snmp and store the returning values.
     *
     * @param string $address
     * @param string $readCommunity
     * @param array  $oidList
     *
     * @return bool
     */
    public function scan($address, $readCommunity, $oidList = [])
    {
        if(empty($oidList)) {
            $oidList = config('snmp.default');
        }

        // create a connector object...
        $snmp = new SnmpLibrary($address, $readCommunity);

        // loop on object ids...
        foreach($oidList as $oid) {
            $value = $snmp->get($oid);

            Mib::findOrCreate([
                'address' => $address,
                'oid'     => $oid,
                'value'   => $value,
            ]);
        }

        return true;
    }
}
