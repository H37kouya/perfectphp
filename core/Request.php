<?php

namespace Core;

class Request
{
    /**
     * HTTPメソッドがPOSTかどうか判定するメソッド。
     *
     * @return boolean
     */
    public function isPost(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }

        return false;
    }

    /**
     * $_GET変数から値を取得するメソッド
     *
     * @param string $name
     * @param mixed $default 指定したキーが存在しない場合のデフォルト値
     * @return mixed
     */
    public function getGet(string $name, $default = null)
    {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }

        return $default;
    }

    /**
     * $_POST変数から値を取得するメソッド
     *
     * @param string $name
     * @param mixed $default 指定したキーが存在しない場合のデフォルト値
     * @return mixed
     */
    public function getPost(string $name, $default = null)
    {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }

        return $default;
    }

    /**
     * サーバーのホスト名を取得するメソッド
     *
     * @return string
     */
    public function getHost(): string
    {
        if (!empty($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        }

        return $_SERVER['SERVER_NAME'];
    }

    /**
     * HTTPSでアクセスされたかどうか判定
     *
     * @return boolean
     */
    public function isSsl(): bool
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            return true;
        }

        return false;
    }

    /**
     * リクエストURIを取得
     *
     * @return string
     */
    public function getReqestUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * BaseUrlの特定をする関数
     *
     * @return string|null
     */
    public function getBaseUrl(): ?string
    {
        $script_name = $_SERVER['SCRIPT_NAME'];

        $request_uri = $this->getReqestUri();

        // 文字列内の部分文字列が最初に現れる場所を見つける
        if (strpos($request_uri, $script_name) === 0) {
            return $script_name;
        } elseif (strpos($request_uri, dirname($script_name))) {
            // 右側に続くスラッシュの削除
            return rtrim(dirname($script_name), '/');
        }

        return '';
    }

    /**
     * path_infoを返す関数
     *
     * @return string|null
     */
    public function getPathInfo(): ?string
    {
        $base_url = $this->getBaseUrl();
        $request_uri = $this->getReqestUri();

        // ? より前を抜きだす
        if (($pos = strpos($request_uri, '?')) !== false) {
            // 文字列の一部分を返す
            $request_uri = substr($request_uri, 0, $pos);
        }

        // ベースURL部分を除いた値をPATH_INFOとして取得する
        $path_info = (string) substr($request_uri, strlen($base_url));

        return $path_info;
    }
}
