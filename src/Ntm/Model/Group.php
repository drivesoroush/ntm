<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ntcm\Ntm\Scope\GroupScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Group extends Model {

    use GroupScope;

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
        return table_name('groups');
    }

    /**
     * Create host group relationship.
     *
     * @return BelongsToMany
     */
    public function hosts()
    {
        $pivot = table_name('host_group');

        return $this->belongsToMany(Host::class, $pivot);
    }
}
