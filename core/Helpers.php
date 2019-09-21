<?php

if (!function_exists('asset')) {
    /**
     * urlを返す関数
     *
     * @param string $path
     * @return string
     */
    function asset(string $path): string
    {
        return app()->getRequest()->asset($path);
    }
}

if (!function_exists('base_path')) {
    /**
     * ルートディレクトリを返す関数
     *
     * @param string $path
     * @return string
     */
    function base_path(string $path): string
    {
        return path_combine(app()->getRootDir(), $path);
    }
}

if (!function_exists('app_path')) {
    /**
     * appディレクトリまでのパスを返す関数
     *
     * @param string $path
     * @return string
     */
    function app_path(string $path): string
    {
        return path_combine(app()->getAppDir(), $path);
    }
}

if (!function_exists('web_path')) {
    /**
     * webディレクトリまでのパスを返す関数
     *
     * @param string $path
     * @return string
     */
    function web_path(string $path): string
    {
        return path_combine(app()->getWebDir(), $path);
    }
}

if (!function_exists('resources_path')) {
    /**
     * resourcesディレクトリまでのパスを返す関数
     *
     * @param string $path
     * @return string
     */
    function resources_path(string $path): string
    {
        return path_combine(app()->getResourcesDir(), $path);
    }
}

if (!function_exists('path_combine')) {
    /**
     * 2つのpathをくっつける
     *
     * @param string $path1
     * @param string $path2
     * @return string
     */
    function path_combine(string $path_before, string $path_after): string
    {
        if (substr($path_after, 0, 1) !== '/') {
            $path_after = '/' . $path_after;
        }

        return $path_before . $path_after;
    }
}

if (!function_exists('mix')) {
    /**
     * mixのhash値を付加する
     *
     * @param string $path
     * @return string
     */
    function mix(string $path): string
    {
        return app()->getRequest()->mix($path);
    }
}
