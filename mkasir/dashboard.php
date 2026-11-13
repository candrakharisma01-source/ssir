
<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if (!in_array($_SESSION['role'], ['admin', 'administrator', 'petugas'])) {
    header("Location: pelanggan.php");
    exit;
}

$barang = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM produk"));

$stok = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT SUM(Stock) AS total FROM produk"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kasir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="sidebar">
    <h2>KASIR APP</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="barang.php">Data Barang</a>

    <?php if (in_array($_SESSION['role'], ['admin', 'administrator'])) { ?>
        <a href="register.php">Registrasi</a>
    <?php } ?>

    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <h2>Dashboard</h2>

    <p>Selamat datang,
    <?= htmlspecialchars($_SESSION['user']) ?></p>

    <div class="card">
        <h3>Total Barang</h3>
        <h2><?= $barang['total'] ?></h2>
    </div>

    <div class="card">
        <h3>Total Stok</h3>
        <h2><?= $stok['total'] ?? 0 ?></h2>
    </div>
</div>

</body>
</html>
