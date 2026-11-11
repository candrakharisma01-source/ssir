
<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_GET['register'])) {
    header("Location: register.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Kasir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login">
    <h2>Aplikasi Kasir</h2>
    <form action="login.php" method="POST">
        <input type="text" name="username"
        placeholder="Username" required>
        <input type="password" name="password"
        placeholder="Password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <p>Belum punya akun?
    <a href="register.php">Daftar</a></p>
</div>

</body>
</html>
