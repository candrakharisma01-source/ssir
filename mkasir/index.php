
<?php
session_start();

if (isset($_SESSION['user'])) {

    if ($_SESSION['role'] === 'administrator') {
        header("Location: dashboard.php");
    } elseif ($_SESSION['role'] === 'pelanggan') {
        header("Location: pelanggan.php");
    }

    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Aplikasi Kasir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login">

    <h2>Aplikasi Kasir</h2>

    <h3>Login Admin</h3>

    <form action="login.php" method="POST">

        <input type="text" name="username"
        placeholder="Username Admin" required>

        <input type="password" name="password"
        placeholder="Password Admin" required>

        <button type="submit" name="login">
            Login Admin
        </button>

    </form>

    <hr>

    <h3>Login Pelanggan</h3>

    <form action="login_pelanggan.php" method="POST">

        <input type="text" name="username"
        placeholder="Username Pelanggan" required>

        <input type="password" name="password"
        placeholder="Password Pelanggan" required>

        <button type="submit" name="login">
            Login Pelanggan
        </button>

    </form>

    <p>Belum punya akun?
    <a href="register.php">Daftar</a></p>

</div>

</body>
</html>