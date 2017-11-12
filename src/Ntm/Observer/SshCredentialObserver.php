<?php

namespace Ntcm\Ntm\Observers;

use Ntcm\Ntm\Model\SshCredential;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
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