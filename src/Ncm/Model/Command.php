<?php

namespace Ntcm\Ncm\Model;

use Illuminate\Database\Eloquent\Model;
use Ntcm\Ncm\Relation\CommandRelation;
use Ntcm\Ncm\Scope\CommandScope;
use Ntcm\Ntm\Restorable;
use Carbon\Carbon;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Command extends Model {

    use CommandScope, CommandRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'command',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('commands');
    }

}
