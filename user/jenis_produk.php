<?php
include 'koneksi.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Cakery</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: #FFEDFA;
      color: #333;
      padding-top: 27px;
      overflow-x: hidden;
    }

    .quick-categories {
      margin-top:80px;
      padding: 60px 20px;
      background-color: #FFEDFA;
    }

    .categories-container {
      max-width: 1000px;
      margin: 0 auto;
      text-align: center;
    }

    .categories-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 35px;
      margin-top: 60px;
    }

    .category-item {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      padding: 20px;
      transition: all 0.3s ease;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .category-item:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(172, 23, 84, 0.2);
    }

    .category-item::before {
      content: "";
      position: absolute;
      top: -30px;
      right: -30px;
      width: 80px;
      height: 80px;
      background: rgba(255, 192, 203, 0.4);
      border-radius: 50%;
      transition: all 0.3s ease;
    }

    .category-item:hover::before {
      transform: scale(1.2);
      background: rgba(172, 23, 84, 0.3);
    }

    .category-image {
      width: 100%;
      height: 110px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 15px;
    }

    .category-image img {
      width: 85px;
      height: 85px;
      object-fit: contain;
      border-radius: 12px;
      transition: transform 0.3s ease;
    }

    .category-item:hover img {
      transform: scale(1.08);
    }

    .category-item h3 {
      font-size: 1.05rem;
      color: #333;
      font-weight: 600;
      margin: 0;
    }

    .category-item:hover h3 {
      color: #AC1754;
    }

    @media (max-width: 768px) {
      .categories-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
      }

      .category-image img {
        width: 70px;
        height: 70px;
      }
    }

    @media (max-width: 480px) {
      .categories-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
      }
    }
  </style>
</head>

<body>
  <section class="quick-categories">
    <div class="categories-container">
      <div class="categories-grid">
        <div class="category-item">
          <a href="kategori_produk.php?kategori=cake">
            <div class="category-image">
              <img src="img/cake.png" alt="Kue">
            </div>
            <h3>Kue</h3>
          </a>
        </div>

        <div class="category-item">
          <a href="kategori_produk.php?kategori=Cookies">
            <div class="category-image">
              <img src="img/cookies.png" alt="Kukis">
            </div>
            <h3>Kukis</h3>
          </a>
        </div>

        <div class="category-item">
          <a href="kategori_produk.php?kategori=Donut">
            <div class="category-image">
              <img src="img/donut.png" alt="Donat">
            </div>
            <h3>Donat</h3>
          </a>
        </div>

        <div class="category-item">
          <a href="kategori_produk.php?kategori=Pastry">
            <div class="category-image">
              <img src="img/pastry.png" alt="Pastry">
            </div>
            <h3>Pastry</h3>
          </a>
        </div>

        <div class="category-item">
          <a href="kategori_produk.php?kategori=Roti">
            <div class="category-image">
              <img src="img/bread.png" alt="Roti">
            </div>
            <h3>Roti</h3>
          </a>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
