<?php

namespace Ntm\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Service extends Model {

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('services');
    }

}
