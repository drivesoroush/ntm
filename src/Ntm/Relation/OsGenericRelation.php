<?php

namespace Ntcm\Ntm\Relation;

use Ntcm\Ncm\Model\Backup;
use Ntcm\Ncm\Model\Command;
use Ntcm\Ncm\Model\Trap;
use Ntcm\Ntm\Model\Address;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ntcm\Ntm\Model\Group;
use Ntcm\Ntm\Model\Hop;
use Ntcm\Ntm\Model\Hostname;
use Ntcm\Ntm\Model\OsDetected;
use Ntcm\Ntm\Model\OsGeneric;
use Ntcm\Ntm\Model\Port;
use Ntcm\Ntm\Model\SshCredential;
use Ntcm\Snmp\Model\Mib;
use Ntcm\Snmp\Model\SnmpCredential;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait OsGenericRelation {

    /**
     * Get commands related to this os generic.
     *
     * @return mixed
     */
    public function commands()
    {
        return $this->belongsToMany(Command::class, 'commands_os_generic');
    }
}