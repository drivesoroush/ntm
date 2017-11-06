<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ntcm\Ntm\Scope\HopScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Hop extends Model {

    use HopScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'address_first',
        'address_second',
        'scan_id',
        'rtt',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'rtt' => 'float'
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
        return table_name('hops');
    }

    /**
     * Make hop-scan relationship.
     *
     * @return BelongsTo
     */
    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }

}
