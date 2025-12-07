<?php
include 'koneksi.php';
include 'navmenu.php';

$qProduk = mysqli_query($koneksi, "SELECT COUNT(*) AS total_produk FROM tb_produk");
$dataProduk = mysqli_fetch_assoc($qProduk)['total_produk'] ?? 0;

$qUser = mysqli_query($koneksi, "SELECT COUNT(*) AS total_user FROM tb_users");
$dataUser = mysqli_fetch_assoc($qUser)['total_user'] ?? 0;

$qTrans = mysqli_query($koneksi, "SELECT COUNT(*) AS total_transaksi FROM tb_pesanan");
$dataTrans = mysqli_fetch_assoc($qTrans)['total_transaksi'] ?? 0;

$qPemasukan = mysqli_query($koneksi, "SELECT SUM(total_harga) AS total_pemasukan FROM tb_pesanan");
$dataPemasukan = mysqli_fetch_assoc($qPemasukan)['total_pemasukan'] ?? 0;

$qJam = mysqli_query($koneksi, "
    SELECT HOUR(tanggal_pemesanan) AS jam, COUNT(*) AS jumlah
    FROM tb_pesanan
    GROUP BY HOUR(tanggal_pemesanan)
    ORDER BY jumlah DESC LIMIT 1
");
$dataJam = mysqli_fetch_assoc($qJam);
$jamSibuk = isset($dataJam['jam']) ? sprintf('%02d:00', $dataJam['jam']) : '-';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        body {
            background: #f9f4ef;
            padding-top: 80px;
            font-family: 'Inter', sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 30px;
            background: #fffafc;
            border-radius: 3px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }
        h1 {
            color: #4a2e19;
            text-align: center;
            margin-bottom: 35px;
            font-size: 28px;
            font-weight: 700;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .card {
            background: linear-gradient(135deg, #fff5f8, #ffeef2);
            border-radius: 3px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            text-align: center;
            transition: all 0.25s ease;
            border: 1px solid #f5c5d1;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }

        .icon {
            font-size: 38px;
            margin-bottom: 10px;
            color: #d63384;
        }

        .card h3 {
            color: #7a3c2b;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .card p {
            font-size: 26px;
            font-weight: bold;
            color: #b30059;
        }

        .pemasukan {
            grid-column: span 2;
            background: linear-gradient(135deg, #fff3e0, #ffe4c4);
            border: 1px solid #ffd7a0;
        }

        @media (max-width: 700px) {
            .pemasukan { grid-column: span 1; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Dashboard Admin</h1>
    <div class="cards">
        <div class="card">
            <div class="icon"></div>
            <h3>Jumlah Produk</h3>
            <p><?= $dataProduk; ?></p>
        </div>

        <div class="card">
            <div class="icon"></div>
             <a href="users_admin.php" style="text-decoration: none; color: inherit;">
            <h3>Total User</h3>
            <p><?= $dataUser; ?></p>
        </div>
        
        <div class="card">
            <div class="icon"></div>
            <h3>Jumlah Transaksi</h3>
            <p><?= $dataTrans; ?></p>
        </div>
      
        <div class="card">
            <div class="icon"></div>
            <a href="jam_sibuk.php" style="text-decoration: none; color: inherit;">
            <h3>Jam Sibuk</h3>
            <p><?= $jamSibuk; ?></p></a>
        </div>
      
        <div class="card pemasukan">
            <div class="icon"></div>
            <a href="pemasukan_hari.php" style="text-decoration: none; color: inherit;">
            <h3>Total Pemasukan</h3>
            <p>Rp<?= number_format($dataPemasukan, 0, ',', '.'); ?></p></a>
        </div>
      
    </div>
</div>
</body>
</html>