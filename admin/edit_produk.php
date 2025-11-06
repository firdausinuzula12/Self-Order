<?php
include 'koneksi.php';

// Cek apakah ada ID produk
if (!isset($_GET['id'])) {
    echo "ID produk tidak ditemukan.";
    exit;
}

$id_produk = $_GET['id'];

// Ambil data produk lama
$query = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE id = '$id_produk'");
if (mysqli_num_rows($query) == 0) {
    echo "Produk tidak ditemukan.";
    exit;
}
$produk = mysqli_fetch_assoc($query);

// Proses update produk
if (isset($_POST['update'])) {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $gambar);

        $update = mysqli_query($koneksi, "UPDATE tb_produk SET 
            nama_produk='$nama_produk', 
            deskripsi='$deskripsi', 
            harga=$harga, 
            stok=$stok, 
            kategori='$kategori', 
            gambar='$gambar'
            WHERE id='$id_produk'");
    } else {
        $update = mysqli_query($koneksi, "UPDATE tb_produk SET 
            nama_produk='$nama_produk', 
            deskripsi='$deskripsi', 
            harga=$harga, 
            stok=$stok, 
            kategori='$kategori'
            WHERE id='$id_produk'");
    }

    if ($update) {
        echo "<script>alert('Produk berhasil diupdate!'); window.location.href='index.php';</script>";
    } else {
        echo "Gagal update produk.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Produk - The Cakery</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #FFEDFA 0%, #F8E8FF 100%);
    margin: 0;
    padding: 100px 20px 50px;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
}

.form-wrapper {
    display: flex;
    gap: 40px;
    background: #fff;
    padding: 35px;
    border-radius: 14px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    width: 100%;
    max-width: 900px;
    align-items: flex-start;
}

/* === FORM SECTION === */
.form-container {
    flex: 1;
}

h2 {
    text-align: center;
    color: #AC1754;
    margin-bottom: 25px;
    font-weight: 600;
}

label {
    display: block;
    margin-top: 14px;
    font-weight: 500;
    color: #AC1754;
    font-size: 14px;
}

input[type="text"],
input[type="number"],
textarea,
input[type="file"],
select {
    width: 100%;
    padding: 10px 12px;
    margin-top: 4px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    background-color: #fafafa;
    transition: 0.3s ease;
}

input:focus,
textarea:focus,
select:focus {
    outline: none;
    border-color: #AC1754;
    background-color: #fff;
    box-shadow: 0 0 4px rgba(172, 23, 84, 0.3);
}

textarea {
    resize: vertical;
}

button {
    margin-top: 25px;
    padding: 12px;
    background: linear-gradient(135deg, #AC1754, #D63384);
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    font-weight: 500;
    transition: background 0.3s ease, transform 0.2s ease;
}

button:hover {
    background: linear-gradient(135deg, #8d0f45, #b91c6a);
    transform: translateY(-2px);
}

/* === GAMBAR PREVIEW === */
.image-container {
    flex: 0.8;
    text-align: center;
}

.image-container img {
    margin-top: 100px;
    width: 100%;
    max-width: 300px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.image-container small {
    display: block;
    margin-top: 10px;
    color: #777;
    font-size: 13px;
}

/* === RESPONSIF === */
@media (max-width: 768px) {
    .form-wrapper {
        flex-direction: column;
        align-items: center;
        gap: 25px;
        padding: 25px 20px;
    }
    .image-container img {
        max-width: 220px;
    }
}
</style>
</head>
<body>
<?php include 'navmenu.php'; ?>

<div class="form-wrapper">
    <div class="form-container">
        <h2>Edit Produk</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" value="<?php echo htmlspecialchars($produk['nama_produk']); ?>" required>

            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" required><?php echo htmlspecialchars($produk['deskripsi']); ?></textarea>

            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" value="<?php echo $produk['harga']; ?>" required>

            <label for="stok">Stok</label>
            <input type="number" name="stok" id="stok" value="<?php echo $produk['stok']; ?>" required>

            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" id="kategori" value="<?php echo htmlspecialchars($produk['kategori']); ?>" required>

            <label for="gambar">Gambar Baru (opsional)</label>
            <input type="file" name="gambar" id="gambar">

            <button type="submit" name="update">Update Produk</button>
        </form>
    </div>

    <div class="image-container">
        <img src="img/<?php echo htmlspecialchars($produk['gambar']); ?>" alt="Gambar Produk">
        <small>Gambar saat ini: <?php echo htmlspecialchars($produk['gambar']); ?></small>
    </div>
</div>

</body>
</html>
