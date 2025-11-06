<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Produk - The Cakery</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #FFEDFA 0%, #F8E8FF 100%);
    margin: 0;
    padding: 90px 10px 30px;
    overflow-x: hidden;
}

/* === GRID PRODUK === */
.product-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 18px;
    max-width: 1150px;
    margin: 40px auto;
}

/* === CARD PRODUK === */
.product-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    text-align: center;
    position: relative;
}
.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 18px rgba(172, 23, 84, 0.2);
}
.product-card img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    transition: 0.3s ease;
}
.product-info {
    padding: 10px 8px 15px;
}
.product-info h3 {
    margin: 5px 0;
    font-size: 0.9rem;
    color: #333;
    font-weight: 400;
}
.product-info p {
    color: #AC1754;
    font-weight: 400;
    font-size: 0.85rem;
    margin: 0 0 10px;
}

/* === BUTTON AKSI === */
.button-group {
    display: flex;
    justify-content: center;
    gap: 6px;
}
.button-group a {
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 0.7rem;
    font-weight: 400;
    background: linear-gradient(135deg, #AC1754 0%, #D63384 100%);
    color: #fff;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(172, 23, 84, 0.25);
}
.button-group a:hover {
    background: linear-gradient(135deg, #8d0f45 0%, #b91c6a 100%);
    transform: translateY(-2px);
}

/* === STOK HABIS (overlay tapi masih bisa diklik) === */
.out-of-stock {
    opacity: 0.7;
}
.out-of-stock::after {
    content: "Produk Habis";
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(172, 23, 84, 0.9);
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    z-index: 2;
}

/* === RESPONSIF === */
@media (max-width: 1200px) {
    .product-grid { grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 992px) {
    .product-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .product-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .product-grid { grid-template-columns: repeat(1, 1fr); }
}
</style>
</head>

<body>

<?php include 'navmenu.php'; ?>

<div class="product-grid">
<?php
$query = "SELECT * FROM tb_produk";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $gambar = htmlspecialchars($data['gambar']);
        $gambar_path = "img/" . $gambar;
        $stok_habis = $data['stok'] <= 0 ? 'out-of-stock' : '';
        echo "
        <div class='product-card {$stok_habis}'>
            <img src='{$gambar_path}' alt='" . htmlspecialchars($data['nama_produk']) . "'>
            <div class='product-info'>
                <h3>" . htmlspecialchars($data['nama_produk']) . "</h3>
                <p>Rp" . number_format($data['harga'], 0, ',', '.') . "</p>
                <div class='button-group'>
                    <a href='restok_produk.php?id=" . htmlspecialchars($data['id']) . "'>Restok</a>
                    <a href='edit_produk.php?id=" . htmlspecialchars($data['id']) . "'>Edit</a>
                </div>
            </div>
        </div>
        ";
    }
} else {
    echo "<p style='text-align:center; color:#AC1754; font-weight:400;'>Tidak ada produk tersedia.</p>";
}
?>
</div>

</body>
</html>
