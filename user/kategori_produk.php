<?php
$koneksi = mysqli_connect("localhost", "root", "", "toko");

// Ambil kategori dari URL
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

if ($kategori) {
    $query = "SELECT * FROM tb_produk WHERE kategori = '$kategori'";
    $result = mysqli_query($koneksi, $query);
} else {
    $result = false;
}

// Ambil rata-rata rating dan jumlah review per produk
$rating_data = [];
$rating_query = mysqli_query($koneksi, "
    SELECT id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS total_review
    FROM tb_review
    GROUP BY id
");
while ($r = mysqli_fetch_assoc($rating_query)) {
    $rating_data[$r['id']] = [
        'avg' => $r['avg_rating'],
        'total' => $r['total_review']
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kategori: <?= $kategori ? ucfirst($kategori) : 'Tidak Diketahui' ?></title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #FFEDFA 0%, #F8E8FF 100%);
    margin: 0;
}
header {
    background: linear-gradient(135deg, #AC1754 0%, #D63384 100%);
    color: white;
    padding: 8px 0;
    text-align: center;
    position: fixed;           /* 🧷 Bikin header tetap di atas */
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;             /* biar gak ketimpa konten lain */
    box-shadow: 0 4px 15px rgba(172, 23, 84, 0.2);
}

header h1 {
    margin: 0;
    font-size: 1.3rem;
}

.back-button {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
}

.back-button img {
    width: 24px;
    height: 24px;
}

/* tambahkan jarak di bawah header supaya konten gak ketimpa */
.container {
    max-width: 1150px;
    margin: 100px auto 40px;   /* 🔧 tambah margin-top 100px */
    padding: 10px 20px;
}

.produk-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 18px;
}
.produk-item {
    position: relative;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    text-align: center;
}
.produk-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 18px rgba(172, 23, 84, 0.2);
}
.produk-item img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    transition: 0.3s ease;
}
.produk-info {
    padding: 10px 8px 15px;
}
.produk-info h3 {
    margin: 5px 0;
    font-size: 0.9rem;
    color: #333;
    font-weight: 600;
}
.produk-info p {
    color: #AC1754;
    font-weight: 600;
    font-size: 0.9rem;
    margin: 0;
}
.rating {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 4px;
    gap: 2px;
}
.star {
    width: 15px;
    height: 15px;
    background-color: #ddd;
    clip-path: polygon(50% 0%, 63% 38%, 100% 38%, 70% 59%, 82% 100%, 50% 75%, 18% 100%, 30% 59%, 0% 38%, 37% 38%);
}
.star.filled {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
}
.rating-text {
    font-size: 0.8rem;
    color: #555;
    margin-top: 2px;
}

/* === STOK HABIS === */
.out-of-stock {
    opacity: 0.5;
    pointer-events: none;
    position: relative;
}
.out-of-stock::after {
    content: "Produk Habis";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(172, 23, 84, 0.9);
    color: white;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
}
</style>
</head>
<body>

<header>
    <a href="jenis_produk.php" class="back-button">
        <img src="img/back-icon.png" alt="Kembali">
    </a>
    <h1>Kategori: <?= $kategori ? ucfirst($kategori) : 'Belum Dipilih' ?></h1>
</header>

<div class="container">
<?php if ($result && mysqli_num_rows($result) > 0): ?>
    <div class="produk-grid">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <?php
            $isOut = $row['stok'] <= 0;
            $id_produk = $row['id'];
            $avg_rating = isset($rating_data[$id_produk]) ? $rating_data[$id_produk]['avg'] : 0;
            $total_review = isset($rating_data[$id_produk]) ? $rating_data[$id_produk]['total'] : 0;
            ?>
            <div class="produk-item <?= $isOut ? 'out-of-stock' : '' ?>">
                <?php if (!$isOut): ?>
                    <a href="detail_produk.php?id=<?= $id_produk ?>" style="text-decoration:none; color:inherit;">
                <?php endif; ?>
                        <img src="img/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                        <div class="produk-info">
                            <h3><?= htmlspecialchars($row['nama_produk']) ?></h3>
                            <p>Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>

                            <?php if ($avg_rating > 0): ?>
                                <div class="rating">
                                    <?php
                                    $fullStars = floor($avg_rating);
                                    $halfStar = ($avg_rating - $fullStars) >= 0.5;
                                    for ($i = 1; $i <= 5; $i++):
                                        if ($i <= $fullStars) {
                                            echo '<div class="star filled"></div>';
                                        } elseif ($halfStar && $i == $fullStars + 1) {
                                            echo '<div class="star filled" style="background:linear-gradient(90deg,#FFD700 50%,#ddd 50%);"></div>';
                                        } else {
                                            echo '<div class="star"></div>';
                                        }
                                    endfor;
                                    ?>
                                </div>
                                <div class="rating-text"><?= $avg_rating ?>/5 (<?= $total_review ?> ulasan)</div>
                            <?php endif; ?>
                        </div>
                <?php if (!$isOut): ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p style="text-align:center;color:#AC1754;">Belum ada produk dalam kategori ini.</p>
<?php endif; ?>
</div>

</body>
</html>
