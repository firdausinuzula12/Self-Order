<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - The Cakery</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins Semibold';
    }

    body {
      background-color: #f8f9fa;
      padding-top: 7px;
    }

    /* ===== HEADER ===== */
    header {
      position: fixed;
      display: flex;
      padding:1px 0;
      align-items:center;
      top: 0;
      left: 0;
      width: 100%;
      background: #AC1754 ;
      z-index: 1000;
      box-shadow: 0 4px 20px rgba(172, 23, 84, 0.15);
    }

    .navbar-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 2rem;
      height: 76px;
    }

    /* ===== LOGO ===== */
    .logo {
      display: flex;
      align-items: center;
      gap: 14px;
      text-decoration: none;
      transition: transform 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.02);
    }

    .logo img {
      width: 56px;
      height: 56px;
      object-fit: contain;
      filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.15));
    }

    .logo-text {
      font-family: 'Poppins', sans-serif;
      font-size: 26px;
      font-weight: 700;
      color: white;
      letter-spacing: -0.5px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* ===== NAVIGATION ===== */
    .menu-kanan {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .nav-link {
      position: relative;
      color: rgba(255, 255, 255, 0.9);
      text-decoration: none;
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
      font-weight: 500;
      padding: 10px 18px;
      border-radius: 8px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .nav-link i {
      font-size: 16px;
      transition: transform 0.3s ease;
    }

    .nav-link:hover {
      color: #ffffff;
      background: rgba(255, 255, 255, 0.15);
    }

    .nav-link:hover i {
      transform: translateY(-2px);
    }

    .nav-link.active {
      background: rgba(255, 255, 255, 0.2);
      color: #ffffff;
      font-weight: 600;
      box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* ===== PROFILE DROPDOWN ===== */
    .profile-menu {
      position: relative;
      margin-left: 8px;
    }

    .profile-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      font-size: 20px;
      color: white;
      background: rgba(255, 255, 255, 0.15);
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      outline: none;
    }

    .profile-icon:hover {
      background: rgba(255, 255, 255, 0.25);
      border-color: rgba(255, 255, 255, 0.5);
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .profile-icon.active {
      background: rgba(255, 255, 255, 0.3);
      border-color: rgba(255, 255, 255, 0.6);
    }

    .dropdown {
      position: absolute;
      right: 0;
      top: 52px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      min-width: 180px;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .dropdown.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .dropdown::before {
      content: '';
      position: absolute;
      top: -6px;
      right: 12px;
      width: 12px;
      height: 12px;
      background: white;
      transform: rotate(45deg);
      border-left: 1px solid rgba(0, 0, 0, 0.05);
      border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .dropdown a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 18px;
      text-decoration: none;
      color: #333;
      font-family: 'Inter', sans-serif;
      font-weight: 500;
      font-size: 14px;
      transition: all 0.2s ease;
      border-left: 3px solid transparent;
    }

    .dropdown a:hover {
      background: #fff0f6;
      color: #AC1754;
      border-left-color: #AC1754;
      padding-left: 22px;
    }

    .dropdown a i {
      font-size: 16px;
      width: 20px;
      text-align: center;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 968px) {
      .navbar-container {
        padding: 0 1.5rem;
        height: auto;
        min-height: 76px;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 12px;
        padding-bottom: 12px;
      }

      .logo {
        flex: 1;
      }

      .menu-kanan {
        width: 100%;
        justify-content: space-between;
        order: 3;
        padding-top: 8px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
      }

      .nav-link {
        font-size: 13px;
        padding: 8px 12px;
      }

      .nav-link i {
        font-size: 14px;
      }

      body {
        padding-top: 130px;
      }
    }

    @media (max-width: 568px) {
      .logo-text {
        font-size: 22px;
      }

      .logo img {
        width: 48px;
        height: 48px;
      }

      .nav-link {
        font-size: 12px;
        padding: 7px 10px;
        gap: 6px;
      }

      .nav-link i {
        display: none;
      }

      .profile-icon {
        width: 36px;
        height: 36px;
        font-size: 18px;
      }
    }
  </style>
</head>

<body>
  <!-- HEADER -->
  <header>
    <div class="navbar-container">
      <!-- Logo -->
      <a href="dashboard_admin.php" class="logo">
        <img src="img/logo_toko.png" alt="Logo The Cakery">
        <span class="logo-text">The Cakery</span>
      </a>

      <!-- Menu Kanan -->
      <nav class="menu-kanan">
        <a href="dashboard_admin.php" class="nav-link">
          <i class="fa-solid fa-chart-line"></i>
          Dashboard
        </a>
        <a href="tambah_produk.php" class="nav-link">
          <i class="fa-solid fa-plus-circle"></i>
          Tambah Produk
        </a>
        <a href="../laporan.php" class="nav-link">
          <i class="fa-solid fa-file-chart"></i>
          Laporan
        </a>

        <!-- Profil Dropdown -->
        <div class="profile-menu">
          <button class="profile-icon" id="profileBtn" aria-label="Profile Menu">
            <i class="fa-solid fa-user-circle"></i>
          </button>
          <div class="dropdown" id="profileDropdown">
            <a href="../logout.php">
              <i class="fa-solid fa-right-from-bracket"></i>
              Logout
            </a>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <script>
    // Profile dropdown toggle
    const profileBtn = document.getElementById('profileBtn');
    const dropdown = document.getElementById('profileDropdown');

    profileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      dropdown.classList.toggle('show');
      profileBtn.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!dropdown.contains(e.target) && !profileBtn.contains(e.target)) {
        dropdown.classList.remove('show');
        profileBtn.classList.remove('active');
      }
    });

    // Active menu highlighting
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
      const linkPage = link.getAttribute('href').split('/').pop();
      if (currentPage === linkPage) {
        link.classList.add('active');
      }
    });

    // Close dropdown on ESC key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        dropdown.classList.remove('show');
        profileBtn.classList.remove('active');
      }
    });
  </script>
</body>
</html>