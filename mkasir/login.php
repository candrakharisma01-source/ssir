
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

    if ($data && password_verify($password, $data['password'])) {

        session_regenerate_id(true);

        $_SESSION['user'] = $data['username'];
        $_SESSION['role'] = strtolower(trim($data['role']));

        if (in_array($_SESSION['role'], ['admin', 'administrator', 'petugas'])) {
            header("Location: dashboard.php");
            exit;
        }

        if ($_SESSION['role'] === 'pelanggan') {
            header("Location: pelanggan.php");
            exit;
        }

        session_unset();
        session_destroy();

        echo "<script>
            alert('Role akun tidak dikenali!');
            window.location='index.php';
        </script>";
        exit;
    }

    echo "<script>
        alert('Username atau password salah!');
        window.location='index.php';
    </script>";
    exit;
}
?>
