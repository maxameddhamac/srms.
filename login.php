<?php
session_start();
include('connection.php');

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Shuruud fudud: Waxaad u beddeli kartaa username-ka iyo password-ka waxaad rabto sxb
    if($username == "admin" && $password == "admin123") {
        $_SESSION['admin_logged'] = true;
        header("Location: index.php?page=dashboard");
        exit();
    } else {
        $error = "Username ama Password khaldan sxb!";
    }
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
            <input type="text" name="username" class="form-control" required placeholder="Tusaale: admin">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="******">
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100 fw-bold">Soo Geli System-ka</button>
    </form>
    <div class="text-center mt-3">
        <a href="view-result.php" class="text-decoration-none">Ma tahay Arday? Fiiri Natiijadaada</a>
    </div>
</div>
</body>
</html>