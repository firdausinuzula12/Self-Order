<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Hitung jumlah produk di keranjang
$jumlah_keranjang = 0;
if (isset($_SESSION['keranjang']) && is_array($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        $jumlah_keranjang += isset($item['jumlah']) ? $item['jumlah'] : 1;
    }
}
?>

<!-- Link Font Awesome (untuk ikon) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Navbar -->
<header>
  <div class="navbar-container">
    <div class="logo">
      <img src="img/logo_toko.png" alt="Logo Toko">
      <span>The Cakery</span>
    </div>
     <div id="cart">
        <a href="keranjang.php">
          <i class="fas fa-shopping-cart"></i>
          <span><?= $jumlah_keranjang ?></span>
        </a>
      </div>
    </div>
  </div>
</header>

<style>

header {
    background-color: #AC1754; /**warna back */
    display: flex; /**mengatur bagian element yang ditampilkan */
    align-items: center;
    padding-top: 0px;/**mengatur ruang di dalam element */
    position: fixed; /**mengatur posisi element */
    top: 0; /**menentukan jarak element dari atas */
    left: 0; /**menentukan jarak element dari kiri */
    width: 100%; /**menentukan lebar element */
    z-index: 1000; /**mengatyr urutam tumpukan element */
}

header .logo {
    display: flex;
    align-items: center;
    margin-right: 1px;
}

.logo span {
    font-size: 30px;
    font-weight: bold;
    color: white;
    font-family: 'Verdana', sans-serif;
}

header .logo img {
    margin-right: 25px;
    height: auto;
    width: 80px;
}

/* Header wrapper */
.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 95%;
    padding: 0.5px 35px;
}

/* Logo */
.logo {
    display: flex;
    align-items: center;
}
.logo img {
    width: 80px;
    margin-right: 10px;
}
.logo span {
    font-family: 'Pacifico', 'cursive';
    font-size: 30px;
    font-weight: bold;
    color: white;
}


/* Cart */
#cart {
    left: 50px;
    position: relative;
}
#cart i {
    font-size: 20px;
    color: white;
}
#cart span {
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 1px 5px;
    font-size: 13px;
    font-weight: bold;
    position: absolute;
    top: -9px;
}

</style>
