<?php

namespace Ntcm\Ntm\Observers;

use Ntcm\Ntm\Model\SshCredential;

class SshCredentialObserver {

    /**
     * Listen to the credential created event.
     *
     * @param SshCredential $credential
     *
     * @return void
     */
    public function created(SshCredential $credential)
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
     * @param SshCredential $credential
     *
     * @return void
     */
    public function updated(SshCredential $credential)
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