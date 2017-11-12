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
        $credential->update([
            'isValid' => $credential->checkIsValid()
        ]);
    }

}