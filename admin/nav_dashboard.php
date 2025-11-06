<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin - The Cakery</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Verdana', sans-serif;
    }

    body {
      background-color: #ffedfa;
      padding-top: 9px;
    }

    /* ===== HEADER ===== */
    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: #AC1754;
      color: white;
      z-index: 1000;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 10px;
    }

    .navbar-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 95%;
      margin: 0 auto;
    }

    /* ===== BACK BUTTON ===== */
    .back-btn img {
      width: 35px;
      height: 35px;
      transition: transform 0.3s ease, filter 0.3s ease;
      cursor: pointer;
    }

    .back-btn img:hover {
      transform: scale(1.1);
      filter: brightness(1.2);
    }

    /* ===== NAVIGATION ===== */
    nav {
      display: flex;
      gap: 45px;
      align-items: center;
    }

    nav a {
      
      color: white;
      text-decoration: none;
      font-size: 16px;
      font-weight: 600;
      transition: 0.3s ease;
    }

    nav a:hover {
      color: #ffd8ea;
      border-bottom: 2px solid #ffd8ea;
      padding-bottom: 4px;
    }

    /* ===== MAIN ===== */
    main {
      margin-top: 20px; /* tinggi header */
      text-align: center;
      padding: 20px;
    }

    h1 {
      font-size: 32px;
      font-weight: 700;
      color: #000;
      margin-bottom: 40px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        padding: 10px 25px;
        gap: 12px;
      }

      .back-btn img {
        width: 30px;
        height: 32px;
      }

      nav {
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
      }

      nav a {
        font-size: 15px;
      }
    }
  </style>
</head>

<body>
  <header>

  <div class="navbar-container">
    <a href="index.php" class="back-btn">
      <img src="../user/img/back-icon.png" alt="Kembali">
    </a>

    <nav>
      <a href="users_admin.php">Users</a>
      <a href="laporan_bulanan.php">Laporan Bulanan</a>
      <a href="jam_sibuk.php">Jam Sibuk</a>
    </nav>

  </div>
  </header>

</body>
</html>
