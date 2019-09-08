<?php

namespace Core;

class DbManager
{
    /**
     * PDOクラスのためのインスタンスを保持
     *
     * @var array
     */
    protected $connections = [];

    /**
     * Repositoryクラスと接続名の対応を格納
     *
     * @var array
     */
    protected $repository_connection_map = [];

    /**
     *
     *
     * @var array
     */
    protected $repositories = [];

    /**
     * データベースに接続する関数
     *
     * @param string $name
     * @param array $params
     * @return void
     */
    public function connect(string $name, array $params): void
    {
        $params = array_merge([
            'dsn'      => null,
            'user'     => '',
            'password' => '',
            'options'  => [],
        ], $params);

        $con = new \PDO(
            $params['dsn'],
            $params['user'],
            $params['password'],
            $params['options'],
        );

        $con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);


        $this->connections[$name] = $con;
    }

    /**
     * コネクションを取得
     *
     * @string $name
     * @return PDO
     */
    public function getConnection(string $name = null): PDO
    {
        if (is_null($name)) {
            return current($this->connections);
        }

        return $this->connections[$name];
    }

    /**
     * $repository_connection_mapにセットする
     *
     * @param string $repository_name
     * @param string $name
     * @return void
     */
    public function setRepositoryConnectionMap(string $repository_name, string $name): void
    {
        $this->repository_connection_map[$repository_name] = $name;
    }

    /**
     * 指定されたリポジトリに対応するコネクションを取得
     *
     * @param string $repository_name
     * @return PDO
     */
    public function getConnectionForRepository(string $repository_name): PDO
    {
        if (isset($this->repository_connection_map[$repository_name])) {
            $name = $this->repository_connection_map[$repository_name];
            $con = $this->getConnection($name);
        } else {
            $con = $this->getConnection();
        }

        return $con;
    }

    /**
     * リポジトリを取得
     *
     * @param string $repository_name
     * @return DbRepository
     */
    public function get(string $repository_name): DbRepository
    {
        if (!isset($this->repositories[$repository_name])) {
            $repository_class = $repository_name . 'Repository';
            $con = $this->getConnectionForRepository($repository_name);

            $repository = new $repository_class($con);

            $this->repositories[$repository_name] = $repository;
        }

        return $this->repositories[$repository_name];
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        foreach ($this->repositories as $repository) {
            unset($repository);
        }

        foreach ($this->connections as $con) {
            unset($con);
        }
    }
}
