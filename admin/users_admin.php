<?php
include 'koneksi.php';

// Ambil semua data user
$query = "SELECT * FROM tb_users ORDER BY no_antrian ASC";
$result = mysqli_query($koneksi, $query);

// Hitung jumlah user
$jumlah_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_users"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola User - The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Inter', Arial, sans-serif; 
            margin: 0; 
            background-color: #FFEDFA; 
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #AC1754;
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            z-index: 1000;
        }

        header h2 {
            margin: 0 auto;
            font-weight: bold;
        }

        header a img {
            width: 35px;
            height: 35px;
            cursor: pointer;
        }

        .container {
            max-width: 900px;
            margin: 100px auto 50px;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(172, 23, 84, 0.1);
        }

        h1 { 
            text-align: center; 
            color: #AC1754; 
            margin-bottom: 15px;
        }

        .user-info { 
            margin-bottom: 15px; 
            text-align: center; 
            color: #444;
            font-size: 16px;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            border-radius: 8px;
            overflow: hidden;
        }

        th, td { 
            padding: 12px; 
            border-bottom: 1px solid #eee; 
            text-align: center; 
            font-size: 15px;
        }

        th { 
            background: #AC1754; 
            color: white; 
        }

        tr:hover { 
            background: #fdf2f7; 
        }

        .btn-action { 
            padding: 6px 12px; 
            border-radius: 6px; 
            text-decoration: none; 
            color: white; 
            font-size: 14px;
            background: #AC1754;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin: 3px; /* ✅ memberi jarak antar tombol */
        }

        .btn-action:hover { 
            background-color: #921347; 
        }

        .no-data {
            text-align: center;
            color: #666;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            font-style: italic;
        }
    </style>
</head>

<body>
<header>
    <a href="dashboard_admin.php">
        <img src="../user/img/back-icon.png" alt="Kembali">
    </a>
</header>

    <div class="container">
        <h1>Data User</h1>
        
        <div class="user-info">
            <p>Total User: <strong><?= $jumlah_user ?></strong></p>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No Antrian</th>
                    <th>Nama Pelanggan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['no_antrian']) ?></td>
                    <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['no_antrian'] ?>" class="btn-action">
                            Edit
                        </a>
                        <a href="hapus_user.php?id=<?= $row['no_antrian'] ?>" class="btn-action" onclick="return confirm('Yakin ingin hapus user ini?');">
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="no-data">Belum ada data user yang tersimpan.</div>
        <?php endif; ?>
    </div>

</body>
</html>
