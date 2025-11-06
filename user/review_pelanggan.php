<?php
include "../koneksi.php"; // koneksi database

$id_pesanan = isset($_GET['id']) ? $_GET['id'] : null;

// 🟢 Cek apakah sudah pernah review
$sudah_review = false;
if ($id_pesanan) {
    $cek_review = $koneksi->query("SELECT COUNT(*) as jumlah FROM tb_review WHERE id_pesanan = '$id_pesanan'");
    $sudah_review = $cek_review->fetch_assoc()['jumlah'] > 0;
}

// 🟢 Proses simpan review
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

        header("Location: review.php?id_pesanan=$id_pesanan");
        exit;
    } else {
        echo "<script>alert('Produk untuk pesanan ini tidak ditemukan.');</script>";
    }
}

// 🟡 Jika tidak ada ID pesanan dikirim
if (!$id_pesanan) {
    echo "<h3 style='text-align:center;color:#a01646;'>⚠️ ID pesanan tidak ditemukan.</h3>";
    exit;
}

// 🟢 Ambil data pesanan
$query_pesanan = "
    SELECT p.id_pesanan, p.nama_pelanggan, p.total_harga, p.tanggal_pemesanan
    FROM tb_pesanan p
    WHERE p.id_pesanan = '$id_pesanan'
    LIMIT 1
";
$pesanan = $koneksi->query($query_pesanan)->fetch_assoc();

// 🟢 Ambil daftar produk dalam pesanan
$produk_detail = $koneksi->query("
    SELECT pr.nama_produk, dp.jumlah
    FROM tb_detailpes dp
    JOIN tb_produk pr ON dp.id = pr.id
    WHERE dp.id_pesanan = '$id_pesanan'
");

// 🟢 Ambil review yang sudah ada
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
<title>Review Produk | The Cakery</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #fff8fb, #ffeaf2);
        margin: 0;
        padding: 0;
    }

    header {
        background: linear-gradient(90deg, #a01646, #d45077);
        color: white;
        padding: 14px 0; /* 🔧 header lebih kecil */
        text-align: center;
        font-weight: 600;
        font-size: 20px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .container {
        max-width: 780px;
        background: white;
        margin: 40px auto;
        border-radius: 18px;
        padding: 40px 50px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .produk {
        background: #fff6fa;
        border: 1px solid #f4cddd;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .produk h3 {
        margin: 0;
        color: #a01646;
    }

    ul {
        list-style: none;
        padding: 0;
        margin-top: 10px;
    }

    li {
        padding: 8px 0;
        font-size: 15px;
        border-bottom: 1px dashed #f3c6d7;
    }

    li:last-child {
        border-bottom: none;
    }

    .form-review {
        border-radius: 15px;
        background: #fff9fc;
        border: 1px solid #f6d6e4;
        padding: 25px 30px;
        text-align: center;
    }

    .form-review h4 {
        color: #a01646;
        margin-bottom: 20px;
        font-size: 19px;
    }

    input, textarea {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-top: 6px;
        font-family: 'Poppins';
        font-size: 14px;
        background: #fff;
    }

    textarea {
        height: 100px;
        resize: none;
    }

    .rating-stars {
        display: flex;
        justify-content: center;
        flex-direction: row-reverse;
        margin: 15px 0;
    }

    .rating-stars input {
        display: none;
    }

    .rating-stars label {
        font-size: 35px;
        color: #ddd;
        cursor: pointer;
        transition: 0.2s;
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
        padding: 12px 0;
        border-radius: 25px;
        font-weight: 600;
        width: 100%;
        margin-top: 15px;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s;
    }

    button:hover {
        background: linear-gradient(90deg, #8b133e, #bf4068);
        transform: translateY(-2px);
    }

    .review-box {
        margin-top: 20px;
        border-radius: 15px;
        background: #fff9fb;
        border: 1px solid #f4d8e1;
        padding: 15px 20px;
    }

    .review-box strong { color: #a01646; font-size: 15px; }
    .review-box .rating { color: #ffb400; font-size: 16px; }
    .review-box small { color: #777; }

    .no-review {
        text-align: center;
        color: #888;
        font-style: italic;
        margin-top: 10px;
    }
</style>
</head>
<body>

<header>Review Produk Anda</header>

<div class="container">
<?php if ($pesanan): ?>
    <div class="produk">
        <h3>Pesanan <?= htmlspecialchars($pesanan['id_pesanan']) ?> - <?= htmlspecialchars($pesanan['nama_pelanggan']) ?></h3>
        <p><strong>Tanggal:</strong> <?= date('d M Y, H:i', strtotime($pesanan['tanggal_pemesanan'])) ?></p>
        <p><strong>Produk yang dibeli:</strong></p>
        <ul>
            <?php while ($p = $produk_detail->fetch_assoc()): ?>
                <li><?= htmlspecialchars($p['nama_produk']) ?> (<?= $p['jumlah'] ?>x)</li>
            <?php endwhile; ?>
        </ul>
    </div>

    <?php if ($sudah_review): ?>
        <div class="review-box" style="text-align:center;">
            <h4 style="color:#a01646;">✅ Terima kasih! Anda sudah memberikan review untuk pesanan ini.</h4>
        </div>
    <?php else: ?>
        <div class="form-review">
            <h4>Berikan Review untuk Pesanan Ini</h4>
            <form method="POST">
                <input type="hidden" name="id_pesanan" value="<?= htmlspecialchars($id_pesanan) ?>">

                <label>Nama Anda</label>
                <input type="text" name="nama_pelanggan" placeholder="Masukkan nama Anda" required>

                <label>Rating</label>
                <div class="rating-stars">
                    <input type="radio" name="rating" id="bintang5" value="5"><label for="bintang5">★</label>
                    <input type="radio" name="rating" id="bintang4" value="4"><label for="bintang4">★</label>
                    <input type="radio" name="rating" id="bintang3" value="3"><label for="bintang3">★</label>
                    <input type="radio" name="rating" id="bintang2" value="2"><label for="bintang2">★</label>
                    <input type="radio" name="rating" id="bintang1" value="1"><label for="bintang1">★</label>
                </div>

                <label>Komentar</label>
                <textarea name="komentar" placeholder="Ceritakan pengalaman Anda..." required></textarea>

                <button type="submit">Kirim Review</button>
            </form>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p style="color:#a01646;">❌ Data pesanan tidak ditemukan.</p>
<?php endif; ?>
</div>

</body>
</html>
