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
        return config("ntm.tables.{$name}", $name);
    }
}
