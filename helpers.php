<?php

if( ! function_exists('table_name')) {
    /**
     * Get boolean value of variable. These will return true: "1", "true"
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
