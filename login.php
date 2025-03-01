<?php
require_once 'includes/config.php';
require_once 'includes/User.php';

if(isLoggedIn()){
    header('Location: dashboard.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user = new User();
    if($user->login($_POST['email'], $_POST['password'])){
        header('Location: dashboard.php');
        exit();
    } else{
        $error = "Invalid credentials or account is blocked";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center m-4">Login</h2>
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error;?></div>
                        <?php endif; ?> 
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>   
                        <p class="text-center mt-3">
                            Don't have an account? <a href="register.php">Register</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>



