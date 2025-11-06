<?php
session_start();
include('koneksi.php');
include 'navbar.php';

// Ambil semua pesanan
$pesanan = $koneksi->query("
    SELECT 
        p.id_pesanan, 
        p.nama_pelanggan, 
        p.metode_pembayaran, 
        p.status_pesanan,
        p.tanggal_pemesanan, 
        p.total_harga,
        pb.jumlah_bayar,
        pb.kembalian,
        GROUP_CONCAT(CONCAT(d.nama_produk, '|', d.harga, '|', d.jumlah) SEPARATOR ';') AS detail_produk
    FROM tb_pesanan p
    LEFT JOIN tb_detailpes d ON p.id_pesanan = d.id_pesanan
    LEFT JOIN tb_pembayaran pb ON p.id_pesanan = pb.id_pesanan
    GROUP BY p.id_pesanan
    ORDER BY p.tanggal_pemesanan DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kasir - Riwayat Transaksi</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8f8f8;
        color: #333;
        padding: 25px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .header {
        color: #AC1754;
        font-size: 1.8rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
    }

    .cards-container {
        margin-top:50px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 20px;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(172, 23, 84, 0.1);
        overflow: hidden;
        transition: 0.3s;
        display: flex;
        flex-direction: column;
    }

    .card-header {
        background: #AC1754;
        color: #fff;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .status {
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #fff;
        text-transform: capitalize;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status.Pending { background: #fbbf24; }
    .status.Lunas { background: #16a34a; }
    .status.Dibatalkan { background: #9ca3af; }

    .status a {
        color: white;
        text-decoration: none;
        font-size: 1rem;
        transition: 0.2s;
    }

    .status a:hover {
        color: #ffeeba;
        transform: scale(1.1);
    }

    .btn-hapus {
        color: white;
        font-size: 1rem;
        transition: 0.2s;
    }

    .btn-hapus:hover {
        color: #ffcccc;
        transform: scale(1.1);
    }

    .card-body {
        padding: 18px;
        font-size: 0.9rem;
    }

    .card-body strong {
        color: #AC1754;
    }

    .produk-list, .harga-list {
        margin-left: 15px;
        margin-bottom: 6px;
    }

    .produk-list li, .harga-list li {
        list-style-type: "• ";
        margin-left: 8px;
    }

    .price {
        font-weight: bold;
        color: #AC1754;
        margin-top: 10px;
        font-size: 1rem;
    }

    .card-footer {
        border-top: 1px solid #eee;
        padding: 14px 18px;
        text-align: right;
    }

    .btn-bayar {
        display: inline-block;
        background: #AC1754;
        color: white;
        border-radius: 6px;
        padding: 8px 14px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-bayar:hover { background: #9c1248; }
</style>
</head>
<body>

<div class="container">
    <div class="header">
        <i class="fas fa-cash-register"></i>
        Riwayat Transaksi Kasir
    </div>

    <?php if ($pesanan->num_rows > 0): ?>
        <div class="cards-container">
            <?php while ($row = $pesanan->fetch_assoc()): 
                $status = ($row['status_pesanan'] === 'Selesai') ? 'Lunas' : $row['status_pesanan'];

                // Pisahkan produk
                $produk_list = [];
                $total_qty = 0;
                if (!empty($row['detail_produk'])) {
                    $details = explode(';', $row['detail_produk']);
                    foreach ($details as $d) {
                        list($nama, $harga, $jumlah) = explode('|', $d);
                        $produk_list[] = [
                            'nama' => $nama,
                            'harga' => $harga,
                            'jumlah' => $jumlah
                        ];
                        $total_qty += (int)$jumlah;
                    }
                }
            ?>
            <div class="card">
                <div class="card-header">
                    <div>ID Transaksi: <?= htmlspecialchars($row['id_pesanan']) ?></div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div class="status <?= htmlspecialchars($status) ?>">
                            <?= htmlspecialchars($status) ?>
                        </div>

                        <?php if ($row['status_pesanan'] == 'Pending'): ?>
                            <a href="hapus_pesanan.php?id=<?= $row['id_pesanan'] ?>"
                               class="btn-hapus"
                               title="Hapus Pesanan"
                               onclick="return confirm('Yakin ingin menghapus pesanan ini?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        <?php elseif ($status == 'Lunas'): ?>
                            <a href="nota.php?id=<?= $row['id_pesanan'] ?>" 
                               target="_blank" 
                               title="Cetak Nota" 
                               style="color: #fff;">
                                <i class="fa-solid fa-print"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body">
                    <p><strong>Tanggal Pembelian :</strong> <?= htmlspecialchars($row['tanggal_pemesanan']) ?></p>

                    <p><strong>Nama Produk :</strong></p>
                    <ul class="produk-list">
                        <?php foreach ($produk_list as $p): ?>
                            <li><?= htmlspecialchars($p['nama']) ?> (<?= htmlspecialchars($p['jumlah']) ?> pcs)</li>
                        <?php endforeach; ?>
                    </ul>

                    <p><strong>Jumlah Barang :</strong> <?= $total_qty ?> pcs</p>

                    <p><strong>Harga / pcs :</strong></p>
                    <ul class="harga-list">
                        <?php foreach ($produk_list as $p): ?>
                            <li><?= htmlspecialchars($p['nama']) ?> - Rp <?= number_format($p['harga'], 0, ',', '.') ?>/pcs</li>
                        <?php endforeach; ?>
                    </ul>

                    <p class="price">Total Harga: Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></p>
                </div>

                <div class="card-footer">
                    <?php if ($row['status_pesanan'] == 'Pending'): ?>
                        <a href="bayar.php?id=<?= $row['id_pesanan'] ?>" class="btn-bayar">
                            Bayar
                        </a>
                    <?php elseif ($status == 'Lunas'): ?>
                        <div style="text-align: left; font-size: 0.9rem; color:#333;">
                            <strong>Total Bayar:</strong> Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?><br>
                            <strong>Kembalian:</strong> Rp <?= number_format($row['kembalian'], 0, ',', '.') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div style="text-align:center; color:#666; padding:50px;">Belum ada transaksi.</div>
    <?php endif; ?>
</div>

<script>
// Auto reload tiap 20 detik
setTimeout(() => location.reload(), 20000);
</script>

</body>
</html>
