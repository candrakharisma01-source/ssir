
<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['NamaProduk'];
    $harga = $_POST['Harga'];
    $stok = $_POST['Stock'];

    $query = mysqli_prepare($conn,
        "INSERT INTO produk (NamaProduk, Harga, Stock) VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param($query, "sii", $nama, $harga, $stok);

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Produk berhasil ditambahkan!');
            window.location='barang.php';
        </script>";
        exit;
    } else {
        echo "Gagal menambahkan produk: " . mysqli_stmt_error($query);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main">
    <h2>Tambah Produk</h2>

    <form method="POST">
        <input type="text" name="NamaProduk"
        placeholder="Nama Produk" required>

        <input type="number" name="Harga"
        placeholder="Harga Produk" required>

        <input type="number" name="Stock"
        placeholder="Stok Produk" required>

        <button type="submit" name="simpan">Simpan</button>
    </form>

    <br>
    <a href="barang.php">Kembali</a>
</div>

</body>
</html>
