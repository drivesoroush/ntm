<?php

namespace Ntcm\Snmp;

use Nelisys\Snmp as SnmpLibrary;
use Ntcm\Ntm\Model\Host;

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
     * @param Host  $host
     * @param array $oidList
     *
     * @return boolean
     */
    public function scan($host, $oidList = [])
    {
        if(empty($oidList)) {
            $oidList = config('snmp.default');
        }

        $credentials = $host->snmpCredentials;

        $snmp = new SnmpLibrary($host->address, $credentials->read);

        foreach($oidList as $oid) {
            $snmp->get($oid);
        }

        return true;
    }
}
