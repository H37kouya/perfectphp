<?php

namespace App\Models;

use PDOStatement;
use Core\DbRepository;

class FollowingRepository extends DbRepository
{
    /**
     * レコードの新規作成
     *
     * @param mixed $user_id
     * @param mixed $following_id
     * @return PDOStatement
     */
    public function insert($user_id, $following_id): PDOStatement
    {
        $sql = "INSERT INTO following VALUES(:user_id, :following_id)";

        $stmt = $this->execute($sql, [
            ':user_id' => $user_id,
            ':following_id' => $following_id,
        ]);
    }

    /**
     * followしているかチェック
     *
     * @param mixed $user_id
     * @param mixed $following_id
     * @return boolean
     */
    public function isFollowing($user_id, $following_id): bool
    {
        $sql = "SELECT COUNT(user_id) as count FROM following WHERE user_id = :user_id AND following_id = :following_id";

        $row = $this->fetch($sql, [
            ':user_id' => $user_id,
            ':following_id' => $following_id,
        ]);

        if ($row['count'] !== '0') {
            return true;
        }

        return false;
    }
}
