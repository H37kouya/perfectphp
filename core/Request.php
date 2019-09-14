<?php

namespace Core;

use Core\Dotenv;

class Request
{
    /**
     * Dotenvクラスを格納
     *
     * @var Dotenv
     */
    protected $dotenv;

    protected $webDir;

    public function __construct(string $webDir = __DIR__ . '/../web')
    {
        $this->initialize();
        $this->webDir = $webDir;
    }

    /**
     * クラスをロードするメソッド
     *
     * @return void
     */
    protected function initialize(): void
    {
        $this->dotenv = new Dotenv();
    }
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
     * http://localhost/foo/bar の foo/barの部分
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
        // index_dev.php | index.php の部分
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

    /**
     * 環境変数を取得するメソッド
     *
     * @param string $varname
     * @return string|array|bool
     */
    public function getenv(string $varname)
    {
        return $this->dotenv->env($varname);
    }

    /**
     * 環境変数を取得するメソッド
     *
     * @param string $varname
     * @return string|array|bool
     */
    public function env(string $varname)
    {
        return $this->dotenv->env($varname);
    }

    /**
     * protocolを返す関数
     *
     * @return string
     */
    public function getProtcol(): string
    {
        return $this->isSsl() ? 'https://' : 'http://';
    }

    /**
     * fullURLを返す関数
     *
     * @param string $path
     * @return string
     */
    public function asset(string $path): string
    {
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        $protocol = $this->getProtcol();
        $host = $this->getHost();

        return $protocol . $host . $this->getBaseUrl() . $path;
    }

    public function mix(string $path): string
    {
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        $mix_json = $this->webDir . '/mix-manifest.json';
        $json = mb_convert_encoding(file_get_contents($mix_json), 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $arr = json_decode($json, true);

        if ($arr === null) {
            return $this->asset($path);
        } else {
            return $this->asset($arr[$path]);
        }

        return $url;

    }
}
