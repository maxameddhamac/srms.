<?php
session_start();
include('connection.php');

if(isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // prepare waxan ku falaya amaanaky inoo sugaysa dhalinyaro
    $stmt = $con->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['admin_logged'] = true;
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        
        header("Location: index.php?page=dashboard");
        exit();
    } else {
        // Halkan ayaan ku eegaynaa waxa dhabta ah ee cilladda ah
        $error = "Username ama Passwordku waa khalad dib u hubi ! (Waxaa la raadinayay: User: $username)";
    }
        }
     else {
        $error = "";
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SRMS - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 400px; border: none; border-radius: 10px; }
    </style>
</head>
<body>
<div class="card login-card shadow p-4">
    <h3 class="text-center mb-4 text-primary fw-bold">SRMS Portal</h3>
    <?php if(isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label fw-bold">Username</label>
            <input type="text" name="username" class="form-control" required placeholder="Tusaale: admin" autocomplete="off">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="******">
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100 fw-bold">login</button>
    </form>
    <div class="text-center mt-3">
        <a href="view-result.php" class="text-decoration-none">student result</a>
    </div>
</div>
</body>
</html>