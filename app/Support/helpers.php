<?php

if (!function_exists('load_file')) {
    /**
     * Load stub object.
     *
     * @param  string  $path
     * @return string
     */
    function load_file($path)
    {
        return file_get_contents(base_path($path));
    }
}