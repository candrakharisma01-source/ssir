<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi User - Aplikasi Kasir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="card">
        <h2>Registrasi</h2>
        <?php if (!empty($pesan)) : ?>
            <div class="success"><?= $pesan; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input style="text-align: center; margin-top: 15px; type="text name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input style="text-align: center; margin-top: 15px; type="password name="password" required>
            </div>
            <div class="form-group">
                <label>Role :</label>
                <select style="text-align: center; margin-top: 15px; name="role>
                    <option value="petugas">Petugas</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button style="text-align: center; margin-top: 15px; type="submit name="register" class="btn-success">Simpan User</button>
        </form>
        
        <p style="text-align: center; margin-top: 15px;"><a href="index.php">Kembali</a></p>
    </div>

</body>
</html>