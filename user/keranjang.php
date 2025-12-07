<?php
session_start();
include 'navbar.php';

if (!isset($_SESSION['keranjang']) || !is_array($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['nama'], $_POST['harga'], $_POST['jumlah'], $_POST['gambar'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = (int)$_POST['harga'];
    $jumlah = (int)$_POST['jumlah'];
    $gambar = $_POST['gambar'];

 
    $produkSudahAda = false;
    foreach ($_SESSION['keranjang'] as &$item) {
        if ($item['id'] == $id) {
            $item['jumlah'] += $jumlah;
            $produkSudahAda = true;
            break;
        }
    }
    unset($item);

    if (!$produkSudahAda) {
        $_SESSION['keranjang'][] = [
            'id' => $id,
            'nama' => $nama,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'gambar' => $gambar
        ];
    }
}

$totalItem = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $totalItem += isset($item['jumlah']) ? (int)$item['jumlah'] : 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Biar center secara vertikal */
        }

        .main-wrapper {
            width: 100%;
            max-width: 850px;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 750px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(172, 23, 84, 0.15);
            overflow: hidden;
            transform: translateY(20px); /* agar agak turun dari tengah */
        }


        .header::before {
            display: none;
        }

        .header h2 {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .cart-icon {
            position: relative;
            font-size: 24px;
            cursor: pointer;
        }

        .cart-badge {
            position: absolute;
            top: 1000px;
            right: -10px;
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            color: #fff;
            border-radius: 3;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .cart-content {
            padding: 20px;
        }

        .empty-cart {
            text-align: center;
            padding: 30px 20px;
            color: #666;
        }

        .empty-cart i {
            font-size: 3rem;
            color: #AC1754;
            margin-bottom: 15px;
        }

        .empty-cart h3 {
            font-size: 1.3rem;
            margin-bottom: 8px;
            color: #AC1754;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 12px;
            background: #fff;
            border-radius: 3px;
            box-shadow: 0 2px 8px rgba(172, 23, 84, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(172, 23, 84, 0.1);
            position: relative;
            overflow: hidden;
        }

        .cart-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: #AC1754;
        }

        .cart-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(172, 23, 84, 0.15);
        }

        .product-image {
            position: relative;
            margin-right: 12px;
        }

        .cart-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 3px;
            box-shadow: 0 2px 4px rgba(172, 23, 84, 0.1);
            transition: transform 0.3s ease;
        }

        .cart-item:hover img {
            transform: scale(1.05);
        }

        .cart-details {
            flex-grow: 1;
            padding-right: 12px;
        }

        .cart-details h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: #2c3e50;
        }

        .price-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
            gap: 6px;
            margin-top: 6px;
        }

        .price-item {
            display: flex;
            flex-direction: column;
        }

        .price-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 2px;
        }

        .price-value {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }

        .quantity-badge {
            background: #AC1754;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .subtotal-highlight {
            color: #AC1754;
            font-size: 1rem;
            font-weight: 700;
        }

        .btn-hapus {
            padding: 8px 12px;
            background: #AC1754;
            color: #fff;
            border: none;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 6px rgba(172, 23, 84, 0.2);
        }

        .btn-hapus:hover {
            background: #9c1248;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(172, 23, 84, 0.3);
        }

        .total-section {
            background: #f8f8f8;
            padding: 15px;
            border-radius: 3px;
            margin-top: 15px;
            border: 1px solid rgba(172, 23, 84, 0.1);
        }

        .total-row {
            text-align: right;
            font-size: 1.3rem;
            font-weight: 700;
            color: #AC1754;
            margin-bottom: 12px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 6px rgba(172, 23, 84, 0.2);
        }

        .btn-tambah {
            background: #AC1754;
        }

        .btn-tambah:hover {
            background: #9c1248;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(172, 23, 84, 0.3);
        }

        .btn-pesan {
            background: #AC1754;
        }

        .btn-pesan:hover {
            background: #9c1248;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(172, 23, 84, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-wrapper {
                padding: 15px;
            }

            .header h2 {
                font-size: 1.4rem;
            }

            .cart-content {
                padding: 15px;
            }

            .cart-item {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .product-image {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .cart-details {
                padding-right: 0;
                width: 100%;
            }

            .price-info {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-action {
                width: 100%;
                max-width: 200px;
                justify-content: center;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 3;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
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
        </div>
        <div class="cart-content">
            <?php if (empty($_SESSION['keranjang'])): ?>
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Keranjang Anda Masih Kosong</h3>
                    <p>Ayo mulai berbelanja dan tambahkan produk favorit Anda!</p>
                    <br>
                    <a href="jenis_produk.php" class="btn-action btn-tambah">
                        <i class="fas fa-plus"></i> Mulai Berbelanja
                    </a>
                </div>
            <?php else: ?>
                <?php
                $totalHarga = 0;
                foreach ($_SESSION['keranjang'] as $item):
                    $id = htmlspecialchars($item['id']);
                    $nama = htmlspecialchars($item['nama']);
                    $harga = (int)$item['harga'];
                    $jumlah = (int)$item['jumlah'];
                    $gambar = !empty($item['gambar']) ? $item['gambar'] : 'default.jpeg';
                    $subtotal = $harga * $jumlah;
                    $totalHarga += $subtotal;
                ?>
                <div class="cart-item">
                    <div class="product-image">
                        <img src="img/<?php echo htmlspecialchars($gambar); ?>" alt="<?php echo $nama; ?>">
                    </div>
                    <div class="cart-details">
                        <h4><?php echo $nama; ?></h4>
                        <div class="price-info">
                            <div class="price-item">
                                <span class="price-label">Harga Satuan</span>
                                <span class="price-value">Rp<?php echo number_format($harga, 0, ',', '.'); ?></span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">Jumlah</span>
                                <span class="price-value quantity-badge"><?php echo $jumlah; ?> pcs</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">Subtotal</span>
                                <span class="price-value subtotal-highlight">Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="hapus.php">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" class="btn-hapus">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
                <?php endforeach; ?>

                <div class="total-section">
                    <div class="total-row">
                        Total: Rp<?php echo number_format($totalHarga, 0, ',', '.'); ?>
                    </div>
                    <div class="action-buttons">
                        <a href="jenis_produk.php" class="btn-action btn-tambah">
                           Tambah Produk
                        </a>
                        <a href="detail_pesanan.php" class="btn-action btn-pesan">
                            Beli
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>