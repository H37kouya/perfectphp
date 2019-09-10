<?php

namespace App\Models;

use DateTime;
use Core\DbRepository;

class StatusRepository extends DbRepository
{
    public function insert(string $user_id, string $body): void
    {
        $now = new DateTime();

        $sql = "INSERT INTO status(user_id, body, created_at) VALUES(:user_id, :body, :created_at)";

        $stmt = $this->execute($sql, [
            ':user_id' => $user_id,
            ':body' => $body,
            ':created_at' => $now->format('Y-m-d H:i:s'),
        ]);
    }

    public function fetchAllPersonalArchivesByUserId(?string $user_id): array
    {
        $sql = "SELECT a.*, u.user_name FROM status a
            LEFT JOIN user u ON a.user_id = u.id
            LEFT JOIN following f ON following_id = a.user_id AND f.user_id = :user_id
            WHERE f.user_id = :user_id OR u.id = :user_id
            ORDER BY a.created_at DESC";

        return $this->fetchAll($sql, [
            'user_id' => $user_id
        ]);
    }

    public function fetchAllByUserId($user_id): array
    {
        $sql = "
            SELECT a.*, u.user_name
                FROM status a
                    LEFT JOIN user u ON a.user_id = u.id
                WHERE u.id = :user_id
                ORDER BY a.created_at DESC
        ";

        return $this->fetchAll($sql, array(':user_id' => $user_id));
    }

    public function fetchByIdAndUserName($id, $user_name): array
    {
        $sql = "
            SELECT a.* , u.user_name
                FROM status a
                    LEFT JOIN user u ON u.id = a.user_id
                WHERE a.id = :id
                    AND u.user_name = :user_name
        ";

        return $this->fetch($sql, array(
            ':id'        => $id,
            ':user_name' => $user_name,
        ));
    }
}
