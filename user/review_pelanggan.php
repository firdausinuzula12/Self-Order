<?php
include "../koneksi.php"; 

$id_pesanan = isset($_GET['id']) ? $_GET['id'] : null;

$sudah_review = false;
if ($id_pesanan) {
    $cek_review = $koneksi->query("SELECT COUNT(*) as jumlah FROM tb_review WHERE id_pesanan = '$id_pesanan'");
    $sudah_review = $cek_review->fetch_assoc()['jumlah'] > 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$sudah_review) {
    $id_pesanan = $_POST['id_pesanan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];

    $produk_list = $koneksi->query("
    SELECT dp.id AS id_produk, pr.nama_produk 
    FROM tb_detailpes dp 
    JOIN tb_produk pr ON dp.id = pr.id 
    WHERE dp.id_pesanan = '$id_pesanan'
");

if ($produk_list && $produk_list->num_rows > 0) {
    while ($p = $produk_list->fetch_assoc()) {
        $id_produk = $p['id_produk'];
        $nama_produk = $p['nama_produk'];

        $stmt = $koneksi->prepare("
            INSERT INTO tb_review (id_pesanan, id, nama_produk, nama_pelanggan, rating, komentar, waktu_review)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
            $stmt->bind_param("iissis", $id_pesanan, $id_produk, $nama_produk, $nama_pelanggan, $rating, $komentar);
            $stmt->execute();
        }

        header("Location: review.php?id=$id_pesanan");
        exit;
    } else {
        echo "<script>alert('Produk untuk pesanan ini tidak ditemukan.');</script>";
    }
}

if (!$id_pesanan) {
    echo "<h3 style='text-align:center;color:#a01646;'>⚠️ ID pesanan tidak ditemukan.</h3>";
    exit;
}

$query_pesanan = "
    SELECT p.id_pesanan, p.nama_pelanggan, p.total_harga, p.tanggal_pemesanan
    FROM tb_pesanan p
    WHERE p.id_pesanan = '$id_pesanan'
    LIMIT 1
";
$pesanan = $koneksi->query($query_pesanan)->fetch_assoc();


$produk_detail = $koneksi->query("
    SELECT pr.nama_produk, dp.jumlah
    FROM tb_detailpes dp
    JOIN tb_produk pr ON dp.id = pr.id
    WHERE dp.id_pesanan = '$id_pesanan'
");

$result = $koneksi->query("
    SELECT * FROM tb_review 
    WHERE id_pesanan = '$id_pesanan' 
    ORDER BY waktu_review DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Review Produk | The Cakery</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #fff8fb, #ffeaf2);
        min-height: 100vh;
        padding: 0;
        margin: 0;
    }

    header {
        background: linear-gradient(90deg, #a01646, #d45077);
        color: white;
        padding: 15px;
        text-align: center;
        font-weight: 600;
        font-size: 22px;
        box-shadow: 0 2px 8px rgba(160, 22, 70, 0.2);
        margin-bottom: 25px;
    }

    .container {
        max-width: 700px;
        background: white;
        margin: 0 auto 20px;
        border-radius: 3px;
        padding: 25px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }

    .info-pesanan {
        background: linear-gradient(135deg, #fff6fa, #ffeef5);
        border: 2px solid #f4cddd;
        border-radius: 3px;
        padding: 18px;
        margin-bottom: 20px;
    }

    .info-pesanan h3 {
        color: #a01646;
        font-size: 17px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-table {
        margin: 10px 0;
    }

    .info-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-table td {
        padding: 4px 0;
        vertical-align: top;
        font-size: 14px;
        line-height: 1.4;
    }

    .info-table td:first-child {
        width: 120px;
        font-weight: 600;
        color: #555;
    }

    .info-table td:nth-child(2) {
        width: 20px;
        text-align: center;
    }

    .produk-list {
        background: #fff;
        border: 1px solid #f3c6d7;
        border-radius: 3px;
        padding: 12px;
        margin-top: 10px;
    }

    .produk-list h4 {
        color: #a01646;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .produk-list ul {
        list-style: none;
        padding: 0;
    }

    .produk-list li {
        padding: 6px 8px;
        margin: 3px 0;
        background: #fff9fc;
        border-left: 3px solid #d45077;
        border-radius: 3px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        line-height: 1.3;
    }

    .form-review {
        border-radius: 3px;
        background: #fff;
        border: 1px solid #e0e0e0;
        padding: 30px;
    }

    .form-review h4 {
        color: #a01646;
        margin-bottom: 25px;
        font-size: 20px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    input[type="text"], textarea {
        width: 100%;
        padding: 12px 15px;
        border-radius: 3px;
        border: 1px solid #ddd;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        background: #fafafa;
        transition: all 0.3s;
        line-height: 1.5;
    }

    input[type="text"]:focus, textarea:focus {
        outline: none;
        border-color: #a01646;
        background: #fff;
    }

    textarea {
        height: 110px;
        resize: vertical;
    }

    .rating-stars {
        display: flex;
        justify-content: center;
        flex-direction: row-reverse;
        gap: 8px;
        margin: 20px 0;
    }

    .rating-stars input {
        display: none;
    }

    .rating-stars label {
        font-size: 45px;
        color: #ddd;
        cursor: pointer;
        transition: all 0.2s;
    }

    .rating-stars input:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #ffb400;
        transform: scale(1.1);
    }

    button {
        background: linear-gradient(90deg, #a01646, #d45077);
        color: white;
        border: none;
        padding: 14px 0;
        border-radius: 3px;
        font-weight: 600;
        width: 100%;
        margin-top: 10px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    button:hover {
        background: linear-gradient(90deg, #8b133e, #bf4068);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(160, 22, 70, 0.3);
    }

    .success-message {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border: 2px solid #28a745;
        border-radius: 3px;
        padding: 20px;
        text-align: center;
        color: #155724;
    }

    .success-message i {
        font-size: 40px;
        margin-bottom: 10px;
        display: block;
    }

    .success-message h4 {
        font-size: 18px;
        margin-bottom: 8px;
    }

    @media (max-width: 768px) {
        .container {
            padding: 20px;
        }
        
        header {
            font-size: 20px;
            padding: 15px;
        }
        
        .rating-stars label {
            font-size: 35px;
        }
    }
</style>
</head>
<body>

<header>
    <i class="fas fa-star"></i> Review Produk Anda
</header>

<div class="container">
<?php if ($pesanan): ?>
    <div class="info-pesanan">
        <h3><i class="fas fa-receipt"></i> Detail Pesanan</h3>
        
        <div class="info-table">
            <table>
                <tr>
                    <td>ID Pesanan</td>
                    <td>:</td>
                    <td><strong><?= htmlspecialchars($pesanan['id_pesanan']) ?></strong></td>
                </tr>
                <tr>
                    <td>Nama Pelanggan</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($pesanan['nama_pelanggan']) ?></td>
                </tr>
                <tr>
                    <td>Tanggal Pesanan</td>
                    <td>:</td>
                    <td><?= date('d M Y, H:i', strtotime($pesanan['tanggal_pemesanan'])) ?></td>
                </tr>
                <tr>
                    <td>Total Pembayaran</td>
                    <td>:</td>
                    <td><strong>Rp<?= number_format($pesanan['total_harga'], 0, ',', '.') ?></strong></td>
                </tr>
            </table>
        </div>

        <div class="produk-list">
            <h4><i class="fas fa-box"></i> Produk yang Dibeli:</h4>
            <ul>
                <?php while ($p = $produk_detail->fetch_assoc()): ?>
                    <li>
                        <i class="fas fa-check-circle" style="color: #28a745;"></i>
                        <span><?= htmlspecialchars($p['nama_produk']) ?> <strong>(<?= $p['jumlah'] ?>x)</strong></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <?php if ($sudah_review): ?>
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <h4>Terima Kasih!</h4>
            <p>Anda sudah memberikan review untuk pesanan ini. Kami sangat menghargai masukan Anda! 💕</p>
        </div>
    <?php else: ?>
        <div class="form-review">
            <h4><i class="fas fa-edit"></i> Berikan Review Anda</h4>
            <form method="POST">
                <input type="hidden" name="id_pesanan" value="<?= htmlspecialchars($id_pesanan) ?>">

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nama Anda</label>
                    <input type="text" name="nama_pelanggan" placeholder="Masukkan nama Anda" required value="<?= htmlspecialchars($pesanan['nama_pelanggan']) ?>" readonly style="background: #f5f5f5;">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-star"></i> Rating Produk</label>
                    <div class="rating-stars">
                        <input type="radio" name="rating" id="bintang5" value="5" required><label for="bintang5">★</label>
                        <input type="radio" name="rating" id="bintang4" value="4"><label for="bintang4">★</label>
                        <input type="radio" name="rating" id="bintang3" value="3"><label for="bintang3">★</label>
                        <input type="radio" name="rating" id="bintang2" value="2"><label for="bintang2">★</label>
                        <input type="radio" name="rating" id="bintang1" value="1"><label for="bintang1">★</label>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-comment-dots"></i> Komentar</label>
                    <textarea name="komentar" placeholder="Ceritakan pengalaman Anda dengan produk kami..."></textarea>
                </div>
                <button type="submit">
                    <i class="fas fa-paper-plane"></i> Kirim Review
                </button>
            </form>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div style="text-align:center; padding: 40px; color: #a01646;">
        <i class="fas fa-exclamation-circle" style="font-size: 50px; margin-bottom: 15px; display: block;"></i>
        <h3>Data pesanan tidak ditemukan</h3>
        <p style="color: #666; margin-top: 10px;">Pastikan link yang Anda gunakan sudah benar.</p>
    </div>
<?php endif; ?>
</div>
</body>
</html>