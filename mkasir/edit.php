
<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_prepare($conn, "SELECT * FROM produk WHERE ProdukID = ?");
mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Produk tidak ditemukan!");
}

if (isset($_POST['update'])) {
    $nama = $_POST['NamaProduk'];
    $harga = $_POST['Harga'];
    $stok = $_POST['Stock'];

    $update = mysqli_prepare($conn,
        "UPDATE produk SET NamaProduk=?, Harga=?, Stock=? WHERE ProdukID=?"
    );

    mysqli_stmt_bind_param($update, "siii", $nama, $harga, $stok, $id);

    if (mysqli_stmt_execute($update)) {
        echo "<script>
            alert('Produk berhasil diubah!');
            window.location='barang.php';
        </script>";
        exit;
    } else {
        echo "Gagal mengubah produk: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main">
    <h2>Edit Produk</h2>

    <form method="POST">

        <input type="text" name="NamaProduk"
        value="<?= htmlspecialchars($data['NamaProduk']) ?>" required>

        <input type="number" name="Harga"
        value="<?= $data['Harga'] ?>" required>

        <input type="number" name="Stock"
        value="<?= $data['Stock'] ?>" required>

        <button type="submit" name="update">Update Produk</button>

    </form>

    <br>
    <a href="barang.php">Kembali</a>
</div>

</body>
</html>
