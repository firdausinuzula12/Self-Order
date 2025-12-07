<?php
/**
 * File ini dipanggil otomatis setiap jam 5 sore via CRON JOB
 * Fungsi: Menyimpan snapshot stok hari ini ke tb_daily_stock
 */

include 'koneksi.php';

// Config
$PRODUCT_TABLE  = 'tb_produk';
$DETAIL_TABLE   = 'tb_detailpes';
$ORDER_TABLE    = 'tb_pesanan';
$DAILY_TABLE    = 'tb_daily_stock';

$tanggal_hari_ini = date('Y-m-d');
$log_file = 'logs/snapshot_' . date('Y-m-d') . '.log';

// Fungsi logging
function tulis_log($message) {
    global $log_file;
    if (!is_dir('logs')) mkdir('logs', 0755, true);
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND);
}

tulis_log("=== MULAI SNAPSHOT STOK HARIAN ===");

// Cek apakah sudah ada snapshot hari ini
$cek_existing = $koneksi->query("SELECT COUNT(*) as total FROM {$DAILY_TABLE} WHERE tanggal = '$tanggal_hari_ini'");
$row_cek = $cek_existing->fetch_assoc();

if ($row_cek['total'] > 0) {
    tulis_log("⚠️ Snapshot untuk $tanggal_hari_ini sudah ada. Skip.");
    echo json_encode(['status' => 'info', 'message' => 'Snapshot hari ini sudah dibuat']);
    exit();
}

// Ambil semua produk
$produk_query = $koneksi->query("SELECT id, nama_produk, stok FROM {$PRODUCT_TABLE}");

if (!$produk_query) {
    tulis_log("❌ ERROR: Gagal mengambil data produk - " . $koneksi->error);
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
    exit();
}

$total_produk = 0;
$total_berhasil = 0;

while ($produk = $produk_query->fetch_assoc()) {
    $product_id = $produk['id'];
    $stok_sekarang = $produk['stok'];
    $nama_produk = $produk['nama_produk'];
    
    // Hitung jumlah terjual HARI INI (dari tb_detailpes join tb_pesanan)
    $terjual_query = $koneksi->query("
        SELECT COALESCE(SUM(d.jumlah), 0) as total_terjual
        FROM {$DETAIL_TABLE} d
        JOIN {$ORDER_TABLE} ps ON d.id_pesanan = ps.id_pesanan
        WHERE d.id = $product_id
          AND DATE(ps.tanggal_pemesanan) = '$tanggal_hari_ini'
    ");
    
    $terjual_row = $terjual_query->fetch_assoc();
    $stok_terjual = (int)$terjual_row['total_terjual'];
    
    // Hitung stok awal hari ini (stok sekarang + yang terjual hari ini)
    $stok_awal = $stok_sekarang + $stok_terjual;
    $stok_sisa = $stok_sekarang;
    
    // Insert ke tb_daily_stock
    $insert = $koneksi->query("
        INSERT INTO {$DAILY_TABLE} 
        (product_id, tanggal, stok_awal, stok_terjual, stok_sisa) 
        VALUES 
        ($product_id, '$tanggal_hari_ini', $stok_awal, $stok_terjual, $stok_sisa)
    ");
    
    if ($insert) {
        $total_berhasil++;
        tulis_log("✅ $nama_produk: Awal=$stok_awal, Terjual=$stok_terjual, Sisa=$stok_sisa");
    } else {
        tulis_log("❌ GAGAL snapshot: $nama_produk - " . $koneksi->error);
    }
    
    $total_produk++;
}

tulis_log("=== SELESAI: $total_berhasil dari $total_produk produk berhasil disnapshot ===");

// Return JSON response (berguna jika dipanggil via webhook/API)
echo json_encode([
    'status' => 'success',
    'tanggal' => $tanggal_hari_ini,
    'total_produk' => $total_produk,
    'total_berhasil' => $total_berhasil,
    'timestamp' => date('Y-m-d H:i:s')
]);

$koneksi->close();
?>