<?php

namespace ANSR\Models;

class UserModel extends Model {

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    public function register($username, $email, $password, $role_id = self::ROLE_USER) {
        $username = $this->getDb()->escape($username);
        $email = $this->getDb()->escape($email);
        $password = md5($password);
        $role_id = intval($role_id);

        $this->getDb()->query("
            INSERT INTO users (username, email, password, role_id)
            VALUES ('$username', '$email', '$password', $role_id)
        ");

        return $this->getDb()->affectedRows() > 0;
    }

    public function login($username, $password) {
        $username = $this->getDb()->escape($username);
        $password = md5($password);

        $result = $this->getDb()->query("
            SELECT id, COUNT(*) AS cnt FROM users WHERE
            username = '$username' AND password = '$password'
        ");

        $row = $this->getDb()->row($result);

        if ($row['cnt'] > 0) {
            $_SESSION['user_id'] = $row['id'];
            return true;
        }

        return false;
    }

    public function isLogged() {
        return isset($_SESSION['user_id']);
    }

    public function getUserById($id) {
        $id = intval($id);
        $result = $this->getDb()->query("SELECT username, email, role_id FROM users WHERE id = $id");

        return $this->getDb()->row($result);
    }
}

