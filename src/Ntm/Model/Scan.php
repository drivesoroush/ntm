<?php

namespace Ntcm\Ntm\Model;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'user_id',

        // scan info...
        'ranges',
        'ports',
        'os',
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
     * @return BelongsToMany
     */
    public function hosts()
    {
        return $this->belongsToMany(Host::class, config('ntm.tables.scanned', 'mapper_scanned'));
    }

    /**
     * Make scan-host relationship.
     *
     * @return HasMany
     */
    public function upHosts()
    {
        return $this->belongsToMany(Host::class, config('ntm.tables.scanned', 'mapper_scanned'))
                    ->whereState(HostStateEnum::STATE_UP);
    }

    /**
     * Rerun the scan.
     *
     * @param integer | null $userId
     *
     * @return integer
     */
    public function rescan($userId = null)
    {
        // call scan artisan command...
        return Artisan::call('scan', [
            'ranges'  => $this->ranges,
            '--os'    => $this->ports,
            '--ports' => $this->os,
            '--user'  => $userId
        ]);
    }

    /**
     * Relate this scan to the host.
     *
     * @param integer $hostId
     */
    public function attachHost($hostId)
    {
        try {
            $this->hosts()->findOrFail($hostId);
        } catch(Exception $e) {
            $this->hosts()->attach($hostId);
        }
    }
}
