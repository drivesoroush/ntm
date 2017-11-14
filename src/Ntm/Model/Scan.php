<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Artisan;
use Ntcm\Enums\HostStateEnum;
use Ntcm\Ntm\Scope\ScanScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Scan extends Model {

    use ScanScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'total_discovered',
        'start',
        'end',
        'state',
        // scan info...
        'ranges',
        'ports',
        'os',
        // scheduling...
        // 'scheduled',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('scans');
    }

    /**
     * Make scan-hop relationship.
     *
     * @return HasMany
     */
    public function hops()
    {
        return $this->hasMany(Hop::class);
    }

    /**
     * Make scan-host relationship.
     *
     * @return HasMany
     */
    public function hosts()
    {
        return $this->hasMany(Host::class);
    }

    /**
     * Make scan-host relationship.
     *
     * @return HasMany
     */
    public function upHosts()
    {
        return $this->hasMany(Host::class)->whereState(HostStateEnum::STATE_UP);
    }

    /**
     * Rerun the scan.
     *
     * @return integer
     */
    public function rescan()
    {
        // call scan artisan command...
        return Artisan::call('scan', [
            'ranges'  => $this->ranges,
            '--os'    => $this->ports,
            '--ports' => $this->os,
        ]);
    }

    // /**
    // * Get is scheduled attribute.
    // *
    // * @return boolean
    // */
    // public function getIsScheduledAttribute()
    // {
    // return ! is_null($this->scheduled);
    // }
}
