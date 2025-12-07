<?php
session_start();
include 'koneksi.php';

// Cek akses admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard_kasir.php");
    exit;
}

// Hitung saldo kas
$qSaldo = mysqli_query($koneksi, "
    SELECT 
        COALESCE((SELECT SUM(total_harga) FROM tb_pesanan), 0) - 
        COALESCE((SELECT SUM(jumlah_penarikan) FROM tb_penarikan), 0) AS saldo
");
$saldoTersedia = mysqli_fetch_assoc($qSaldo)['saldo'];

// Proses
if(isset($_POST['tarik'])) {
    $jumlah = $_POST['jumlah_penarikan'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $id = $_SESSION['id'];

    if($jumlah <= 0) {
        echo "<script>alert('Jumlah penarikan harus lebih dari 0!');</script>";
    } elseif($jumlah > $saldoTersedia) {
        echo "<script>alert('Saldo tidak mencukupi! Saldo: Rp " . number_format($saldoTersedia,0,',','.') . "');</script>";
    } else {
        $insert = mysqli_query($koneksi, "
            INSERT INTO tb_penarikan (jumlah_penarikan, keterangan, id)
            VALUES ('$jumlah', '$keterangan', '$id')
        ");

        if($insert) {
            echo "<script>alert('Penarikan berhasil!'); window.location='pemasukan_hari.php';</script>";
        } else {
            echo "<script>alert('Gagal melakukan penarikan.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Penarikan Modal</title>
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
    padding: 20px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    }
    header .left {
        position: absolute;
        left: 20px;
    }
    header img {
        width: 32px;
        cursor: pointer;
    }
    header h2 {
        color: white;
        margin: 0;
        font-size: 27px;
        text-align: center;
    }

/* ================= CONTAINER ================= */
    .container {
        max-width: 600px;
        margin: 84px auto;
        background: white;
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    h1 {
        color: #AC1754;
        text-align: center;
        margin-bottom: 25px;
    }

/* Saldo info */
    .saldo-info {
        background: #eaf7ee;
        border-left: 4px solid #27ae60;
        padding: 15px;
        margin-bottom: 25px;
        border-radius: 5px;
    }
    .saldo-info h3 {
        margin: 0 0 5px 0;
        color: #27ae60;
        font-size: 14px;
    }
    .saldo-info p {
    margin: 0;
    font-size: 24px;
    font-weight: bold;
    color: #27ae60;
    }

/* Warning */
    .warning {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

/* Form */
    label {
        font-weight: 500;
        margin-bottom: 5px;
        display: block;
    }
    input[type=number], textarea {
        width: 95%;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    input:focus, textarea:focus {
        border-color: #AC1754;
    }
    textarea {
        min-height: 100px;
        resize: vertical;
    }

/* BUTTON SENADA */
    button {
        width: 100%;
        background-color: #AC1754;
        color: white;
        border: none;
        padding: 15px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
    }
    button:hover {
        background-color: #921347;
    }
</style>
</head>
<body>

<header>
    <div class="left">
        <a href="pemasukan_hari.php"><img src="../user/img/back-icon.png" alt="Back"></a>
    </div>
    <h2>Penarikan Modal</h2>
</header>

<div class="container">
    <h1><i class="fas fa-money-bill-wave"></i> Penarikan Modal</h1>
    <div class="saldo-info">
        <h3>Saldo Kas Tersedia</h3>
        <p>Rp <?= number_format($saldoTersedia,0,',','.'); ?></p>
    </div>
    <div class="warning">
        <i class="fas fa-exclamation-circle"></i> Penarikan akan mengurangi saldo kas toko.
    </div>
    <form method="POST">
        <div class="form-group">
            <label>Jumlah Penarikan</label>
            <input type="number" name="jumlah_penarikan" required min="1" max="<?= $saldoTersedia ?>">
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" required></textarea>
        </div>
        <button type="submit" name="tarik"><i class="fas fa-check-circle"></i> Proses Penarikan</button>
    </form>
</div>
</body>
</html>
