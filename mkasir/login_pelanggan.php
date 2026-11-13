
<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_prepare($conn,
        "SELECT * FROM user WHERE username = ? AND role = 'pelanggan'"
    );

    mysqli_stmt_bind_param($query, "s", $username);
    mysqli_stmt_execute($query);

    $result = mysqli_stmt_get_result($query);
    $data = mysqli_fetch_assoc($result);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['user'] = $data['username'];
        $_SESSION['UserID'] = $data['userid'];
        $_SESSION['role'] = $data['role'];

        header("Location: pelanggan.php");
        exit;
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Pelanggan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main">
    <h2>Login Pelanggan</h2>

    <form method="POST">
        <input type="text" name="username"
        placeholder="Username" required>

        <input type="password" name="password"
        placeholder="Password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <br>
    <a href="index.php">Kembali</a>
</div>

</body>
</html>
