<?php
include 'koneksi.php';

// ======================
// Ambil Data Produk
// ======================
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $query = "SELECT * FROM tb_produk WHERE id = '$id_produk'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Produk tidak ditemukan.";
        exit();
    }
} else {
    echo "ID produk tidak ditemukan.";
    exit();
}

// ======================
// Tambah Stok Produk
// ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jumlah_restok'])) {
    $jumlah_restok = (int)$_POST['jumlah_restok'];

    if ($jumlah_restok > 0) {
        $stok_baru = $data['stok'] + $jumlah_restok;
        $update = "UPDATE tb_produk SET stok = $stok_baru WHERE id = '$id_produk'";

        if (mysqli_query($koneksi, $update)) {
            echo "<script>alert('✅ Stok berhasil diperbarui!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('❌ Gagal memperbarui stok.');</script>";
        }
    } else {
        echo "<script>alert('Jumlah restok harus lebih dari 0.');</script>";
    }
}

// ======================
// Hapus Produk
// ======================
if (isset($_POST['hapus_produk'])) {
    $delete = "DELETE FROM tb_produk WHERE id = '$id_produk'";
    if (mysqli_query($koneksi, $delete)) {
        echo "<script>alert('🗑️ Produk berhasil dihapus!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menghapus produk.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk - The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #FFEDFA;
            padding: 80px 20px 20px;
        }

        .container {
            background: #fff;
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(172, 23, 84, 0.15);
        }

        h1 {
            text-align: center;
            color: #AC1754;
            font-size: 1.6rem;
            margin-bottom: 25px;
        }

        .product-detail p {
            font-size: 1rem;
            margin-bottom: 10px;
            color: #333;
        }

        .product-detail img {
            display: block;
            margin: 15px auto;
            max-width: 60%;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            font-weight: 600;
            margin-top: 25px;
            color: #333;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 25px;
        }

        .btn {
            flex: 1;
            text-align: center;
            padding: 10px;
            border: none;
            border-radius: 6px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            background-color: #AC1754;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #8c1244;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: #AC1754;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<?php include 'navmenu.php'; ?>

<div class="container">
    <h1>Kelola Produk</h1>

    <div class="product-detail">
        <p><strong>Nama Produk:</strong> <?= htmlspecialchars($data['nama_produk']); ?></p>
        <p><strong>Harga:</strong> Rp <?= number_format($data['harga'], 0, ',', '.'); ?></p>
        <p><strong>Stok Sekarang:</strong> <?= htmlspecialchars($data['stok']); ?></p>
        <img src="img/<?= htmlspecialchars($data['gambar']); ?>" alt="Gambar Produk">
    </div>

    <form method="POST">
        <label for="jumlah_restok">Tambah Stok:</label>
        <input type="number" name="jumlah_restok" id="jumlah_restok" required min="1" placeholder="Masukkan jumlah stok...">
        
        <div class="btn-container">
            <button type="submit" class="btn">
                 Simpan Stok
            </button>
            <button type="submit" name="hapus_produk" class="btn" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                Hapus Produk
            </button>
        </div>
    </form>
</div>

</body>
</html>
