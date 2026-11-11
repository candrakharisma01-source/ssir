<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk"));
$stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(stock) AS total FROM produk"));
$transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM penjualan"));
$penjualan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(totalharga) AS total FROM penjualan"));
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
    <a href="transaksi.php">Transaksi</a>
    <a href="laporan.php">Laporan</a>

    <?php if ($_SESSION['role'] == 'administrator') { ?>
        <a href="register.php">Registrasi</a>
    <?php } ?>

    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <h2>Dashboard</h2>

    <p>Selamat datang, <?=htmlspecialchars($_SESSION['user'])?></p>

    <div class="card">
        <h3>Total Barang</h3>
        <h2><?=$barang['total']?></h2>
    </div>

    <div class="card">
        <h3>Total Stock</h3>
        <h2><?=$stok['total'] ?? 0?></h2>
    </div>

    <div class="card">
        <h3>Total Transaksi</h3>
        <h2><?=$transaksi['total']?></h2>
    </div>

    <div class="card">
        <h3>Total Penjualan</h3>
        <h2>Rp <?=number_format($penjualan['total'] ?? 0,0,',','.')?></h2>
    </div>
</div>

</body>
</html>
