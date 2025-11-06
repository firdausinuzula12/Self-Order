<?php
include '../koneksi.php'; // pastikan path sesuai struktur foldermu

$id_pesanan = $_GET['id_pesanan'] ?? null;
$rating     = isset($_POST['rating']) && $_POST['rating'] !== '' ? (int)$_POST['rating'] : 0;
$komentar   = $_POST['komentar'] ?? '';
$berhasil   = false;

if ($id_pesanan && $rating > 0) {
    // Cek apakah review untuk pesanan ini sudah ada
    $cek = $koneksi->prepare("SELECT id_review FROM tb_review WHERE id_pesanan = ?");
    $cek->bind_param("s", $id_pesanan);
    $cek->execute();
    $hasil = $cek->get_result();

    if ($hasil->num_rows > 0) {
        // Update review yang sudah ada
        $sql = $koneksi->prepare("UPDATE tb_review 
            SET rating = ?, komentar = ?, waktu_review = NOW() 
            WHERE id_pesanan = ?");
        $sql->bind_param("iss", $rating, $komentar, $id_pesanan);
    } else {
        // Insert review baru
        $sql = $koneksi->prepare("INSERT INTO tb_review 
            (id_pesanan, rating, komentar, waktu_review) 
            VALUES (?, ?, ?, NOW())");
        $sql->bind_param("sis", $id_pesanan, $rating, $komentar);
    }

    if ($sql->execute()) {
        $berhasil = true;
    } else {
        echo "<p style='color:red'>Gagal menyimpan review: " . htmlspecialchars($sql->error) . "</p>";
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
    background: linear-gradient(135deg, #fff8fb, #ffeaf2);
    text-align: center;
    padding-top: 120px;
    margin: 0;
}

.card {
    display: inline-block;
    background: white;
    border-radius: 18px;
    padding: 50px 70px;
    box-shadow: 0 6px 25px rgba(0,0,0,0.1);
    animation: muncul 0.6s ease-out;
}

@keyframes muncul {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

h2 {
    color: #a01646;
    margin-bottom: 10px;
}

p {
    color: #444;
    margin: 5px 0 20px;
}

a {
    display:inline-block;
    padding:10px 25px;
    background:linear-gradient(90deg,#a01646,#d45077);
    color:white;
    border-radius:25px;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}
a:hover { background:linear-gradient(90deg,#7a1035,#bf4068); }

small { color:#777; font-size: 13px; display:block; margin-top:10px; }
</style>
</head>
<body>

<div class="card">
    <?php if ($berhasil): ?>
        <h2>Terima kasih atas ulasan Anda!</h2>
        <p>Review Anda telah berhasil disimpan.</p>
        <small>ID Pesanan: <?= htmlspecialchars($id_pesanan); ?></small>
    <?php else: ?>
        <h2>Gagal Menyimpan Review</h2>
        <p>Pastikan Anda memberikan rating dan komentar dengan benar.</p>
        <?php if ($id_pesanan): ?>
            <small>ID Pesanan: <?= htmlspecialchars($id_pesanan); ?></small>
        <?php endif; ?>
    <?php endif; ?>

    <a href="#" onclick="tutupHalaman()">Tutup Halaman</a>
</div>

<script>
function tutupHalaman() {
    window.close();
    setTimeout(() => {
        document.querySelector('.card').innerHTML = `
            <h2>✅ Review Tersimpan!</h2>
            <p>Anda dapat menutup halaman ini secara manual.</p>
        `;
    }, 500);
}
setTimeout(tutupHalaman, 3000);
</script>

</body>
</html>
