<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ntcm\Ntm\Scope\HostScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class HostGroup extends Model {

    use HostScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name'
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
        return table_name('host_groups');
    }

    /**
     * Create host group relationship.
     *
     * @return HasMany
     */
    public function hosts()
    {
        return $this->hasMany(Host::class);
    }
}
