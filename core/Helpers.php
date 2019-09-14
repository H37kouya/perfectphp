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
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        $protocol = app()->getRequest()->isSsl() ? 'https://' : 'http://';
        $host = app()->getRequest()->getHost();

        return $protocol . $host . app()->getRequest()->getBaseUrl() . $path;
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
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        return app()->getRootDir() . $path;
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
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        return app()->getAppDir() . $path;
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
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        return app()->getWebDir() . $path;
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
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        return app()->getResourcesDir() . $path;
    }
}
