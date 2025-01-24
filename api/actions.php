<?php
require_once 'includes/config.php';
require_once 'includes/User.php';

if(!isLoggedIn()){
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

checkUserStatus();

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data['action']) || !isset($data['ids']) || !is_array($data['ids'])){
    die(json_encode(['success' => false, 'message' => 'Invalid Message']));
}

$user = new User();

try{
    switch($data['action']){
        case 'block':
            $user->updateStatus($data['ids'], 'blocked');
            break;
        case 'unblock':
            $user->updateStatus($data['ids'], 'active');
            break;
        case 'delete':
            $user->deleteUsers($data['ids']);       
            break;
         default:
         throw new Exception("Invalid action");   
    }

    echo json_encode(['success' => true]);

}catch(Exception $e){
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}


?>