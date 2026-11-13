<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="sidebar">
    <h2>KASIR APP</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="barang.php">Data Barang</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <h2>Data Produk</h2>

    <a href="tambah_barang.php">Tambah Produk</a>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; while($b = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?=$no++?></td>
            <td><?=htmlspecialchars($b['NamaProduk'])?></td>
            <td>Rp <?=number_format($b['Harga'],0,',','.')?></td>
            <td><?=$b['Stock']?></td>
            <td>
                <a href="edit.php?id=<?=$b['ProdukID']?>">Edit</a>
                <a href="hapus.php?id=<?=$b['ProdukID']?>"
                onclick="return confirm('Hapus produk?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>

    </table>
</div>

</body>
</html>