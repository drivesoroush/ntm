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
            function ($item) {
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
     * Make config key out of this address.
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

if( ! function_exists('encode_ip')) {

    /**
     * Encode the ip address into integer.
     *
     * @param string $address
     *
     * @return string
     */
    function encode_ip($address)
    {
        if( ! is_ip($address)) {
            return $address;
        }

        return ip2long($address);
    }
}

if( ! function_exists('decode_ip')) {

    /**
     * Decode the encoded ip address into string ip address.
     *
     * @param string $address
     *
     * @return string
     */
    function decode_ip($address)
    {
        return long2ip($address);
    }
}

if( ! function_exists('subnet_address')) {

    /**
     * Get subnet address.
     *
     * @param string $subnet
     *
     * @return string
     */
    function subnet_address($subnet)
    {
        if(is_ip($subnet)) {
            return encode_ip($subnet);
        }

        if( ! is_range($subnet)) {
            return $subnet;
        }

        list($ip, $range) = explode('/', $subnet);

        return $ip;
    }
}

if( ! function_exists('is_range')) {

    /**
     * Check if the input value is a valid range.
     *
     * @param string $range
     *
     * @return string
     */
    function is_range($range)
    {
        if( ! str_contains("/", $range)) {
            return false;
        }

        list($ip, $range) = explode('/', $range);

        return is_ip($ip) and is_numeric($range) and $range <= 32;
    }
}

if( ! function_exists('is_ip')) {

    /**
     * Check if the input value is a valid ip address.
     *
     * @param string $ip
     *
     * @return string
     */
    function is_ip($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
}
