
<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: index.php");
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM produk WHERE Stock > 0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Belanja Pelanggan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main">

    <h2>Daftar Produk</h2>

    <p>Selamat datang, <?= htmlspecialchars($_SESSION['user']) ?></p>

    <a href="logout.php">Logout</a>

    <hr>

    <?php while ($produk = mysqli_fetch_assoc($query)) { ?>

    <div class="produk">

        <h3><?= htmlspecialchars($produk['NamaProduk']) ?></h3>

        <p>Harga:
        Rp <?= number_format($produk['Harga'], 0, ',', '.') ?></p>

        <p>Stok: <?= $produk['Stock'] ?></p>

        <form action="beli.php" method="POST">

            <input type="hidden" name="ProdukID"
            value="<?= $produk['ProdukID'] ?>">

            <input type="number" name="Jumlah"
            placeholder="Jumlah beli"
            min="1"
            max="<?= $produk['Stock'] ?>"
            required>

            <button type="submit" name="beli">
                Beli Sekarang
            </button>

        </form>

    </div>

    <hr>

    <?php } ?>

    <?php if (mysqli_num_rows($query) == 0) { ?>
        <p>Belum ada produk tersedia.</p>
    <?php } ?>

</div>

</body>
</html>
