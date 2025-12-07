<?php
include '../koneksi.php';

$id_pesanan = $_GET['id_pesanan'] ?? null;
$rating     = isset($_POST['rating']) && $_POST['rating'] !== '' ? (int)$_POST['rating'] : 0;
$komentar   = $_POST['komentar'] ?? '';
$berhasil   = true;

if ($id_pesanan && $rating > 0) {
    $cek = $koneksi->prepare("SELECT id_review FROM tb_review WHERE id_pesanan = ?");
    $cek->bind_param("s", $id_pesanan);
    $cek->execute();
    $hasil = $cek->get_result();

    if ($hasil->num_rows > 0) {
        $sql = $koneksi->prepare("
            UPDATE tb_review 
            SET rating = ?, komentar = ?, waktu_review = NOW()
            WHERE id_pesanan = ?
        ");
        $sql->bind_param("iss", $rating, $komentar, $id_pesanan);
    } else {
        $sql = $koneksi->prepare("
            INSERT INTO tb_review (id_pesanan, rating, komentar, waktu_review)
            VALUES (?, ?, ?, NOW())
        ");
        $sql->bind_param("sis", $id_pesanan, $rating, $komentar);
    }

    if (!$sql->execute()) {
        $berhasil = false;
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Review Selesai | The Cakery</title>
<style>

    body {
        font-family: 'Poppins', sans-serif;
        background: #faf6f8;
        margin: 0;
        padding-top: 100px;
        text-align: center;
    }

    .card {
        background: #ffffff;
        padding: 40px 55px;
        border-radius: 3px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.1);
        display: inline-block;
        animation: fadeIn 0.35s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h2 {
        font-weight: 600;
        color: #a01646;
        margin-bottom: 8px;
    }

    p {
        color: #444;
        font-size: 14px;
        margin-bottom: 18px;
    }

    small {
        font-size: 13px;
        color: #777;
    }

    button, a.btn {
        margin-top: 28px;
        padding: 10px 22px;
        background: linear-gradient(90deg, #a01646, #d45077);
        border-radius: 3px;
        color: #fff;
        text-decoration: none;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: 0.25s;
        display: inline-block;
    }

    button:hover, a.btn:hover {
        background: linear-gradient(90deg, #8b133e, #bf4068);
    }

</style>
</head>
<body>

<div class="card">

    <?php if ($berhasil): ?>
        <h2>Review Berhasil Disimpan</h2>
        <p>Terima kasih sudah memberikan ulasan untuk pesanan Anda.</p>
        <br>
    <?php else: ?>
        <h2>Review Gagal Disimpan</h2>
        <p>Pastikan rating dan komentar sudah diisi dengan benar.</p>
        <?php if ($id_pesanan): ?>
        <?php endif; ?>
        <br>
        <a href="javascript:history.back();" class="btn">Kembali</a>
    <?php endif; ?>
</div>
</body>
</html>
