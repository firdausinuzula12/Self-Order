<?php
session_start();
include('koneksi.php');

// Ambil role (admin / kasir)
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'kasir';

// Variabel awal
$data = [];
$cari = "";

// Ambil pencarian jika ada
if (isset($_POST['cari'])) {
    $cari = trim($_POST['cari']);
}

// Aksi tombol
if (isset($_POST['aksi'])) {
    $aksi = $_POST['aksi'];

    // Produk stok terbanyak
    if ($aksi === 'terbanyak') {
        $query = "
            SELECT 
                p.id AS id_produk,
                p.nama_produk,
                p.harga,
                p.stok,
                COALESCE(SUM(d.jumlah), 0) AS total_terjual
            FROM tb_produk p
            LEFT JOIN tb_detailpes d ON p.nama_produk = d.nama_produk
            WHERE p.nama_produk LIKE '%$cari%'
            GROUP BY p.id, p.nama_produk, p.harga, p.stok
            ORDER BY p.stok DESC
        ";

    // Produk stok tersedikit
    } elseif ($aksi === 'tersedikit') {
        $query = "
            SELECT 
                p.id AS id_produk,
                p.nama_produk,
                p.harga,
                p.stok,
                COALESCE(SUM(d.jumlah), 0) AS total_terjual
            FROM tb_produk p
            LEFT JOIN tb_detailpes d ON p.nama_produk = d.nama_produk
            WHERE p.nama_produk LIKE '%$cari%'
            GROUP BY p.id, p.nama_produk, p.harga, p.stok
            ORDER BY p.stok ASC
        ";

    // Transaksi (khusus admin)
    } elseif ($aksi === 'transaksi' && $role === 'admin') {
        $query = "
            SELECT 
                p.id_pesanan AS id_transaksi,
                d.nama_produk,
                d.jumlah,
                (d.harga * d.jumlah) AS total_harga,
                p.tanggal_pemesanan,
                p.status_pesanan
            FROM tb_pesanan p
            JOIN tb_detailpes d ON p.id_pesanan = d.id_pesanan
            WHERE d.nama_produk LIKE '%$cari%'
            ORDER BY p.tanggal_pemesanan DESC
        ";
    }

} else {
    // Default tampil semua produk
    $query = "
        SELECT 
            p.id AS id_produk,
            p.nama_produk, 
            p.harga, 
            p.stok, 
            COALESCE(SUM(d.jumlah), 0) AS total_terjual
        FROM tb_produk p
        LEFT JOIN tb_detailpes d ON p.nama_produk = d.nama_produk
        WHERE p.nama_produk LIKE '%$cari%'
        GROUP BY p.id, p.nama_produk, p.harga, p.stok
        ORDER BY p.nama_produk ASC
    ";
}

$data = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Produk dan Transaksi</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Inter', sans-serif;
    background-color: #f8f8f8;
    color: #333;
    margin: 0;
    padding: 0;
}
header {
    top:0;
    width: 100%;
    position: fixed;
    background-color: #AC1754;
    color: white;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    z-index:1000;
}
header a img {
    width: 35px;
    height: 35px;
    cursor: pointer;
}

.container {
    max-width: 1000px;
    margin: 50px auto;
    text-align: center;
    padding: 0 20px;
}
h1 {
    margin-top:100px;
    color: #AC1754;
    margin-bottom: 20px;
}
.buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
button {
    background-color: #AC1754;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}
button:hover {
    background-color: #921347;
}

.search-box {
    margin: 20px auto;
    display: flex;
    justify-content: center;
    gap: 10px;
}
.search-box input {
    padding: 8px 12px;
    width: 250px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
.search-box button {
    background-color: #AC1754;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
}
.search-box button:hover {
    background-color: #921347;
}

.table-container {
    margin-top: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(172, 23, 84, 0.1);
    padding: 20px;
    overflow-x: auto;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #eee;
    text-align: center;
}
th {
    background-color: #AC1754;
    color: white;
}
tr:hover {
    background-color: #fef2f7;
}
</style>
</head>
<body>
<header> 
<a href="<?= ($role === 'admin') ? 'admin/index.php' : 'kasir/index.php' ?>">
    <img src="user/img/back-icon.png" alt="Kembali">
</a>
</header>

<div class="container">
    <h1>Laporan Produk dan Transaksi</h1>

    <!-- 🔍 Form Pencarian -->
    <form method="post" class="search-box">
        <input type="text" name="cari" placeholder="Cari nama produk..." value="<?= htmlspecialchars($cari) ?>">
        <button type="submit" name="aksi" value="<?= isset($_POST['aksi']) ? $_POST['aksi'] : '' ?>">Cari</button>
    </form>

    <!-- 🔘 Tombol Filter -->
    <form method="post" class="buttons">
        <button type="submit" name="aksi" value="terbanyak">Stok Terbanyak</button>
        <button type="submit" name="aksi" value="tersedikit">Stok Tersedikit</button>
        <?php if ($role === 'admin'): ?>
        <button type="submit" name="aksi" value="transaksi">Lihat Transaksi</button>
       <button type="button" onclick="window.location.href='admin/users_admin.php'">Data Users</button>
        <?php endif; ?>
    </form>

    <!-- 📋 Tabel Data -->
    <?php if ($data && $data->num_rows > 0): ?>
    <div class="table-container">
        <table>
            <thead>
                <?php if (!isset($_POST['aksi']) || $_POST['aksi'] !== 'transaksi'): ?>
                    <tr>
                        <th>No</th>
                        <th>ID Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga / pcs</th>
                        <th>Stok Tersedia</th>
                        <th>Jumlah Terjual</th>
                    </tr>
                <?php else: ?>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php $no = 1; while($row = $data->fetch_assoc()): ?>
                    <?php if (!isset($_POST['aksi']) || $_POST['aksi'] !== 'transaksi'): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['id_produk']) ?></td>
                            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['stok']) ?></td>
                            <td><?= htmlspecialchars($row['total_terjual']) ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['id_transaksi']) ?></td>
                            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                            <td><?= htmlspecialchars($row['jumlah']) ?> pcs</td>
                            <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_pemesanan'])) ?></td>
                            <td><?= htmlspecialchars($row['status_pesanan']) ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p><em>Tidak ada data ditemukan.</em></p>
    <?php endif; ?>
</div>

</body>
</html>
