<?php 
session_start();
include 'koneksi.php';
include 'navbar.php';

// Ambil produk terlaris
$query_terlaris = "SELECT * FROM tb_produk ORDER BY stok ASC LIMIT 3";
$result_terlaris = mysqli_query($koneksi, $query_terlaris);

// Hitung jumlah keranjang
$jumlah_keranjang = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        $jumlah_keranjang += is_array($item) ? ($item['qty'] ?? 0) : $item;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Cakery</title>
  <meta name="description" content="The Cakery - Tempat terbaik untuk menikmati kue lezat dan segar.">

  <!-- Font & Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Inter', sans-serif;
      background-color: #FFEDFA;
      color: #333;
      line-height: 1.6;
      overflow-x: hidden;
      padding-top: 80px;
    }

    .hero {
      background: url('img/hero.jpg') no-repeat center center/cover;
      height: 450px;
      color: white;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .hero::after {
      content: "";
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.45);
      z-index: 0;
    }

    .hero h1, .hero p, .cta-btn { position: relative; z-index: 1; }
    .hero h1 { font-size: 49px; margin-bottom: 1px; }
    .hero p { font-size: 20px; margin-bottom: 25px; opacity: 0.9; }

    .cta-btn {
      background-color: #AC1754;
      color: #fff;
      padding: 12px 24px;
      border-radius: 2px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .cta-btn:hover { background-color: #8d1345; transform: translateY(-4px); }

    .kategori { padding: 60px 20px; background-color: #fff; }

    .kategori h2 {
      text-align: center;
      font-size: 1.8rem;
      color: #AC1754;
      margin-bottom: 40px;
      font-weight: 700;
    }

    .kategori h2::after {
      content: '';
      width: 80px; height: 4px;
      background-color: #AC1754;
      display: block;
      margin: 10px auto 0;
      border-radius: 2px;
    }

    .categories-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
      gap: 25px;
      max-width: 900px;
      margin: auto;
    }

    .category-item {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      padding: 18px;
      text-align: center;
      transition: all 0.3s ease;
    }

    .category-item:hover { 
      transform: translateY(-6px); 
      box-shadow: 0 8px 20px rgba(172,23,84,0.25); 
    }

    .category-item a { text-decoration: none; color: inherit; }

    .category-image img {
      width: 70px; height: 70px; object-fit: contain;
    }

    .category-item h3 { font-size: 1rem; margin-top: 10px; color: #333; }

    .produk-terlaris {
      padding: 50px 0px;
      background: linear-gradient(180deg, #FFF 0%, #FFEDF8 100%);
    }

    .produk-terlaris h2 {
      text-align: center;
      color: #AC1754;
      font-size: 1.8rem;
      margin-bottom: 10px;
      font-weight: 700;
    }

    .subtitle {
      text-align: center;
      color: #777;
      margin-bottom: 40px;
    }

    .terlaris-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      max-width: 770px;
      margin: auto;
    }

    .terlaris-item {
      background: white;
      border-radius: 16px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      overflow: hidden;
      transition: 0.3s ease;
    }

    .terlaris-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(172, 23, 84, 0.15);
    }

    .terlaris-item a { text-decoration: none; color: inherit; }

    .terlaris-image img {
      width: 100%; height: 160px; object-fit: cover;
    }

    .terlaris-info { text-align: center; padding: 15px; }

    .ulasan-pelanggan { padding: 60px 20px; background-color: #FFF; }
    .ulasan-pelanggan h2 {
      text-align: center; color: #AC1754; font-size: 1.8rem; margin-bottom: 10px; font-weight: 700;
    }

    .ulasan-container {
      max-width: 900px; margin: 40px auto 0; display: grid; gap: 20px;
    }

    .ulasan-item {
      background: #ffffff; border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      padding: 20px 24px; transition: all 0.3s ease;
      border-left: 4px solid #AC1754;
    }

    .ulasan-item:hover {
      transform: translateX(5px);
      box-shadow: 0 4px 15px rgba(172,23,84,0.12);
    }

    .customer-info { display: flex; align-items: center; gap: 12px; }

    .customer-avatar {
      width: 45px; height: 45px;
      background: linear-gradient(135deg, #AC1754, #d41f6b);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: white; font-weight: 700; font-size: 1.1rem;
    }

    .customer-detail h4 { color: #AC1754; font-size: 1rem; font-weight: 600; }

    .produk { font-size: 0.85rem; color: #777; }

    .rating { display: flex; gap: 3px; margin-bottom: 12px; }
    .rating i {
  color: #FFD700 !important;
}

    .komentar {
      color: #444; font-size: 0.95rem; line-height: 1.6;
      margin-bottom: 12px; padding-left: 10px; border-left: 3px solid #f0f0f0;
    }

    .review-date {
      color: #999; font-size: 0.85rem; display: flex; gap: 5px;
    }
  </style>
</head>

<body>
  <?php include 'navbar.php'; ?>

  <!-- HERO -->
  <section id="home" class="hero">
    <h1>Selamat Datang di The Cakery</h1>
    <p>Tempat terbaik untuk menikmati kue lezat, segar, dan dibuat dengan cinta.</p>
    <a href="#kategori" class="cta-btn">Pilih Kategori</a>
  </section>

  <!-- KATEGORI -->
  <section id="kategori" class="kategori">
    <h2>Pilih Kategori Favoritmu</h2>

    <div class="categories-grid">
      <div class="category-item">
        <a href="kategori_produk.php?kategori=Cake">
          <div class="category-image"><img src="img/cake.png"></div><h3>Kue</h3>
        </a>
      </div>

      <div class="category-item">
        <a href="kategori_produk.php?kategori=Cookies">
          <div class="category-image"><img src="img/cookies.png"></div><h3>Kukis</h3>
        </a>
      </div>

      <div class="category-item">
        <a href="kategori_produk.php?kategori=Donut">
          <div class="category-image"><img src="img/donut.png"></div><h3>Donat</h3>
        </a>
      </div>

      <div class="category-item">
        <a href="kategori_produk.php?kategori=Pastry">
          <div class="category-image"><img src="img/pastry.png"></div><h3>Pastry</h3>
        </a>
      </div>

      <div class="category-item">
        <a href="kategori_produk.php?kategori=Roti">
          <div class="category-image"><img src="img/bread.png"></div><h3>Roti</h3>
        </a>
      </div>
    </div>
  </section>

  <!-- PRODUK TERLARIS -->
  <section id="produk-terlaris" class="produk-terlaris">
    <h2>Produk Terlaris</h2>
    <p class="subtitle">Produk favorit pelanggan yang paling banyak dibeli</p>

    <div class="terlaris-grid">
      <?php while($produk = mysqli_fetch_assoc($result_terlaris)): ?>
        <div class="terlaris-item">
          <a href="detail_produk.php?id=<?= $produk['id'] ?>">
            <div class="terlaris-image">
              <img src="img/<?= $produk['gambar'] ?>" alt="<?= $produk['nama_produk'] ?>">
            </div>
            <div class="terlaris-info">
              <h3><?= $produk['nama_produk'] ?></h3>
            </div>
          </a>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <!-- ULASAN -->
  <section id="ulasan-pelanggan" class="ulasan-pelanggan">
    <h2>Ulasan Pelanggan</h2>
    <p class="subtitle">Pendapat mereka tentang produk kami</p>

    <div class="ulasan-container">

      <?php
      // QUERY ULASAN — 1 ULASAN PER ORANG, PRODUK DIKELOMPOKKAN
      $query_ulasan = "
        SELECT 
            r1.nama_pelanggan,
            r1.komentar,
            r1.rating,
            r1.waktu_review,
            GROUP_CONCAT(p.nama_produk SEPARATOR ', ') AS produk_direview
        FROM tb_review r1
        LEFT JOIN tb_produk p ON r1.id = p.id
        INNER JOIN (
            SELECT nama_pelanggan, MAX(waktu_review) AS last_review
            FROM tb_review
            GROUP BY nama_pelanggan
        ) r2 ON r1.nama_pelanggan = r2.nama_pelanggan 
            AND r1.waktu_review = r2.last_review
        GROUP BY 
            r1.nama_pelanggan, r1.komentar, r1.rating, r1.waktu_review
        ORDER BY r1.waktu_review DESC
      ";

      $result_ulasan = mysqli_query($koneksi, $query_ulasan);

      if (mysqli_num_rows($result_ulasan) > 0):
          while ($ulasan = mysqli_fetch_assoc($result_ulasan)):
          $initial = strtoupper(substr($ulasan['nama_pelanggan'], 0, 1));
      ?>

      <div class="ulasan-item">
        <div class="customer-info">
          <div class="customer-avatar"><?= $initial ?></div>
          <div class="customer-detail">
            <h4><?= htmlspecialchars($ulasan['nama_pelanggan']) ?></h4>
            <div class="produk"><?= htmlspecialchars($ulasan['produk_direview']) ?></div>
          </div>
        </div>

        <div class="rating">
          <?php
          $rating = (int)$ulasan['rating'];
          for ($i = 1; $i <= 5; $i++):
            echo $i <= $rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
          endfor;
          ?>
        </div>

        <p class="komentar"><?= htmlspecialchars($ulasan['komentar']) ?></p>

        <div class="review-footer">
          <span class="review-date">
            <i class="far fa-clock"></i> 
            <?= date('d M Y, H:i', strtotime($ulasan['waktu_review'])) ?>
          </span>
        </div>
      </div>

      <?php endwhile; else: ?>

      <p class="no-review">Belum ada ulasan pelanggan.</p>

      <?php endif; ?>
    </div>
  </section>

</body>
</html>
