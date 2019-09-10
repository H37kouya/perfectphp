<?php

namespace App;

use Core\Application;

class MiniBlogApplication extends Application
{
    /**
     * Login Actionの追加
     *
     * @var array
     */
    protected $login_action = ['account', 'signin'];

    /**
     * ルートディレクトリへのパスを返すメソッド
     *
     * @return string
     */
    public function getRootDir(): string
    {
        return str_replace('\app' , '', __DIR__);
    }

    /**
     * ルーティング定義配列を返すメソッド
     *
     * @return array
     */
    protected function registerRoutes(): array
    {
        return [
            '/' => [
                'controller' => 'status',
                'action' => 'index',
            ],
            '/status/post' => [
                'controller' => 'status',
                'action' => 'post',
            ],
            '/user/:user_name' => [
                'controller' => 'status',
                'action' => 'user'
            ],
            '/user/:user_name/status/:id' => [
                'controller' => 'status',
                'action' => 'show'
            ],
            '/account' => [
                'controller' => 'account',
                'action' => 'index',
            ],
            '/account/:action' => [
                'controller' => 'account',
            ],
            '/follow' => [
                'controller' => 'account',
                'action' => 'follow',
            ],
        ];
    }

    /**
     * アプリケーションの設定を行うメソッド
     *
     * @return void
     */
    protected function configure(): void
    {
        $connection = $this->request->env('DB_CONNECTION');
        $name = $this->request->env('DB_DATABASE');
        $host = $this->request->env('DB_HOST');
        $username = $this->request->env('DB_USERNAME');
        $password = $this->request->env('DB_PASSWORD');

        $dsn = $connection . ':dbname=' . $name . ';host=' . $host;

        $this->db_manager->connect('master', [
            'dsn' => $dsn,
            'user' => $username,
            'password' => $password,
        ]);
    }
}
