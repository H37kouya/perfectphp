<?php

namespace Core;

use PDO;
use PDOStatement;

class DbRepository
{
    /**
     * PDOクラスの格納
     *
     * @var PDO
     */
    protected $con;

    public function __construct(PDO $con)
    {
        $this->setConnection($con);
    }

    /**
     * コネクションを設定
     *
     * @param PDO $con
     */
    public function setConnection(PDO $con): void
    {
        $this->con = $con;
    }

    /**
     * クエリを実行
     *
     * @param string $sql
     * @param array $params
     * @return PDOStatement $stmt
     */
    public function execute(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * クエリを実行し、結果を1行取得
     *
     * @param string $sql
     * @param array $params
     * @return array|false
     */
    public function fetch(string $sql, array $params = [])
    {
        return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * クエリを実行し、結果をすべて取得
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}
