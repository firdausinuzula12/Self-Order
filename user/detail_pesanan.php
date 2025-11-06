<?php 
session_start();
include 'koneksi.php';

// Cek sesi dan data keranjang
if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    echo "Keranjang belanja kosong. Tidak bisa melanjutkan pesanan.";
    exit();
}

if (!isset($_SESSION['nama_pelanggan']) || !isset($_SESSION['no_antrian'])) {
    echo "Data pelanggan tidak lengkap.";
    exit();
}

// Ambil data dari session
$nama_pelanggan = $_SESSION['nama_pelanggan'];
$no_antrian = $_SESSION['no_antrian'];
$keranjang = $_SESSION['keranjang'];
$totalHarga = 0;
foreach ($keranjang as $item) {
    $totalHarga += $item['harga'] * $item['jumlah']; //harga * qty
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - The Cakery</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: #f8f8f8;
            min-height: 100vh;
            color: #333;
            line-height: 1.6;
        }

        .main-wrapper {
            background-color: #f8f8f8;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(172, 23, 84, 0.1);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: #AC1754;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .content {
            padding: 20px;
        }

        .customer-info {
            background: #f8f8f8;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid rgba(172, 23, 84, 0.1);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #AC1754;
            font-size: 0.9rem;
        }

        .info-value {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }

        .table-header {
            background: #AC1754;
            color: white;
            padding: 12px;
            font-weight: 600;
            text-align: center;
            font-size: 0.9rem;
        }

        .order-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid rgba(172, 23, 84, 0.1);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
            font-size: 0.95rem;
        }

        .item-info {
            display: flex;
            gap: 15px;
            font-size: 0.85rem;
            color: #666;
        }

        .item-price {
            color: #AC1754;
            font-weight: 600;
        }

        .item-quantity {
            color: #AC1754;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight:600;
        }

        .item-subtotal {
            font-weight: 700;
            color: #AC1754;
            font-size: 0.95rem;
            text-align: right;
            min-width: 80px;
        }

        .total-section {
            background: #f8f8f8;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid rgba(172, 23, 84, 0.1);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 20px;
            font-weight: 700;
            color: #AC1754;
        }

        .btn-confirm {
            width: 100%;
            padding: 15px;
            background: #AC1754;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 2px 6px rgba(172, 23, 84, 0.2);
        }

        .btn-confirm:hover {
            background: #9c1248;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(172, 23, 84, 0.3);
        }

        .btn-confirm:active {
            transform: translateY(0);
        }

        .summary-card {
            background: linear-gradient(135deg, #AC1754, #9c1248);
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }

        .summary-title {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .summary-count {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .order-summary {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            .main-wrapper {
                padding: 15px;
            }

            .header h1 {
                font-size: 1.4rem;
            }

            .content {
                padding: 15px;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .order-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .item-subtotal {
                text-align: left;
                min-width: auto;
            }

            .item-info {
                flex-wrap: wrap;
            }

            .order-summary {
                grid-template-columns: 1fr;
            }
        }

        /* Loading state untuk button */
        .btn-confirm.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-confirm.loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-receipt"></i> Detail Pesanan</h1>
            <p>Konfirmasi pesanan Anda sebelum melanjutkan</p>
        </div>

        <div class="content">
            <form method="POST" action="proses_pesanan.php">
                
                <!-- Info Pelanggan -->
                <div class="customer-info">
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-user"></i> Nama Pelanggan</span>
                        <span class="info-value"><?php echo htmlspecialchars($nama_pelanggan); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-ticket-alt"></i> No Antrian</span>
                        <span class="info-value"><?php echo htmlspecialchars($no_antrian); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-money-bill-wave"></i> Metode Pembayaran</span>
                        <span class="info-value"> Tunai</span>
                    </div>
                </div>

                <!-- Tabel Pesanan -->
                <div class="order-table">
                    <div class="table-header">
                        <i class="fas fa-list"></i> Daftar Pesanan
                    </div>
                    
                    <?php foreach ($keranjang as $item): 
                        $subtotal = $item['harga'] * $item['jumlah'];
                    ?>
                    <div class="order-item">
                        <div class="item-details">
                            <div class="item-name"><?php echo htmlspecialchars($item['nama']); ?></div>
                            <div class="item-info">
                                <span class="item-price">Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></span>
                                <span>×</span>
                                <span class="item-quantity"><?php echo $item['jumlah']; ?></span>
                            </div>
                        </div>
                        <div class="item-subtotal">
                            Rp<?php echo number_format($subtotal, 0, ',', '.'); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Total -->
                <div class="total-section">
                    <div class="total-row">
                        <span> Total Pembayaran</span>
                        <span>Rp<?php echo number_format($totalHarga, 0, ',', '.'); ?></span>
                    </div>
                </div>

                <!-- Tombol Konfirmasi -->
                <input type="hidden" name="metode_pembayaran" value="Tunai">
                <button type="submit" class="btn-confirm" onclick="this.classList.add('loading')">
                    Konfirmasi Pesanan
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>