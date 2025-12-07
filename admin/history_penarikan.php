<?php
session_start();
include 'koneksi.php';

// Cek akses admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard_kasir.php");
    exit;
}

// Query untuk mengambil history penarikan

$query = "SELECT p.*, a.username 
          FROM tb_penarikan p
          LEFT JOIN tb_admin a ON p.id = a.id
          ORDER BY p.tanggal_penarikan DESC";
$result = mysqli_query($koneksi, $query);

// Total penarikan
$qTotal = mysqli_query($koneksi, "SELECT SUM(jumlah_penarikan) AS total FROM tb_penarikan");
$totalPenarikan = mysqli_fetch_assoc($qTotal)['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>History Penarikan Modal</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style> 
    body {  
    font-family: 'Inter', sans-serif;
    background-color: #f8f8f8;
    margin: 0;
    padding: 0;
    }
    header {
        position: fixed;
        top:0;
        width:100%;
        background-color: #AC1754;
        color:white;
        padding: 20px 20px;
        display:flex;
        align-items:center;
        justify-content: center;
        z-index:1000;
    }
    header a {
        position: absolute;
        left: 20px;
    }
    header a img {
        width: 35px;
        height: 35px;
        cursor: pointer;
    }
    header h2 {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 23px;
        color: white;
    }
    .container {
        max-width: 1100px;
        margin: 90px auto;
        padding: 0 20px;
    }
    h1 {
        color: #AC1754;
        text-align: center;
        margin-bottom: 30px;
    }
    .total-box {
        width: 200px;
        background: #e74c3c;
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
    }
    .total-box h3 { 
    margin: 0 0 10px 0;
    font-size: 14px;
    opacity: 0.9;
    font-weight: normal;
    }
    .total-box p {  
    margin: 0;
    font-size: 24px;
    font-weight: bold;
    }
    .table-container {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        overflow-x: auto;
        flex: 1;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        background-color: #AC1754;
        color: white;
        padding: 12px;
        font-weight: 600;
        text-align: left;
    }
    td {
        border-bottom: 1px solid #eee;
        padding: 12px;
    }
    tr:hover {
        background-color: #fef2f7;
}
    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }
    .badge-danger {
        background: #ffebee;
        color: #e74c3c;
    }
</style>
</head>
<body>

<header>
<a href="pemasukan_hari.php">
    <img src="../user/img/back-icon.png" alt="Kembali">
</a>
<h2>History Penarikan Modal</h2>
</header>   

<div class="container">
    
    <div class="content-wrapper">
        <!-- Total Penarikan -->
        <div class="total-box">
            <h3>Total Semua Penarikan</h3>
            <p>Rp <?= number_format($totalPenarikan, 0, ',', '.'); ?></p>
        </div>
        
        <!-- Table History -->
        <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal & Waktu</th>
                    <th>Jumlah Ditarik</th>
                    <th>Keterangan</th>
                    <th>Ditarik Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)): 
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date('d-m-Y H:i:s', strtotime($row['tanggal_penarikan'])); ?></td>
                    <td>
                        <span class="badge badge-danger">
                            <i class="fas fa-minus-circle"></i> 
                            Rp <?= number_format($row['jumlah_penarikan'], 0, ',', '.'); ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($row['keterangan']); ?></td>
                    <td>
                        <i class="fas fa-user"></i> 
                        <?= htmlspecialchars($row['username'] ?? 'Tidak diketahui'); ?>
                    </td>

                </tr>
                <?php 
                    endwhile;
                } else {
                    echo "<tr><td colspan='5' style='text-align:center; color:#999;'>
                            <i class='fas fa-inbox'></i> Belum ada penarikan modal
                          </td></tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
</body>
</html>