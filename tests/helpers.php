<?php

if (!function_exists('load_stub')) {
    /**
     * Load stub object.
     *
     * @param  string  $path
     * @return string
     */
    function load_stub($path)
    {
        return file_get_contents(base_path('tests/stubs/' . $path . '.json'));
    }
}