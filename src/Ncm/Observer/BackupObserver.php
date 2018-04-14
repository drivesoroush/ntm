<?php

namespace Ntcm\Ncm\Observers;

use Ntcm\Ncm\Model\Backup;

class BackupObserver {

    /**
     * Listen to the backup updated event.
     *
     * @param Backup $backup
     *
     * @return void
     */
    public function deleting(Backup $backup)
    {
        // ...
    }

}