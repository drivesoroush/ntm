<?php

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
        return "UNKNOWN_DEVICE_" . str_random(5);
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
        return "SCANNER";
    }
}
