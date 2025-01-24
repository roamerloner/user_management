<?php
require_once 'includes/config.php';
require_once 'includes/User.php';

if(!isLoggedIn()){
    header('Location: login.php');
    exit();
}

checkUserStatus();

$user = new User();
$users = $user->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href='#' >User Management</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" id="blockBtn" data-bs-toggle="tooltip" title="Block selected users"> 
                            <i class="bi bi-lock-fill"></i> Block
                        </button>
                        <button type="button" class="btn btn-success" id="unblockBtn" data-bs-toggle="tooltip" title="Unblock selected users">
                        <i class="bi bi-unlock-fill"></i> 
                        </button>

                        <button type="button" class="btn btn-danger" id="deleteBtn" data-bs-toggle="tooltip" title="Delete selected users">
                        <i class="bi bi-trash-fill"></i> 
                        </button>
                    </div>
                    <input type="text" class="form-control w-25" id="filterInput" placeholder="Filter users...">
                </div>



                <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input user-select" value="<?php echo $user['id']; ?>">
                                        </td>
                                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $user['status'] == 'active' ? 'success' : 'danger'?>">
                                                <?php echo ucfirst($user['status']);?>
                                            </span>
                                        </td>
                                        <td><?php echo $user['last_login'] ? date('Y-m-d H:i:s', strtotime($user['last_login'])) :
                                        "Never" ; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>