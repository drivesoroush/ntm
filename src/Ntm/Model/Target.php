<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Ntcm\Ntm\Scope\TargetScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Target extends Model {

    use TargetScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'ranges',
        'ports',
        'os',
        'scheduled',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ports' => 'boolean',
        'os'    => 'boolean',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('targets');
    }

    /**
     * Rerun the scan.
     *
     * @return integer
     */
    public function scan()
    {
        // call scan artisan command...
        return Artisan::call('scan', [
            'ranges'  => $this->ranges,
            '--os'    => $this->ports,
            '--ports' => $this->os,
        ]);
    }

    /**
     * Get is scheduled attribute.
     *
     * @return boolean
     */
    public function getIsScheduledAttribute()
    {
        return ! is_null($this->scheduled);
    }
}
