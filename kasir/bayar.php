<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $koneksi->real_escape_string($_GET['id']);
    $query = $koneksi->query("SELECT * FROM tb_pesanan WHERE id_pesanan='$id'");
    $pesanan = $query->fetch_assoc();

    if ($pesanan) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jumlah_uang = $_POST['jumlah_uang'];
            $total_harga = $pesanan['total_harga'];
            $metode_pembayaran = $pesanan['metode_pembayaran'];

            if ($jumlah_uang >= $total_harga) {
                $kembalian = $jumlah_uang - $total_harga;
                $status_pembayaran = 'Lunas';

                $sql_insert = "INSERT INTO tb_pembayaran 
                    (id_pesanan, metode_pembayaran, jumlah_bayar, kembalian, status_pembayaran, tanggal_pembayaran)
                    VALUES 
                    ('$id', '$metode_pembayaran', '$jumlah_uang', '$kembalian', '$status_pembayaran', NOW())";

                if ($koneksi->query($sql_insert)) {
                    // update status pesanan jadi Selesai
                    $koneksi->query("UPDATE tb_pesanan SET status_pesanan='Selesai' WHERE id_pesanan='$id'");
                    header("Location: nota.php?id=$id");
                    exit();
                } else {
                    $error = "Gagal menyimpan data pembayaran: " . $koneksi->error;
                }
            } else {
                $error = "Jumlah uang kurang dari total harga!";
            }
        }
    } else {
        echo "<p>Pesanan tidak ditemukan.</p>";
        exit();
    }
} else {
    echo "<p>ID pesanan tidak ditemukan.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bayar Pesanan</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 0;
    }
    header {
    background-color: #AC1754;
    color: white;
    padding: 10px 20px;
    display: flex;
    align-items: center;
}
header a img {
    width: 35px;
    height: 35px;
    cursor: pointer;
}
    .container {
      width: 400px;
      margin: 80px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    h2 {
      color: #AC1754;
      margin-bottom: 20px;
    }
    p {
      font-size: 15px;
      margin: 6px 0;
    }
    label {
      display: block;
      margin-top: 20px;
      font-weight: bold;
    }
    input[type=number] {
      width: 100%;
      padding: 10px;
      margin-top: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
    }
    .readonly {
      background: #f0f0f0;
      color: #555;
    }
    input[type=submit] {
      width: 100%;
      margin-top: 25px;
      padding: 12px;
      border: none;
      background: #AC1754;
      color: white;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }
    input[type=submit]:hover {
      background: #8c1444;
    }
    .error {
      background: #ffe5e5;
      color: #d00;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <header> 
    <a href="">
    <img src="../user/img/back-icon.png" alt="Kembali">
    </a>
  </header>
<div class="container">
  <h2>Pembayaran Tunai</h2>

  <p><strong>Nama:</strong> <?= htmlspecialchars($pesanan['nama_pelanggan']) ?></p>
  <p><strong>Total Harga:</strong> Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></p>

  <?php if (!empty($error)): ?>
      <div class="error"><?= $error ?></div>
  <?php endif; ?>

  <form action="bayar.php?id=<?= urlencode($pesanan['id_pesanan']) ?>" method="post">
    <label>Jumlah Uang (Rp)</label>
    <input type="number" id="jumlah_uang" name="jumlah_uang" required min="<?= $pesanan['total_harga'] ?>" placeholder="Masukkan nominal pembayaran">

    <label>Kembalian (Rp)</label>
    <input type="number" id="kembalian" class="readonly" readonly>

    <input type="submit" value="Proses Pembayaran">
  </form>
</div>

<script>
const totalHarga = <?= $pesanan['total_harga'] ?>;
const inputUang = document.getElementById('jumlah_uang');
const inputKembalian = document.getElementById('kembalian');

inputUang.addEventListener('input', function() {
    const jumlah = parseFloat(this.value);
    if (jumlah >= totalHarga) {
        inputKembalian.value = (jumlah - totalHarga).toLocaleString('id-ID');
    } else {
        inputKembalian.value = '';
    }
});
</script>
</body>
</html>
