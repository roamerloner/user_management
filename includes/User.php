<?php

require_once "Database.php";

class User{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function register($name, $email, $password){
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $this->db->query(
                "INSERT INTO users (name, email, password) VALUES (?, ?, ?)",
                [$name, $email, $hashPassword]
            );
            return true;
        } catch (PDOException $e) {
            if($e->getCode() == 23000){
                return "Email already exists";
            }
            return false;
        }
    }

    public function login($email, $password){
        $user = $this->db->query(
            "SELECT * FROM users WHERE email = ? AND  status != 'blocked'",
            [$email]
        )->fetch();

        if($user && password_verify($password, $user['password'])){
            $this->db->query(
                "UPDATE users SET last_login =  NOW() WHERE id = ?",
                [$user['id']]
            );

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return true;
        }
        return false;
    }


     public function getAllUsers(){
        return $this->db->query(
            "SELECT id, name, email, status, last_login, created_at
            FROM users ORDER BY last_login DESC" 
        )->fetchAll();
     }


    public function updateStatus($ids, $status){
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        return $this->db->query(
            "UPDATE users SET status = ? WHERE id IN ($placeholders)",
            array_merge([$status], $ids)
        );
    }

    public function deleteUsers($ids){
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        return $this->db->query(
            "DELETE  from users WHERE id IN ($placeholders)",
            $ids
        );
    }





}



?>