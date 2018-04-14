<?php

namespace Ntcm\Ncm\Model;

use Illuminate\Database\Eloquent\Model;
use Ntcm\Ncm\Relation\BackupRelation;
use Ntcm\Ncm\Scope\BackupScope;
use Ntcm\Ntm\Restorable;
use Carbon\Carbon;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Backup extends Model {

    use BackupScope, BackupRelation, Restorable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'configurations',
        'host_id',
        'created_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at'];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('backups');
    }

    /**
     * Disable updated at attribute for this model.
     *
     * @param string $date
     */
    public function setUpdatedAtAttribute($date)
    {
        // ...
    }

    /**
     * Determines content of restoration.
     *
     * @return mixed
     */
    protected function getRestoreContent()
    {
        return $this->configurations;
    }

    /**
     * Get file in which the backup content is stored.
     *
     * @return string
     */
    public function getBackupFileName()
    {
        $now = Carbon::now()->format('H-s-i');
        $ip = str_replace(".", "-", $this->getRestoreAddress());
        $fileName = "{$ip}-{$now}";

        return $fileName;
    }
}
