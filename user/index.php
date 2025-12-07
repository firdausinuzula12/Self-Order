<?php
session_start(); 
include 'koneksi.php'; 

$sql_count = "SELECT COUNT(*) AS total FROM tb_users";
$result = $koneksi->query($sql_count); 
$row = $result->fetch_assoc(); 
$no_antrian = $row['total'] + 1; 

$id_pesanan = 'P' . str_pad($no_antrian, 4, '0', STR_PAD_LEFT);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $koneksi->real_escape_string($_POST['nama_pelanggan']);
    $sql = "INSERT INTO tb_users (id_pesanan, nama_pelanggan, no_antrian) 
            VALUES ('$id_pesanan', '$nama', $no_antrian)";
    
    if ($koneksi->query($sql) === TRUE) {   
        $_SESSION['no_antrian'] = $no_antrian;    
        $_SESSION['id_pesanan'] = $id_pesanan; 
        $_SESSION['nama_pelanggan'] = $nama;   

        header('Location: home.php');
        exit(); 
        
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Cakery</title>
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Mengatur jenis font */
            background-image: url('img/Untitled design.png'); /* Gambar latar belakang */
            background-size: cover;  /* Gambar menyesuaikan ukuran layar */
            background-position: center;  /* Posisi gambar di tengah */
            background-repeat: no-repeat;  /* Gambar tidak diulang */
            color: #880E4F;   /* Warna teks utama */
            text-align: center;   /* Perataan teks ke tengah */
            padding: 1px;   /* Ruang dalam halaman */
        }

        img {
            width: 180px;  /* Lebar gambar logo */
            margin-bottom: 20px;  /* Jarak bawah dari logo */
            margin-top: 40px;   /* Jarak atas dari logo */
        }
       
        input[type="text"] {
            width: 200px;   /* Lebar kotak input */
            padding: 10px;  /* Ruang dalam kotak input */
            margin: 10px;  /* Jarak luar kotak input */
            margin-top: 40px;  /* Jarak atas khusus */
            border: 2px solid #AC1754; /* Garis tepi kotak input */
            border-radius: 2px; /* Sudut melengkung */
            font-size: 14px; /* Ukuran teks dalam input */
        }
        
        .antrian {
            width: 40px;  
            display: inline-block;  /* Tampilan sebagai blok inline */
            margin: 10px; /* Jarak atas-bawah */
            font-size: 14px;  /* Ukuran teks */
            background: white;  /* Latar belakang putih */
            padding: 7px; /* Ruang dalam label */
            border: 2px solid #AC1754; /* Garis tepi label */
            border-radius: 2px; /* Sudut melengkung */
            color: #880E4F;  /* Warna teks label */
            margin-top: 5px; /* Jarak atas khusus */
        }
        
        button {
            width: 140px;
            background-color: #AC1754; /* Warna latar tombol */
            color: white; /* Warna teks tombol */
            padding: 10px; /* Ruang dalam tombol */
            border: none; /* Menghilangkan garis tepi default */
            border-radius: 2px; /* Sudut melengkung tombol */
            cursor: pointer; /* Kursor berubah saat hover */
            font-size: 15px; /* Ukuran teks tombol */
            margin-top: 15px; /* Jarak atas tombol */
        }
        
        button:hover {
            background-color: rgb(192, 24, 113); /* Warna tombol saat di-hover */
        }
    </style>
</head>
<body>
    <img src="img/logo_toko.png" alt="Logo Toko">
    <form method="POST" action=""> 
        <input type="text" name="nama_pelanggan" placeholder="Masukkan Nama Anda" autocomplete="off" required>
        <br>
            <div class="antrian">
                <strong><?php echo $no_antrian; ?></strong> 
            </div>
        <br>
            <button type="submit">Selanjutnya</button>
    </form>
<script>
    
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const radius = 100; // radius dalam meter
    const tokoLat = -7,3401614; // latitude toko ()-6.200000 /////// s-7,3401614
    const tokoLng = 109,8887773; // longitude toko ()106.816666 //////s109,8887773

    function hitungJarak(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // radius bumi (meter)
        const φ1 = lat1 * Math.PI/180;
        const φ2 = lat2 * Math.PI/180;
        const Δφ = (lat2 - lat1) * Math.PI/180;
        const Δλ = (lon2 - lon1) * Math.PI/180;

        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

        return R * c; // jarak dalam meter
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((pos) => {
                const userLat = pos.coords.latitude;
                const userLng = pos.coords.longitude;
                const jarak = hitungJarak(userLat, userLng, tokoLat, tokoLng);

                if (jarak <= radius) {
                    form.submit(); // Lanjut submit form
                } else {
                    alert('Anda harus berada di dalam area toko untuk melanjutkan!');
                }
            }, () => {
                alert('Tidak dapat mengakses lokasi Anda!');
            });
        } else {
            alert('Browser Anda tidak mendukung GPS!');
        }                                                                                                                                                 
    });
});
</script>
</body>
</html>