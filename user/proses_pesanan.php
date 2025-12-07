<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['keranjang'], $_SESSION['no_antrian'], $_SESSION['id_pesanan'], $_SESSION['nama_pelanggan'])) {
    echo "Data pesanan tidak lengkap. Silakan coba lagi.";
    exit();
}

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$no_antrian = $_SESSION['no_antrian'];
$id_pesanan = $_SESSION['id_pesanan'];
$nama_pelanggan = $_SESSION['nama_pelanggan'];
$keranjang = $_SESSION['keranjang'];

// Hitung total harga
$totalHarga = 0;
foreach ($keranjang as $item) {
    $totalHarga += $item['harga'] * $item['jumlah'];
}

// Data tambahan
$metode_pembayaran = $_POST['metode_pembayaran'] ?? 'Tunai';
$status_pesanan = 'Pending';
$tanggal_pemesanan = date('Y-m-d H:i:s');

$pesanan_berhasil = false;
$error_message = "";

$koneksi->begin_transaction();

try {
    // Cek apakah ID pesanan sudah ada (hindari duplikasi)
    $cek = $koneksi->prepare("SELECT id_pesanan FROM tb_pesanan WHERE id_pesanan = ?");
    $cek->bind_param("s", $id_pesanan);
    $cek->execute();
    if ($cek->get_result()->num_rows > 0) {
        throw new Exception("Pesanan dengan ID ini sudah tersimpan sebelumnya.");
    }

    // Gabungkan nama produk untuk disimpan di tb_pesanan
    $nama_produk_gabungan = "";
    $jumlah_total = 0;
    foreach ($keranjang as $item) {
        $nama_produk_gabungan .= $item['nama'] . ", ";
        $jumlah_total += $item['jumlah'];
    }
    $nama_produk_gabungan = rtrim($nama_produk_gabungan, ", ");

    // Simpan data pesanan utama
    $sql_pesanan = $koneksi->prepare("INSERT INTO tb_pesanan 
        (id_pesanan, nama_produk, jumlah, nama_pelanggan, no_antrian, metode_pembayaran, total_harga, status_pesanan, tanggal_pemesanan)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql_pesanan->bind_param(
        "ssissssss",
        $id_pesanan,
        $nama_produk_gabungan,
        $jumlah_total,
        $nama_pelanggan,
        $no_antrian,
        $metode_pembayaran,
        $totalHarga,
        $status_pesanan,
        $tanggal_pemesanan
    );

    if (!$sql_pesanan->execute()) {
        throw new Exception("Gagal menyimpan pesanan: " . $sql_pesanan->error);
    }

    // Simpan detail pesanan (per produk)
    $sql_detail = $koneksi->prepare("INSERT INTO tb_detailpes (id_pesanan, id, nama_produk, harga, jumlah, subtotal)
        VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($keranjang as $item) {
        $id_produk = (int)$item['id'];
        $nama_produk = $item['nama'];
        $harga = (float)$item['harga'];
        $jumlah = (int)$item['jumlah'];
        $subtotal = $harga * $jumlah;

        $sql_detail->bind_param("sissii", $id_pesanan, $id_produk, $nama_produk, $harga, $jumlah, $subtotal);
        if (!$sql_detail->execute()) {
            throw new Exception("Gagal menyimpan detail produk: " . $sql_detail->error);
        }

        // Update stok produk
        $sql_stok = $koneksi->prepare("UPDATE tb_produk SET stok = stok - ? WHERE id = ?");
        $sql_stok->bind_param("ii", $jumlah, $id_produk);
        $sql_stok->execute();
    }

    // Commit transaksi jika semua berhasil
    $koneksi->commit();

    // Hapus keranjang setelah pesanan berhasil
    unset($_SESSION['keranjang']);
    $pesanan_berhasil = true;

} catch (Exception $e) {
    // Rollback jika ada error
    $koneksi->rollback();
    $error_message = $e->getMessage();
}

$koneksi->close();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f8f8; 
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            width: 90%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.4s ease;
        }

        .icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            font-size: 38px;
            color: white;
        }

        .icon.success { 
            background: #28a745; 
        }
        .icon.error { 
            background: #dc3545; 
        }
        .icon.process { 
            background: #6c757d; 
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        p {
            color: #555;
            margin-bottom: 20px;
        }

        .order-summary {
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            color: #444;
        }

        .summary-row:last-child {
            font-weight: 600;
            color: #000;
        }

        .btn {
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn:hover {
            background: #218838;
        }

        .countdown {
            font-size: 1rem;
            color: #852b2bff;
            margin-top: 10px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            .modal {
                padding: 30px 20px;
            }

            h1 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>

<?php if ($pesanan_berhasil): ?>
    <div class="overlay">
        <div class="modal">
            <div class="icon success">✓</div>
            <h1>Pesanan Berhasil</h1>
            <p>Silahkan tunggu untuk proses pembayaran</p>
            <p>Terima kasih, <strong><?= htmlspecialchars($nama_pelanggan) ?></strong></p>

            <div class="order-summary">
                <div class="summary-row"><span>No. Antrian:</span><span><?= htmlspecialchars($no_antrian) ?></span></div>
                <div class="summary-row"><span>ID Pesanan:</span><span><?= htmlspecialchars($id_pesanan) ?></span></div>
                <div class="summary-row"><span>Metode:</span><span><?= htmlspecialchars($metode_pembayaran) ?></span></div>
                <div class="summary-row"><span>Total:</span><span>Rp<?= number_format($totalHarga, 0, ',', '.') ?></span></div>

                <?php
?>

            </div>
            <div class="countdown">Mengalihkan dalam <span id="countdown">5</span> detik...</div>
        </div>
    </div>

<?php elseif (!empty($error_message)): ?>
    <div class="overlay">
        <div class="modal">
            <div class="icon error">✗</div>
            <h1>Pesanan Gagal</h1>
            <p><?= htmlspecialchars($error_message) ?></p>
            <button class="btn" style="background:#dc3545;" onclick="goBack()">Coba Lagi</button>
        </div>
    </div>

<?php else: ?>
    <div class="overlay">
        <div class="modal">
            <div class="icon process">⏳</div>
            <h1>Memproses Pesanan</h1>
            <p>Mohon tunggu sebentar...</p>
        </div>
    </div>
<?php endif; ?>

<script>
let timeLeft = 5;
function updateCountdown() {
    const el = document.getElementById('countdown');
    if (el) el.textContent = timeLeft;
    if (timeLeft <= 0) window.location.href = 'index.php';
    else timeLeft--;
}
function redirectNow() { window.location.href = 'index.php'; }
function goBack() { window.history.back(); }
setInterval(updateCountdown, 1000);
</script>
</body>
</html>
