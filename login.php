<?php
session_start();
 
// If already logged in, redirect to index
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
 
$error = "";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    // Static admin login
    if ($username === "admin" && $password === "admin") {
 
        $_SESSION['username'] = "ADMIN";
        header("Location: index.php");
        exit();
 
    } else {
        $error = "Invalid username or password!";
    }
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <h2>Login</h2>
        <p>Sign in to access your dashboard</p>

        <?php if ($error != ""): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary auth-btn">Login</button>
        </form>
    </div>
</div>

</body>
</html>