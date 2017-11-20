<?php

namespace Ntcm\Snmp\Observers;

use Ntcm\Snmp\Model\SnmpCredential;

class SnmpCredentialObserver {

    /**
     * Listen to the credential created event.
     *
     * @param SnmpCredential $credential
     *
     * @return void
     */
    public function created(SnmpCredential $credential)
    {
        $valid = $credential->checkIsValid();

        if($valid === $credential->is_valid) {
            return;
        }

        $credential->update([
            'is_valid' => $valid
        ]);
    }

    /**
     * Listen to the credential updated event.
     *
     * @param SnmpCredential $credential
     *
     * @return void
     */
    public function updated(SnmpCredential $credential)
    {
        $valid = $credential->checkIsValid();

        if($valid === $credential->is_valid) {
            return;
        }

        $credential->update([
            'is_valid' => $valid
        ]);
    }

}