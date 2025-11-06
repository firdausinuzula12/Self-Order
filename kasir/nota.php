<?php
include "../koneksi.php";
require_once '../phpqrcode/qrlib.php'; // pastikan file ini ada!

$id_pesanan = $_GET['id'];

// Ambil data pesanan
$query = $koneksi->query("
    SELECT p.id_pesanan, p.nama_pelanggan, p.tanggal_pemesanan, p.total_harga, p.metode_pembayaran, p.status_pesanan
    FROM tb_pesanan p
    WHERE p.id_pesanan = '$id_pesanan'
");
$data_pesanan = $query->fetch_assoc();

// Cek apakah data ada
if (!$data_pesanan) {
    die("<h3 style='text-align:center;color:red;'>❌ Data pesanan tidak ditemukan.</h3>");
}

// Ambil detail pesanan
$detail_query = $koneksi->query("
    SELECT dp.id_detail, pr.nama_produk, dp.jumlah, dp.subtotal
    FROM tb_detailpes dp
    JOIN tb_produk pr ON dp.id = pr.id
    WHERE dp.id_pesanan = '$id_pesanan'
");

// -------- Generate QR Code otomatis --------
$qrDir = "../qrcodes/";
if (!file_exists($qrDir)) {
    mkdir($qrDir, 0777, true);
}

// Nama file QR unik berdasarkan id pesanan
$qrFile = $qrDir . "qr_" . $id_pesanan . ".png";

// Isi QR — bisa berupa teks atau link review
$qrText = "http://localhost/toko/user/review_pelanggan.php?id=" . $id_pesanan;

// Generate QR Code baru (overwrite jika sudah ada)
QRcode::png($qrText, $qrFile, QR_ECLEVEL_L, 4);

// Simpan path QR ke database dan ubah status jadi "Lunas"
$qrPathDB = "qrcodes/qr_" . $id_pesanan . ".png";
$koneksi->query("UPDATE tb_pesanan SET qr_path='$qrPathDB', status_pesanan='Lunas' WHERE id_pesanan='$id_pesanan'");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Transaksi <?= htmlspecialchars($data_pesanan['id_pesanan']); ?></title>
    <style>
        * {
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }
        .nota {
            width: 280px;
            margin: auto;
            padding: 5px;
            border: 1px dashed #000;
        }
        h2, h4, p {
            text-align: center;
            margin: 3px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            text-align: left;
        }
        .total {
            border-top: 1px dashed #000;
            margin-top: 6px;
            padding-top: 6px;
            font-weight: bold;
        }
        .qrcode {
            text-align: center;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 10px;
        }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body>
<div class="nota">
    <h2>The Cakery</h2>
    <p>Jl. Mawar No. 45, Surabaya</p>
    <hr>

    <p>
        <strong>ID Pesanan:</strong> <?= htmlspecialchars($data_pesanan['id_pesanan']); ?><br>
        <strong>Nama:</strong> <?= htmlspecialchars($data_pesanan['nama_pelanggan']); ?><br>
        <strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($data_pesanan['tanggal_pemesanan'])); ?><br>
        <strong>Status:</strong> <?= htmlspecialchars($data_pesanan['status_pesanan']); ?><br>
        <strong>Metode:</strong> <?= htmlspecialchars($data_pesanan['metode_pembayaran']); ?>
    </p>

    <table>
        <thead>
        <tr>
            <th>Produk</th>
            <th>Qty</th>
            <th style="text-align:right;">Subtotal</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($detail = $detail_query->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($detail['nama_produk']); ?></td>
                <td><?= htmlspecialchars($detail['jumlah']); ?></td>
                <td style="text-align:right;">Rp<?= number_format($detail['subtotal'], 0, ',', '.'); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <div class="total">
        <table>
            <tr>
                <td>Total</td>
                <td style="text-align:right;">Rp<?= number_format($data_pesanan['total_harga'], 0, ',', '.'); ?></td>
            </tr>
        </table>
    </div>

    <div class="qrcode">
        <img src="../<?= $qrPathDB ?>" alt="QR Code Transaksi" width="120"><br>
        <small>Scan untuk beri ulasan</small>
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja<br>
        Silakan scan QR di atas untuk review pesanan Anda</p>
    </div>

    <div class="btn-print">
        <center><button onclick="window.print()">🖨 Cetak Nota</button></center>
    </div>
</div>

<!-- Setelah print, kembali ke index.php dalam 5 detik -->
<script>
    window.onafterprint = function() {
        setTimeout(function() {
            window.location.href = "index.php";
        }, 5000);
    };
</script>
</body>
</html>
