
<?php
session_start();
include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = mysqli_prepare($conn,
        "INSERT INTO user (username, password) VALUES (?, ?)"
    );

    mysqli_stmt_bind_param($query, "ss", $username, $password);

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Registrasi berhasil! Silakan login.');
            window.location='index.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Registrasi gagal! Username mungkin sudah digunakan.');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main">
    <h2>Registrasi Akun</h2>

    <form method="POST">
        <input type="text" name="username"
        placeholder="Username" required>

        <input type="password" name="password"
        placeholder="Password" required>

        <button type="submit" name="register">
            Daftar
        </button>
    </form>

    <br>
    <a href="index.php">Sudah punya akun? Login</a>
</div>

</body>
</html>
