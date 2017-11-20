<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

if( ! function_exists('table_name')) {

    /**
     * Get table name.
     *
     * @param string $name
     *
     * @return string
     */
    function table_name($name)
    {
        return config("ntm.tables.{$name}", "mapper_{$name}");
    }
}

if( ! function_exists('scans_path')) {

    /**
     * Get directory path to newly scanned xml files.
     *
     * @param string $scan
     *
     * @return string
     */
    function scans_path($scan = "")
    {
        return storage_path("scans/{$scan}");
    }
}

if( ! function_exists('get_range')) {

    /**
     * Get ip range from ip address.
     *
     * @param string $ip
     *
     * @return string
     */
    function get_range($ip)
    {
        $values = explode('.', $ip);
        $resultArray = [$values[0], 0, 0, 0];
        $tail = "/8";

        if(intval($values[0]) >= 128) {
            $resultArray[1] = $values[1];
            $tail = "/16";
        }

        if(intval($values[0]) >= 192) {
            $resultArray[2] = $values[2];
            $tail = "/24";
        }

        return implode('.', $resultArray) . $tail;
    }
}

if( ! function_exists('get_scanner_address')) {

    /**
     * Get scanner ip address.
     *
     * @return string
     */
    function get_scanner_address()
    {
        try {
            return trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
        } catch(Exception $e) {
            return env("SCANNER_ADDRESS", Request::getClientIp());
        }
    }
}

if( ! function_exists('scape_shell_array')) {

    /**
     * Scape shell arguments for all indexes of an array.
     *
     * @param array $array
     *
     * @return array
     */
    function scape_shell_array($array)
    {
        return array_map(
            function($item) {
                return scape_shell($item);
            }, $array
        );
    }
}

if( ! function_exists('scape_shell')) {

    /**
     * Scape shell arguments for a string.
     *
     * @param string $item
     *
     * @return string
     */
    function scape_shell($item)
    {
        return escapeshellarg($item);
    }
}

if( ! function_exists('batch_auth')) {

    /**
     * Authenticate these credentials for remote connection.
     *
     * @param Collection $credentials
     *
     * @return void
     */
    function batch_auth($credentials)
    {
        $connections = [];

        foreach($credentials as $credential) {
            $connections[$credential->configKey] = [
                'host'     => $credential->address,
                'username' => $credential->username,
                'password' => $credential->password,
            ];
        }

        Config::set('remote.connections', $connections);
        Config::set('remote.default', $credentials->first()->configKey);
    }
}

if( ! function_exists('config_key')) {

    /**
     * Make config key out of this addrees.
     *
     * @param string $address
     *
     * @return string
     */
    function config_key($address)
    {
        return str_replace('.', '-', $address);
    }
}
