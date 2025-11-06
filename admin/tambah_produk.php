<?php
include 'koneksi.php';

// Jalankan proses saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitasi input untuk keamanan
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Proses upload gambar
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $target_dir = "img/";

        // Buat folder img/ jika belum ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        // Cek tipe file gambar
        if (in_array($ext, $allowed)) {
            $new_filename = time() . "_" . uniqid() . "." . $ext;
            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $query = "INSERT INTO tb_produk (nama_produk, harga, stok, kategori, gambar, deskripsi) 
                          VALUES ('$nama_produk', '$harga', '$stok', '$kategori', '$new_filename', '$deskripsi')";
                $result = mysqli_query($koneksi, $query);

                if ($result) {
                    echo "<script>alert('✅ Produk berhasil ditambahkan!'); window.location.href='index.php';</script>";
                } else {
                    echo "<script>alert('❌ Gagal menambahkan produk ke database.');</script>";
                }
            } else {
                echo "<script>alert('⚠️ Upload gambar gagal. Coba lagi.');</script>";
            }
        } else {
            echo "<script>alert('❌ Hanya file gambar (JPG, PNG, GIF, WEBP) yang diperbolehkan.');</script>";
        }
    } else {
        echo "<script>alert('⚠️ Gambar wajib diupload.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #FFEDFA;
            padding: 40px 15px;
        }

        .form-container {
            max-width: 550px;
            background: #fff;
            margin: auto;
            margin-top: 80px;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #AC1754;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 500;
            color: #AC1754;
            margin-bottom: 4px;
        }

        input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            background: #f8f8f8;
            transition: 0.3s;
        }

        input[type="text"]:focus, input[type="number"]:focus, textarea:focus, select:focus {
            border-color: #AC1754;
            background-color: #fff;
            box-shadow: 0 0 3px rgba(172, 23, 84, 0.3);
            outline: none;
        }

        input[type="file"] {
            border: none;
            background: transparent;
            padding: 5px 0;
        }

        .submit-btn {
            background-color: #AC1754;
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 15px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #8e0e47;
            transform: translateY(-1px);
        }

        @media (max-width: 600px) {
            .form-container {
                padding: 25px 20px;
                margin-top: 60px;
            }
        }
    </style>
</head>
<body>

<?php include 'navmenu.php'; ?>

<div class="form-container">
    <h2>Tambah Produk Baru</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" required>
        </div>

        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Roti">Roti</option>
                <option value="Cake">Cake</option>
                <option value="Donut">Donat</option>
                <option value="Cookies">Kukis</option>
                <option value="Pastry">Kue Kering</option>
            </select>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="gambar">Upload Gambar</label>
            <input type="file" id="gambar" name="gambar" accept="image/*" required>
        </div>

        <button type="submit" class="submit-btn">   Tambah Produk</button>
    </form>
</div>

</body>
</html>
