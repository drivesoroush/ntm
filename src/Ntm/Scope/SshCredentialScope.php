<?php

namespace Ntcm\Ntm\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait SshCredentialScope {

    /**
     * Check whether this hop exists in the database or not.
     *
     * @param        $query
     * @param array  $attributes
     *
     * @return mixed
     */
    public function scopeFindOrCreate($query, $attributes)
    {
        $credential = $query->where('address', encode_ip($attributes['address']))
                            ->get()
                            ->filter(function ($record) use ($attributes) {
                                if($record->username == $attributes['username']) {
                                    return $record;
                                }
                            })
                            ->first();

        if( ! $credential) {
            $credential = $query->create($attributes);
        } else {
            $credential->update($attributes);
        }

        // if the credential found return it...
        return $credential;
    }
}