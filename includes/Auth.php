<?php
require_once "Database.php";

class Auth{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function authenticate(){
        if(!isset($_SESSION['user_id'])){
            header('Location: login.php');
            exit();
        }

        $user = $this->db->query(
            "SELECT status FROM users WHERE id = ?",
            [$_SESSION['user_id']]
        )->fetch();

        if(!$user || $user['status'] === 'blocked'){
            session_destroy();
            header('Location: login.php?error=blocked');
            exit();
        }
        return true;
    }

    public function logout(){
        session_destroy();
        header('Location: login.php');
        exit();
    }
}




?>