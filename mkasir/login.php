
<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM user WHERE username = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if ($data) {

        if (
            password_verify($password, $data['password']) ||
            $password === $data['password']
        ) {
            $_SESSION['user'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            header("Location: dashboard.php");
            exit;
        }
    }

    echo "<script>
        alert('Username atau password salah!');
        window.location='index.php';
    </script>";
}
?>
