<?php

use Core\Application;

class MiniBlogApplication extends Application
{
    /**
     * Login Actionの追加
     *
     * @var array
     */
    protected $login_action = ['account', 'signup'];

    /**
     * ルートディレクトリへのパスを返すメソッド
     *
     * @return string
     */
    public function getRootDir(): string
    {
        return dirname(__FILE__);
    }

    /**
     * ルーティング定義配列を返すメソッド
     *
     * @return array
     */
    protected function registerRoutes(): array
    {
        return [

        ];
    }

    /**
     * アプリケーションの設定を行うメソッド
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->db_manager->connect('master', [
            'dsn' => 'mysql:dbname=mini_blog;host=localhost',
            'user' => 'root',
            'password' => ''
        ]);
    }
}