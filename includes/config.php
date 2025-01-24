<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'user_management');



function isLoggedIn(){
    return isset($_SESSION['user_id']);
}

function checkUserStatus(){
    if(isLoggedIn()){
        $db = new Database();
        $user = $db->query("SELECT status FROM users WHERE id = ? AND status = 'blocked'",
        [$_SESSION['user_id']])->fetch();

        if($user){
            session_destroy();
            header('Location: login.php?error=blocked');
            exit();
        }
    }
}


?>