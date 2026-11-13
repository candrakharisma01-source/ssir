<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_prepare($conn, 
        "DELETE FROM produk WHERE ProdukID = ?"
    );

    mysqli_stmt_bind_param($query, "i", $id);

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Produk berhasil dihapus!');
            window.location='barang.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Produk gagal dihapus!');
            window.location='barang.php';
        </script>";
        exit;
    }
}
?>