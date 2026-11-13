
<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM user WHERE username = ? LIMIT 1"
    );

    if (!$stmt) {
        die("Query error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if ($data) {

        $storedPassword = $data['password'];

        $validPassword = password_verify(
            $password,
            $storedPassword
        );

        if (!$validPassword &&
            hash_equals($storedPassword, $password)) {

            $validPassword = true;

            $newHash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $update = mysqli_prepare($conn,
                "UPDATE user SET password = ? WHERE userid = ?"
            );

            mysqli_stmt_bind_param(
                $update, "si", $newHash, $data['userid']
            );

            mysqli_stmt_execute($update);
            mysqli_stmt_close($update);
        }

        if ($validPassword &&
            trim($data['role']) === 'pelanggan') {

            session_regenerate_id(true);

            $_SESSION['user'] = $data['username'];
            $_SESSION['role'] = 'pelanggan';

            header("Location: pelanggan.php");
            exit;
        }
    }

    echo "<script>
        alert('Username atau password salah!');
        window.location='login_pelanggan.php';
    </script>";
    exit;
}
?>
