<?php

namespace Core;

class Session
{
    protected static $sessionStarted = false;
    protected static $sessionIdRegenerated = false;

    public function __construct()
    {
        if (!self::$sessionStarted) {
            session_start();

            self::$sessionStarted = true;
        }
    }

    /**
     * セッションに値をセットする
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set(string $name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    /**
     * セッションの値を得る
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get(string $name, $default = null)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return $default;
    }

    /**
     * セッションから値を削除する
     *
     * @param string $name
     * @return void
     */
    public function remove(string $name): void
    {
        unset($_SESSION[$name]);
    }

    /**
     * セッションの値をクリアする。
     *
     * @return void
     */
    public function clear(): void
    {
        $_SESSION = [];
    }

    /**
     * セッションIDの再発行
     *
     * @param boolean $destroy
     * @return void
     */
    public function regenerate(bool $destroy = true): void
    {
        if (!self::$sessionIdRegenerated) {
            session_regenerate_id(($destroy));

            self::$sessionIdRegenerated = true;
        }
    }

    /**
     * 認証の判定を追加する
     *
     * @param boolean $bool
     * @return void
     */
    public function setAuthenticated(bool $bool): void
    {
        $this->set('_authenticated', (bool)$bool);

        $this->regenerate();
    }

    /**
     * 認証を確認
     *
     * @return boolean
     */
    public function isAuthenticated(): bool
    {
        return $this->get('_authenticated', false);
    }
}
