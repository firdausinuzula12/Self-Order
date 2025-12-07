<?php
    session_start();

?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- HEADER -->
<header>
  <div class="navbar-container">
    <!-- Logo -->
    <div class="logo">
      <img src="../user/img/logo_toko.png" alt="Logo Toko">
      <span>The Cakery</span>
    </div>

    <!-- Menu kanan -->
    <nav class="menu-kanan">
      <a href="index.php" class="nav-link">
        Transaksi
      </a>
      <a href="../laporan.php" class="nav-link">
        Laporan
      </a>

      <!-- Profil Dropdown -->
      <div class="profile-menu">
        <button class="profile-icon">
          <i class="fa-solid fa-user-circle"></i>
        </button>
        <div class="dropdown" id="profileDropdown">
          <a href="../index.php">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
          </a>
        </div>
      </div>
    </nav>
  </div>
</header>

<style>
/* --- Gaya Header --- */
  header {
      background-color: #AC1754;
      display: flex;
      align-items: center;
      padding: 8px 0;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  }

/* Wrapper */
  .navbar-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 95%;
      margin: 0 auto;
  }

/* Logo */
  .logo {
      display: flex;
      align-items: ce nter;
  }
  .logo img {
      width: 70px;
        margin-right: 12px;
  }
  .logo span {
      font-family: 'Poppins Semibold';
      font-size: 33px;
      font-weight: bold;
      color: white;
  }

  .menu-kanan {
      font-family: 'Poppins Semibold';
      display: flex;
      align-items: center;
      gap: 25px;
  }

  .menu-kanan .nav-link {
      color: white;
      font-weight: 600;
      text-decoration: none;
      font-size: 18px;
      transition: 0.3s;
      display: flex;
      align-items: center;
      gap: 6px;
  }

  .menu-kanan .nav-link:hover {
      color: #fbd5e5;
  }

/* --- Dropdown Profil --- */
  .profile-menu {
      position: relative;
      cursor: pointer;
  }

  .profile-icon {
      font-size: 22px;
      color: white;
      background: none;
      border: none;
      outline: none;
      cursor: pointer;
  }

  .dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 40px;
      background: white;
      color: #333;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      min-width: 150px;
      animation: fadeIn 0.2s ease;
  }

  .dropdown a {
      display: block;
      padding: 10px 15px;
      text-decoration: none;
      color: #333;
      font-weight: 500;
      font-size: 14px;
      transition: 0.3s;
  }

  .dropdown a:hover {
      background: #fbd5e5;
      color: #ac1754;
  }

  @keyframes fadeIn {
      from {
          opacity: 0;
          transform: translateY(-5px);
      }
      to {
          opacity: 1;
          transform: translateY(0);
      }
  }
</style>

<script>
// Toggle dropdown
const profileMenu = document.querySelector(".profile-menu");
const dropdown = document.getElementById("profileDropdown");

profileMenu.addEventListener("click", () => {
  dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
});

// Tutup dropdown saat klik di luar area
document.addEventListener("click", (e) => {
  if (!profileMenu.contains(e.target)) {
    dropdown.style.display = "none";
  }
});
</script>
