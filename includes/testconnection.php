<?php
try {
    $db = new Database();
    echo "Connected successfully";
} catch(Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>