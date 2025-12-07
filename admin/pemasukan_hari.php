<?php
session_start();
include 'koneksi.php';

$role = $_SESSION['role'] ?? 'kasir';
$tanggal = $_GET['tanggal_pembayaran'] ?? '';

// Hitung pemasukan, penarikan, saldo
$qPemasukan = mysqli_query($koneksi, "SELECT SUM(total_harga) AS total_pemasukan FROM tb_pesanan");
$dataPemasukan = mysqli_fetch_assoc($qPemasukan)['total_pemasukan'] ?? 0;

$qPenarikan = mysqli_query($koneksi, "SELECT SUM(jumlah_penarikan) AS total_penarikan FROM tb_penarikan");
$dataPenarikan = mysqli_fetch_assoc($qPenarikan)['total_penarikan'] ?? 0;

$saldoKas = $dataPemasukan - $dataPenarikan;

// Query pemasukan harian
if ($tanggal != '') {
    $query = "SELECT DATE(tanggal_pembayaran) AS tanggal, SUM(jumlah_bayar - kembalian) AS total_harian
              FROM tb_pembayaran
              WHERE DATE(tanggal_pembayaran) = '$tanggal'
              GROUP BY DATE(tanggal_pembayaran)
              ORDER BY tanggal DESC";
} else {    
    $query = "SELECT DATE(tanggal_pembayaran) AS tanggal, SUM(jumlah_bayar - kembalian) AS total_harian
              FROM tb_pembayaran
              GROUP BY DATE(tanggal_pembayaran)
              ORDER BY tanggal DESC";
        }

$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pemasukan Harian</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    body {  
    font-family: 'Inter', sans-serif;
    background-color: #f8f8f8;
    margin: 0;
    }

    header {
        position: fixed;
        top:0;
        width:100%;
        background-color: #AC1754;
        color:white;
        padding: 15px 20px;
        display:flex;
        align-items:center;
        justify-content: space-between;
        z-index:1000;
    }

    header a img {
        width: 35px;
        height: 35px;
        cursor: pointer;
    }

    header h1 {
        position: center;
        margin:20;
        font-size: 20px;
        text-align:center;
    }

    .container {
        max-width: 1000px;
        margin: 90px auto;
        text-align: center;
        padding: 0 20px;
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 13px;
        margin: 10px 0;
    }

    .card {
    background: white;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .card h3 { 
        margin: 0 0 10px 0; 
        color: #666; 
        font-size: 14px; 
    }
    .card p { 
        margin: 0; 
        font-size: 24px; 
        font-weight: bold; 
    }
    .card.pemasukan p { 
        color: #27ae60; 
    }
    .card.penarikan p { 
        color: #e74c3c; 
    }
    .card.saldo p { 
        color: #3498db; 
    }

    .filter-box {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    input[type=date] {
        padding: 10px;
        border: 2px solid #ddd;
        border-radius: 5px;
    }

    button {
        background-color: #AC1754;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 3px;
        cursor: pointer;
        margin: 4px;
    }
    button:hover { 
        background:#921347; 
    }

    .table-container {
        padding: 20px;
        background:white;
        border-radius:10px;
        box-shadow: 0 3px 10px rgba(172, 23, 84, 0.1);
    }

table { width:100%; border-collapse:collapse; }
    th {
        background:#AC1754;
        color:white;
        padding:12px;
    }
    td { 
        padding:12px; 
        border-bottom: 1px solid #eee; 
    }
    tr:hover { 
        background:#fef2f7; 
        }
</style>
</head>

<body>

<header>
    <div style="display:flex; align-items:center; gap:15px;">
        <a href="dashboard_admin.php"><img src="../user/img/back-icon.png"></a>
       
    </div>

</header>

<div class="container">

<!-- SUMMARY CARDS -->
<div class="summary-cards">
    <div class="card pemasukan">
        <h3>Total Pemasukan</h3>
        <p>Rp <?= number_format($dataPemasukan,0,',','.'); ?></p>
    </div>
    <div class="card penarikan">
        <h3>Total Penarikan</h3>
        <p>- Rp <?= number_format($dataPenarikan,0,',','.'); ?></p>
    </div>
    <div class="card saldo">
        <h3>Saldo Kas Toko</h3>
        <p>Rp <?= number_format($saldoKas,0,',','.'); ?></p>
    </div>
</div>

<!-- FILTER + BUTTON ADMIN DI SAMPINGNYA -->
<form method="GET" class="filter-box" style="display:flex; flex-wrap:wrap; align-items:center; gap:10px; justify-content:center;">
    
    <label><b><i class="fas fa-calendar"></i> Pilih Tanggal:</b></label>
    <input type="date" name="tanggal_pembayaran" value="<?= $tanggal ?>">

    <button type="submit"><i class="fas fa-search"></i> Tampilkan</button>

    <a href="pemasukan_hari.php"><button type="button"><i class="fas fa-redo"></i> Reset</button></a>

    <?php if ($role == 'admin'): ?>
        <a href="penarikan_modal.php"><button type="button"><i class="fas fa-money-bill-wave"></i> Tarik Modal</button></a>
        <a href="history_penarikan.php"><button type="button"><i class="fas fa-history"></i> History Penarikan</button></a>
    <?php endif; ?>

</form>

<!-- TABLE -->
<div class="table-container">

<table>
<thead>
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Total Pemasukan (Rp)</th>
</tr>
</thead>
<tbody>

<?php 
if ($result->num_rows > 0):
    $no=1;
    while($row = $result->fetch_assoc()):
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
    <td style="color:green; font-weight:bold;">Rp <?= number_format($row['total_harian'],0,',','.'); ?></td>
</tr>
<?php endwhile; else: ?>
<tr><td colspan="3">Tidak ada data pemasukan</td></tr>
<?php endif; ?>

</tbody>
</table>
</div>

</div>
</body>
</html>
