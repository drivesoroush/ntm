<?php

namespace Ntcm\Ntm\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait SshCredentialScope {

    /**
     * Try to find the ssh credential otherwise create new one with input attributes.
     *
     * @param        $query
     * @param array  $attributes
     *
     * @return mixed
     */
    public function scopeFindOrCreate($query, $attributes)
    {
        //$credential = $query->where('address', encode_ip($attributes['address']))
        //                    ->get()
        //                    ->filter(function ($record) use ($attributes) {
        //                        if($record->username == $attributes['username']) {
        //                            return $record;
        //                        }
        //                    })
        //                    ->first();

        $credential = $query->where('host_id', $attributes['host_id'])
                            ->get()
                            ->filter(function ($record) use ($attributes) {
                                if($record->username == $attributes['username']) {
                                    return $record;
                                }
                            })
                            ->first();

        // if you find it then update it, otherwise create new one...
        if( ! $credential) {
            $credential = $query->create($attributes);
        } else {
            $credential->update($attributes);
        }

        // if the credential found return it...
        return $credential;
    }
}