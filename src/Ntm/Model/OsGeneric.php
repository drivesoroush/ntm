<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Ntcm\Ntm\Scope\OsScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class OsGeneric extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'family',
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
        return table_name('os_generic');
    }

    /**
     * @return string
     */
    public function getAliasAttribute()
    {
        return strtolower(
            str_replace(" ", "_",
                str_replace("-", "_", $this->attributes['name'])
            )
        );
    }
}
