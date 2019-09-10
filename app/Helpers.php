<?php

use App\MiniBlogApplication;

if (!function_exists('app')) {
    /**
     * application instanceをgetする
     *
     * @return mixed|\App\MiniBlogApplication
     */
    function app()
    {
        return MiniBlogApplication::getInstance();
    }
}
