<?php
include 'koneksi.php';

// Ambil data jam sibuk dari database
$query = "SELECT HOUR(tanggal_pemesanan) AS jam, COUNT(*) AS jumlah_pesanan 
          FROM tb_pesanan 
          GROUP BY jam 
          ORDER BY jam ASC";
$result = mysqli_query($koneksi, $query);

$jam = [];
$jumlah = [];

while ($row = mysqli_fetch_assoc($result)) {
    $jam[] = $row['jam'] . ":00";  // contoh: "10:00"
    $jumlah[] = $row['jumlah_pesanan'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Jam Sibuk</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f9fa;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .page-header {
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

        .page-header h1 {
            flex: 1;
            text-align: center;
            font-size: 20px;
            color: #fff;
            margin: 0;
        }

        .back-btn img {
            width: 32px;
            height: 32px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .back-btn img:hover {
            transform: scale(1.1);
        }

        /* Kontainer utama grafik */
        .chart-container {
            width: 50%;            /* tampil 60% dari layar */
            max-width: 800px;     /* batas maksimum */
            margin: 80px auto;     /* tengah */
            background: #fff;
            padding: 20px 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .chart-container h2 {
            color: #333;
            margin-bottom: 20px;
        }

        canvas {
            width: 10%;
            height: 40px;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="page-header">
        <a href="dashboard_admin.php" class="back-btn">
            <img src="../user/img/back-icon.png" alt="Kembali">
        </a>
    </header>
    <!-- KONTEN GRAFIK -->
    <div class="chart-container">
        <h2>Analisis Waktu Transaksi Tersibuk</h2>
        <canvas id="jamSibukChart"></canvas>
    </div>
    <!-- SCRIPT GRAFIK -->
    <script>
        const ctx = document.getElementById('jamSibukChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($jam); ?>,
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: <?php echo json_encode($jumlah); ?>,
                    borderWidth: 1,
                    backgroundColor: '#AC1754',
                    borderColor: '#AC1754'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#333'
                        }
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Pesanan'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Jam'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
