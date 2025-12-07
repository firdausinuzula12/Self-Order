<?php
session_start();
include 'koneksi.php';

$id = intval($_GET['id']);
$query = $koneksi->query("SELECT * FROM tb_produk WHERE id = $id");
$produk = $query->fetch_assoc();

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit;
}

if (isset($_POST['tambah_keranjang']) || isset($_POST['beli_sekarang'])) {
    $jumlah = $_POST['jumlah'];
    if ($jumlah > $produk['stok']) {
        $error_message = "Stok tersedia hanya " . $produk['stok'] . " item";
    } else {
        if (!isset($_SESSION['keranjang'])) $_SESSION['keranjang'] = [];

        $found = false;
        foreach ($_SESSION['keranjang'] as &$item) {
            if ($item['id'] == $produk['id']) {
                $item['jumlah'] += $jumlah;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['keranjang'][] = [
                'id' => $produk['id'],
                'gambar' => $produk['gambar'],
                'nama' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'jumlah' => $jumlah
            ];
        }

        if (isset($_POST['tambah_keranjang'])) {
            header("Location: keranjang.php");
            exit();
        } else {
            header("Location: detail_pesanan.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($produk['nama_produk']); ?> - Detail Produk</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #FFEDFA 0%, #F8E8FF 100%);
    margin: 0;
    color: #333;
}

/* ==== HEADER ==== */
.header {
    background: linear-gradient(135deg, #AC1754 0%, #D63384 100%);
    color: white;
    padding: 28px 0;
    box-shadow: 0 4px 15px rgba(172, 23, 84, 0.3);
    text-align: center;
    position: relative;
}
.header h1 {
    font-size: 30px;
    margin: 0;
    font-weight: 600;
}
.back-button {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
}
.back-button img {
    width: 30px;
    height: 30px;
    transition: transform 0.2s ease;
}
.back-button:hover img { transform: scale(1.1); }

/* ==== DETAIL CONTAINER ==== */
.detail-container {
    max-width: 800px;
    margin: 15px auto;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    animation: fadeIn 0.5s ease;
}
.product-layout {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 0px;
    padding: 30px;
}
.detail-image img {
    width: 250px;
    height: 250px;
    object-fit: right;
    border-radius: 0px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: transform 0.3s;
}
.detail-image:hover img { transform: scale(1.05); }

/* ==== INFO PRODUK ==== */
.basic-info h2 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 6px;
}
.basic-info p {
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 8px;
}
.basic-meta {
    background: rgba(172,23,84,0.05);
    padding: 6px;
    border-radius: 3px;
    font-size: 0.8rem;
}
.basic-meta span { font-weight: 600; color: #AC1754; }

/* ==== HARGA ==== */
.price-display {
    background: #AC1754;
    color: white;
    padding: 8px;
    border-radius: 3px;
    text-align: center;
    margin: 10px 0;
}
.price-label { font-size: 0.8rem; opacity: 0.85; }
.price-amount { font-size: 1rem; font-weight: 600; }

/* ==== FORM JUMLAH ==== */
.qty-section {
    border: 1px solid rgba(172,23,84,0.1);
    border-radius: 3px;
    padding: 10px;
    text-align: center;
}
.qty-box {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-bottom: 6px;
}
.qty-btn {
    width: 28px;
    height: 28px;
    border-radius: 3;
    border: 2px solid #AC1754;
    background: white;
    color: #AC1754;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}
.qty-btn:hover { background: #AC1754; color: white; }
.qty-input {
    width: 55px;
    height: 30px;
    text-align: center;
    font-weight: 600;
    border: 2px solid #ddd;
    border-radius: 3px;
}
.total-display {
    font-weight: 600;
    color: #AC1754;
    font-size: 0.9rem;
}

/* ==== BUTTON ==== */
.btn-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: 10px;
}
.btn {
    padding: 8px 0;
    border: none;
    border-radius: 3px;
    color: white;
    background: linear-gradient(135deg, #AC1754 0%, #D63384 100%);
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: 0.3s;
}
.btn:hover { transform: translateY(-2px); }

/* ==== RESPONSIVE ==== */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
@media(max-width:768px){
    .product-layout{ grid-template-columns:1fr; padding:15px; }
    .header h1 { font-size: 18px; }
}
</style>
</head>
<body>

<header class="header">
    <a href="jenis_produk.php" class="back-button">
        <img src="img/back-icon.png" alt="Kembali">
    </a>
    <h1>Detail Produk</h1>
</header>

<div class="detail-container">
    <?php if (isset($error_message)): ?>
        <div style="background:#f8d7da;color:#721c24;padding:8px;border-radius:10px;text-align:center;margin:10px;">
            <?= $error_message; ?>
        </div>
    <?php endif; ?>

    <div class="product-layout">
        <div class="detail-image">
            <img src="img/<?= htmlspecialchars($produk['gambar']); ?>" alt="<?= htmlspecialchars($produk['nama_produk']); ?>">
        </div>

        <div>
            <div class="basic-info">
                <h2><?= htmlspecialchars($produk['nama_produk']); ?></h2>
                <p><?= htmlspecialchars($produk['deskripsi']); ?></p>
                <div class="basic-meta">
                    <div>Stok: <span><?= $produk['stok']; ?></span></div>
                    <div>Kategori: <span><?= ucfirst($produk['kategori']); ?></span></div>
                </div>
            </div>

            <div class="price-display">
                <div class="price-label">Harga</div>
                <div class="price-amount">Rp<?= number_format($produk['harga'], 0, ',', '.'); ?></div>
            </div>

            <form method="post">
                <div class="qty-section">
                    <div class="qty-box">
                        <button type="button" class="qty-btn" onclick="ubahQty(-1)">-</button>
                        <input type="number" name="jumlah" id="qty" value="1" min="1" max="<?= $produk['stok']; ?>" class="qty-input">
                        <button type="button" class="qty-btn" onclick="ubahQty(1)">+</button>
                    </div>
                    <div class="total-display" id="total">Rp<?= number_format($produk['harga'], 0, ',', '.'); ?></div>
                </div>

                <div class="btn-group">
                    <button name="tambah_keranjang" class="btn">Keranjang</button>
                    <button name="beli_sekarang" class="btn">Beli</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const harga = <?= $produk['harga']; ?>;
const stok = <?= $produk['stok']; ?>;
function ubahQty(val){
    const qty = document.getElementById('qty');
    let jumlah = parseInt(qty.value) + val;
    if(jumlah < 1) jumlah = 1;
    if(jumlah > stok) jumlah = stok;
    qty.value = jumlah;
    document.getElementById('total').innerText = 'Rp' + (jumlah * harga).toLocaleString('id-ID');
}
</script>

</body>
</html>
