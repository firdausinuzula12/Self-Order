<?php
session_start();
include 'koneksi.php';
include 'navbar.php';

// Ambil produk terlaris
$query_terlaris = "SELECT * FROM tb_produk ORDER BY stok ASC LIMIT 3";
$result_terlaris = mysqli_query($koneksi, $query_terlaris);

// Pencarian produk (jika ada)
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = "SELECT * FROM tb_produk";
if ($cari != '') {
    $query .= " WHERE nama_produk LIKE '%$cari%' OR deskripsi LIKE '%$cari%'";
}
$result = mysqli_query($koneksi, $query);

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
      font-family: 'Poppins', sans-serif;
      background-color: #FFEDFA;
      color: #333;
      line-height: 1.6;
      overflow-x: hidden;
      padding-top: 80px;
    }

    /* ===== HERO ===== */
    .hero {
      background: url('img/hero.jpg') no-repeat center center/cover;
      height: 500px;
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
    .hero h1 { font-size: 2.4rem; margin-bottom: 15px; }
    .hero p { font-size: 1.1rem; margin-bottom: 25px; opacity: 0.9; }
    .cta-btn {
      background-color: #AC1754;
      color: #fff;
      padding: 12px 28px;
      border-radius: 15px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-block;
    }
    .cta-btn:hover { background-color: #8d1345; transform: translateY(-4px); }

    /* ===== KATEGORI ===== */
    .kategori {
      padding: 70px 20px;
      background-color: #fff;
    }
    .kategori h2 {
      text-align: center;
      font-size: 2rem;
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
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 30px;
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
    .category-item:hover { transform: translateY(-6px); box-shadow: 0 8px 20px rgba(172,23,84,0.25); }
    .category-image img {
      width: 80px; height: 80px; object-fit: contain;
    }
    .category-item h3 { font-size: 1rem; margin-top: 10px; color: #333; }

    /* ===== PRODUK TERLARIS ===== */
    .produk-terlaris {
      padding: 80px 20px;
      background: linear-gradient(180deg, #FFF 0%, #FFEDF8 100%);
    }
    .produk-terlaris h2 {
      text-align: center;
      color: #AC1754;
      font-size: 2rem;
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
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      max-width: 1100px;
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
    .terlaris-image img {
      width: 100%; height: 200px; object-fit: cover;
    }
    .terlaris-info { text-align: center; padding: 18px; }
    .terlaris-info h3 { font-size: 1.1rem; color: #333; font-weight: 600; }

    /* ===== ULASAN PELANGGAN ===== */
    .ulasan-pelanggan {
      padding: 80px 20px;
      background-color: #FFF;
    }
    .ulasan-pelanggan h2 {
      text-align: center;
      color: #AC1754;
      font-size: 2rem;
      margin-bottom: 10px;
      font-weight: 700;
    }
    .ulasan-container {
      max-width: 900px;
      margin: 40px auto 0;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    .ulasan-item {
      background: #ffffff;
      border-radius: 14px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.08);
      padding: 16px 22px;
      transition: all 0.3s ease;
    }
    .ulasan-item:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 18px rgba(172, 23, 84, 0.15);
    }
    .ulasan-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 6px;
    }
    .ulasan-header strong { color: #AC1754; font-size: 1rem; }
    .ulasan-header .produk {
      font-size: 0.9rem; color: #555; font-style: italic;
    }
    .rating { color: #FFD700; margin-bottom: 4px; }
    .komentar {
      color: #333;
      font-size: 0.95rem;
      font-style: italic;
    }
    .no-review {
      text-align: center;
      color: #888;
      font-size: 1rem;
      margin-top: 20px;
    }
    small { color: #999; font-size: 0.8rem; }
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
      <div class="category-item"><a href="kategori_produk.php?kategori=Cake"><div class="category-image"><img src="img/cake.png"></div><h3>Kue</h3></a></div>
      <div class="category-item"><a href="kategori_produk.php?kategori=Cookies"><div class="category-image"><img src="img/cookies.png"></div><h3>Kukis</h3></a></div>
      <div class="category-item"><a href="kategori_produk.php?kategori=Donut"><div class="category-image"><img src="img/donut.png"></div><h3>Donat</h3></a></div>
      <div class="category-item"><a href="kategori_produk.php?kategori=Pastry"><div class="category-image"><img src="img/pastry.png"></div><h3>Pastry</h3></a></div>
      <div class="category-item"><a href="kategori_produk.php?kategori=Roti"><div class="category-image"><img src="img/bread.png"></div><h3>Roti</h3></a></div>
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

  <!-- ULASAN PELANGGAN -->
  <section id="ulasan-pelanggan" class="ulasan-pelanggan">
    <h2>Ulasan Pelanggan</h2>
    <p class="subtitle">Pendapat mereka tentang produk kami</p>
    <div class="ulasan-container">
      <?php
      $query_ulasan = "SELECT * FROM tb_review ORDER BY waktu_review DESC LIMIT 5";
      $result_ulasan = mysqli_query($koneksi, $query_ulasan);

      if (mysqli_num_rows($result_ulasan) > 0):
        while($ulasan = mysqli_fetch_assoc($result_ulasan)):
      ?>
        <div class="ulasan-item">
          <div class="ulasan-header">
            <strong><?= htmlspecialchars($ulasan['nama_pelanggan']) ?></strong>
            <span class="produk"><?= htmlspecialchars($ulasan['nama_produk']) ?></span>
          </div>
          <div class="rating">
            <?php
            $rating = (int)$ulasan['rating'];
            for ($i = 1; $i <= 5; $i++):
              echo $i <= $rating ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
            endfor;
            ?>
          </div>
          <p class="komentar">"<?= htmlspecialchars($ulasan['komentar']) ?>"</p>
          <small>🕒 <?= date('d M Y H:i', strtotime($ulasan['waktu_review'])) ?></small>
        </div>
      <?php endwhile; else: ?>
        <p class="no-review">Belum ada ulasan pelanggan.</p>
      <?php endif; ?>
    </div>
  </section>

</body>
</html>
