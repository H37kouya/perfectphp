<?php

namespace App\Models;

use DateTime;
use Core\DbRepository;

class UserRepository extends DbRepository
{
    /**
     * レコードの新規作成をする関数
     *
     * @param string $user_name
     * @param string $password
     * @return void
     */
    public function insert(string $user_name, string $password): void
    {
        $password = $this->hashPassword($password);
        $now = new DateTime();

        $sql = "INSERT INTO user(user_name, password, created_at) VALUES(:user_name, :password, :created_at)";

        $stmt = $this->execute($sql, [
            ':user_name' => $user_name,
            ':password' => $password,
            ':created_at' => $now->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * パスワードのハッシュ化をする関数
     *
     * @param string $password
     * @return string
     */
    public function hashPassword(string $password): string
    {
        return sha1($password . 'SecretKey');
    }

    /**
     * ユーザーIDを元にレコードを取得するメソッド
     *
     * @param string $user_name
     * @return array
     */
    public function fetchByUserName(string $user_name): array
    {
        $sql = "SELECT * FROM user WHERE user_name = :user_name";

        return $this->fetch($sql, [':user_name' => $user_name]);
    }

    /**
     * ユーザーIDに一致するレコードの件数を調べる
     * 0であれば、trueを返す
     *
     * @param string $user_name
     * @return boolean
     */
    public function isUniqueUserName(string $user_name): bool
    {
        $sql = "SELECT COUNT(id) as count FROM user WHERE user_name = :user_name";

        $row = $this->fetch($sql, [':user_name' => $user_name]);
        if ($row['count'] === '0') {
            return true;
        }

        return false;
    }

    /**
     * フォローしているユーザを取得するメソッド
     *
     * @param string $user_id
     * @return array
     */
    public function fetchAllFollowingsByUserId(string $user_id): array
    {
        $sql = "SELECT u.* FROM user u LEFT JOIN following f ON f.following_id = u.id WHERE f.user_id = :user_id";

        return $this->fetchAll($sql, [':user_id' => $user_id]);
    }
}
