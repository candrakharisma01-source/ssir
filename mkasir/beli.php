
<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['beli'])) {
    header("Location: pelanggan.php");
    exit;
}

$userID = (int) $_SESSION['UserID'];
$produkID = (int) $_POST['ProdukID'];
$jumlah = (int) $_POST['Jumlah'];

if ($jumlah < 1 || $produkID < 1) {
    die("Data pembelian tidak valid!");
}

mysqli_begin_transaction($conn);

try {

    $query = mysqli_prepare($conn,
        "SELECT Harga, Stock FROM produk
         WHERE ProdukID = ? FOR UPDATE"
    );

    mysqli_stmt_bind_param($query, "i", $produkID);
    mysqli_stmt_execute($query);

    $result = mysqli_stmt_get_result($query);
    $produk = mysqli_fetch_assoc($result);

    if (!$produk) {
        throw new Exception("Produk tidak ditemukan!");
    }

    if ($jumlah > $produk['Stock']) {
        throw new Exception("Stok tidak mencukupi!");
    }

    $total = $produk['Harga'] * $jumlah;

    $insert = mysqli_prepare($conn,
        "INSERT INTO transaksi (UserID, TotalHarga)
         VALUES (?, ?)"
    );

    mysqli_stmt_bind_param($insert, "ii", $userID, $total);
    mysqli_stmt_execute($insert);

    $transaksiID = mysqli_insert_id($conn);

   $detail = mysqli_prepare($conn,
    "INSERT INTO detail_penjualan
    (PenjualanID, ProdukID, JumlahProduk, Subtotal)
    VALUES (?, ?, ?, ?)"
);
    mysqli_stmt_bind_param(
        $detail, "iiii",
        $transaksiID, $produkID, $jumlah, $total
    );

    mysqli_stmt_execute($detail);

    $update = mysqli_prepare($conn,
        "UPDATE produk SET Stock = Stock - ?
         WHERE ProdukID = ? AND Stock >= ?"
    );

    mysqli_stmt_bind_param(
        $update, "iii", $jumlah, $produkID, $jumlah
    );

    mysqli_stmt_execute($update);

    if (mysqli_stmt_affected_rows($update) != 1) {
        throw new Exception("Stok gagal diperbarui!");
    }

    mysqli_commit($conn);

    echo "<script>
        alert('Pembelian berhasil dilakukan! Total: Rp " .
        number_format($total, 0, ',', '.') . "');
        window.location.href = 'pelanggan.php';
    </script>";
    exit;

} catch (Exception $e) {

    mysqli_rollback($conn);

    echo "<script>
        alert(" . json_encode($e->getMessage()) . ");
        window.location.href = 'pelanggan.php';
    </script>";
    exit;
}
?>
