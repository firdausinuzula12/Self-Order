<?php
session_start();
include "../koneksi.php";

// Contoh (hapus ini kalau login sudah otomatis)
$_SESSION['role'] = 'admin'; // ubah ke 'kasir' untuk testing

$role = $_SESSION['role'] ?? '';

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : ''; // tombol filter

// ====== QUERY DASAR ======
$query = "
    SELECT 
        p.id,
        p.nama_produk,
        p.harga,
        p.stok,
        IFNULL(SUM(dp.jumlah), 0) AS jumlah_terjual
    FROM tb_produk p
    LEFT JOIN tb_detailpes dp ON p.id = dp.id
    LEFT JOIN tb_pesanan ps ON ps.id_pesanan = dp.id_pesanan AND ps.status_pesanan = 'Lunas'
    WHERE 1
";

// ====== FILTER PENCARIAN ======
if (!empty($cari)) {
    $query .= " AND p.nama_produk LIKE '%$cari%'";
}

$query .= " GROUP BY p.id ";

// ====== FILTER TAMBAHAN DARI BUTTON ======
switch ($filter) {
    case 'stok_terbanyak':
        $query .= " ORDER BY p.stok DESC";
        break;
    case 'stok_tersedikit':
        $query .= " ORDER BY p.stok ASC";
        break;
    case 'produk_terlaris':
        $query .= " ORDER BY jumlah_terjual DESC";
        break;
    default:
        $query .= " ORDER BY p.id ASC";
        break;
}

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk dan Transaksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Poppins", sans-serif;
        }
        .header {
            background-color: #a01646;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
        }
        .header img {
            width: 40px;
            height: 40px;
            cursor: pointer;
        }
        h2 {
            color: #a01646;
            font-weight: bold;
            text-align: center;
            margin-top: 25px;
        }
        .btn-custom {
            background-color: #a01646;
            color: white;
            border: none;
            margin: 5px;
            padding: 8px 18px;
            border-radius: 25px;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #7a1035;
        }
        .table-container {
            margin: 30px auto;
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 90%;
        }
        table {
            text-align: center;
        }
        thead {
            background-color: #a01646;
            color: white;
        }
        .search-box {
            text-align: center;
            margin-top: 20px;
        }
        .search-box input {
            width: 50%;
            padding: 8px;
            border-radius: 20px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }
        .search-box button {
            border-radius: 20px;
            background-color: #a01646;
            color: white;
            border: none;
            padding: 8px 16px;
        }
        .search-box button:hover {
            background-color: #7a1035;
        }
        .btn-container {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <a href="index.php">
        <img src="../user/img/back-icon.png" alt="Kembali">
    </a>
</div>

<!-- Judul -->
<h2>Laporan Produk dan Transaksi</h2>

<!-- Pencarian -->
<div class="search-box">
    <form method="GET" action="">
        <input type="text" name="cari" placeholder="Cari nama produk..." value="<?= htmlspecialchars($cari) ?>">
        <button type="submit">Cari</button>
    </form>
</div>

<!-- Tombol Filter (berdasarkan role) -->
<div class="btn-container">
    <?php if ($role == 'admin') { ?>
        <a href="?filter=stok_terbanyak" class="btn-custom">📦 Stok Terbanyak</a>
        <a href="?filter=stok_tersedikit" class="btn-custom">📉 Stok Tersedikit</a>
        <a href="?filter=produk_terlaris" class="btn-custom">🔥 Produk Terlaris</a>
        <a href="laporan_bulanan.php" class="btn-custom">📆 Laporan Bulanan</a>
        <a href="laporan_jamsibuk.php" class="btn-custom">🕒 Jam Sibuk</a>
        <a href="laporan_transaksi.php" class="btn-custom">🧾 Lihat Transaksi</a>
    <?php } elseif ($role == 'kasir') { ?>
        <a href="?filter=stok_terbanyak" class="btn-custom">📦 Stok Terbanyak</a>
        <a href="?filter=stok_tersedikit" class="btn-custom">📉 Stok Tersedikit</a>
        <a href="?filter=produk_terlaris" class="btn-custom">🔥 Produk Terlaris</a>
        <a href="laporan_jamsibuk.php" class="btn-custom">🕒 Jam Sibuk</a>
    <?php } ?>
</div>

<!-- Tabel Produk -->
<div class="table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Harga / pcs</th>
                <th>Stok Tersedia</th>
                <th>Jumlah Terjual</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['id']}</td>
                            <td>".htmlspecialchars($row['nama_produk'])."</td>
                            <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                            <td>{$row['stok']}</td>
                            <td>{$row['jumlah_terjual']}</td>
                          </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data produk</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
