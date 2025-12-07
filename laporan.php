<?php

session_start();
include 'koneksi.php';

$DETAIL_TABLE   = 'tb_detailpes';   
$DETAIL_ID_COL  = 'id';             
$DAILY_TABLE    = 'tb_daily_stock'; 
$PRODUCT_TABLE  = 'tb_produk';
$ORDER_TABLE    = 'tb_pesanan';

/* role */
$role = $_SESSION['role'] ?? 'kasir';

/* sanitasi input search */
$cari = "";
if (isset($_POST['cari'])) {
    $cari = trim($_POST['cari']);
} elseif (isset($_GET['cari'])) {
    $cari = trim($_GET['cari']);
}
$search_like = '%' . $koneksi->real_escape_string($cari) . '%';

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

/* ----------------- RESET STOK (ADMIN) ----------------- */
if (isset($_POST['reset_stok']) && $role === 'admin') {

    $product_id = intval($_POST['product_id']);
    $stok_baru = intval($_POST['stok_baru']);
    $tanggal_hari_ini = date('Y-m-d');

    // update tb_produk.stok
    $update = $koneksi->query("UPDATE {$PRODUCT_TABLE} SET stok = $stok_baru WHERE id = $product_id");

    // insert / update tb_daily_stock (optional daily history)
    if ($update) {
        $cek = $koneksi->query("SELECT id_stok FROM {$DAILY_TABLE} WHERE product_id = $product_id AND tanggal = '$tanggal_hari_ini'");
        if ($cek && $cek->num_rows > 0) {
            $koneksi->query("UPDATE {$DAILY_TABLE} SET stok_awal = $stok_baru, stok_sisa = $stok_baru WHERE product_id = $product_id AND tanggal = '$tanggal_hari_ini'");
        } else {
            $koneksi->query("INSERT INTO {$DAILY_TABLE} (product_id, tanggal, stok_awal, stok_terjual, stok_sisa) VALUES ($product_id, '$tanggal_hari_ini', $stok_baru, 0, $stok_baru)");
        }
        $_SESSION['success_msg'] = "✅ Stok berhasil direset.";
    } else {
        $_SESSION['success_msg'] = "⚠️ Gagal mereset stok. Cek koneksi / query.";
    }

    header("Location: " . $_SERVER['PHP_SELF'] . "?aksi=sisa_stok");
    exit();
}

/* ----------------- BUILD QUERY ----------------- */
if ($aksi === 'terbanyak') {

    $query = "
        SELECT 
            p.id AS id_produk,
            p.nama_produk,
            p.harga,
            p.stok,
            COALESCE(SUM(d.jumlah), 0) AS total_terjual
        FROM {$PRODUCT_TABLE} p
        LEFT JOIN {$DETAIL_TABLE} d ON p.id = d.{$DETAIL_ID_COL}
        LEFT JOIN {$ORDER_TABLE} ps ON d.id_pesanan = ps.id_pesanan
        WHERE p.nama_produk LIKE '$search_like'
        GROUP BY p.id
        ORDER BY p.stok DESC
    ";

} elseif ($aksi === 'tersedikit') {

    $query = "
        SELECT 
            p.id AS id_produk,
            p.nama_produk,
            p.harga,
            p.stok,
            COALESCE(SUM(d.jumlah), 0) AS total_terjual
        FROM {$PRODUCT_TABLE} p
        LEFT JOIN {$DETAIL_TABLE} d ON p.id = d.{$DETAIL_ID_COL}
        LEFT JOIN {$ORDER_TABLE} ps ON d.id_pesanan = ps.id_pesanan
        WHERE p.nama_produk LIKE '$search_like'
        GROUP BY p.id
        ORDER BY p.stok ASC
    ";

} elseif ($aksi === 'transaksi' && $role === 'admin') {

    $query = "
        SELECT 
            ps.id_pesanan AS id_transaksi,
            d.nama_produk,
            d.jumlah,
            d.subtotal AS total_harga,
            ps.tanggal_pemesanan,
            ps.status_pesanan
        FROM {$DETAIL_TABLE} d
        JOIN {$ORDER_TABLE} ps ON d.id_pesanan = ps.id_pesanan
        WHERE d.nama_produk LIKE '$search_like'
        ORDER BY ps.tanggal_pemesanan DESC
    ";

} elseif ($aksi === 'sisa_stok' && $role === 'admin') {

    $yesterday = date('Y-m-d', strtotime('-1 day'));

    $query = "
        SELECT 
            p.id AS id_produk,
            p.nama_produk,
            p.harga,
            p.stok AS stok_sekarang,

            (SELECT stok_awal FROM {$DAILY_TABLE} ds WHERE ds.product_id = p.id AND ds.tanggal = '$yesterday' LIMIT 1) AS stok_kemarin,

            (SELECT COALESCE(SUM(d.jumlah), 0)
             FROM {$DETAIL_TABLE} d
             JOIN {$ORDER_TABLE} ps ON d.id_pesanan = ps.id_pesanan
             WHERE d.{$DETAIL_ID_COL} = p.id
               AND DATE(ps.tanggal_pemesanan) = '$yesterday'
            ) AS terjual_kemarin

        FROM {$PRODUCT_TABLE} p
        WHERE p.nama_produk LIKE '$search_like'
        ORDER BY p.nama_produk ASC
    ";

} else {
    $query = "
        SELECT 
            p.id AS id_produk,
            p.nama_produk,
            p.harga,
            p.stok,
            COALESCE(SUM(d.jumlah), 0) AS total_terjual
        FROM {$PRODUCT_TABLE} p
        LEFT JOIN {$DETAIL_TABLE} d ON p.id = d.{$DETAIL_ID_COL}
        LEFT JOIN {$ORDER_TABLE} ps ON d.id_pesanan = ps.id_pesanan
        WHERE p.nama_produk LIKE '$search_like'
        GROUP BY p.id
        ORDER BY p.nama_produk ASC
    ";
}

$data = $koneksi->query($query);

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Laporan Produk & Transaksi</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
body{
    font-family:Inter, sans-serif;
    background: #f8f8f8;
    color:#333;
    margin:0;
    padding:0}
header{
    position:fixed;
    top:0;
    width:100%;
    background: #AC1754;
    color:#fff;
    padding:10px 20px;
    display:flex;
    align-items:center;
    z-index:1000
}
header a img{
    width:35px;
    height:35px;
    cursor:pointer
}
.container{
    max-width:1000px;
    margin:60px auto;
    text-align:center;
    padding:0 20px
}
.success-msg{
    background: #AC1754;
    color:#fff;
    padding:12px 20px;
    border-radius:4px;
    margin-bottom:16px;display:inline-block}
h1{
    margin-top:12px;
    color:#AC1754;
    margin-bottom:12px
}
.buttons{
    display:flex;
    justify-content:center;
    gap:12px;
    flex-wrap:wrap;
    margin-bottom:14px
}
button,.btn{
    background: #AC1754;
    color:#fff;
    border:none;
    padding:10px 14px;
    border-radius:4px;
    cursor:pointer}
button:hover,.btn:hover{
    background:#921347
}
.btn-success{
    background: #AC1754;
}
.btn-warning{
    background: #AC1754;
}
.search-box{
    display:flex;
    justify-content:center;
    gap:8px;
    margin:10px auto
}
.search-box input{
    padding:8px 12px;
    width:260px;
    border-radius:4px;
    border:1px solid #ccc
}
.table-container{
    margin-top:10px;
    background: #fff;
    border-radius:6px;
    width:100%;
    overflow-x:auto
}
.table-container table{
    width:100%;
    border-collapse:collapse
}
th,td{
    padding:10px;
    border-bottom:1px solid #eee;
    text-align:center
}
th{
    background: #AC1754;
    color:#fff
}
tr:hover{
    background: #fef2f7
}
.status-badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:6px;
    font-weight:700
}
.status-optimal{
    background: #d1fae5;
    color: #065f46
}
.status-bagus{
    background: #fef3c7;
    color: #78350f
}
.status-overstock{
    background:#fee2e2;
    color:#991b1b
}
.modal{
    display:none;
    position:fixed;
    z-index:2000;
    left:0;
    top:0;
    width:100%;
    height:90%;
    background:rgba(0,0,0,0.5)}
.modal-content{
    background:#fff;
    margin:8% auto;
    padding:18px;
    border-radius:6px;
    width:92%;
    max-width:520px;box-shadow:0 3px 15px rgba(0,0,0,0.12)}
.form-group{
    margin-bottom:12px;
    text-align:left
}
.form-group label{
    display:block;
    margin-bottom:6px;
    font-weight:700
}
.form-group input{
    width:90%;
    padding:10px;
    border-radius:4px;
    border:1px solid #ccc
}
.empty-state{
    text-align:center;
    padding:40px 20px;
    color:#999
}
@media (max-width:768px){
    .buttons{flex-direction:column}
    button,.btn{width:100%}
}
</style>
</head>
<body>
<header>
    <a href="<?= ($role === 'admin') ? 'admin/index.php' : 'kasir/index.php' ?>"><img src="user/img/back-icon.png" alt="Kembali"></a>
</header>

<div class="container">
    <?php if (!empty($_SESSION['success_msg'])): ?>
        <div class="success-msg"><?= $_SESSION['success_msg']; ?></div>
    <?php unset($_SESSION['success_msg']); endif; ?>

    <h1>Laporan Produk dan Transaksi</h1>

    <!-- SEARCH -->
    <form method="post" class="search-box">
        <input type="text" name="cari" placeholder="Cari nama produk..." value="<?= htmlspecialchars($cari) ?>">
        <input type="hidden" name="aksi" value="<?= htmlspecialchars($aksi) ?>">
        <button type="submit">Cari</button>
    </form>

    <!-- FILTER BUTTONS -->
    <form method="post" class="buttons">
        <button type="submit" name="aksi" value="terbanyak">Stok Terbanyak</button>
        <button type="submit" name="aksi" value="tersedikit">Stok Tersedikit</button>
        <?php if ($role === 'admin'): ?>
            <button type="submit" name="aksi" value="transaksi">Lihat Transaksi</button>
            <button type="submit" name="aksi" value="sisa_stok" class="btn-warning">Laporan Sisa Stok</button>
        <?php endif; ?>
    </form>

    <!-- TABLE -->
    <?php if ($data && $data->num_rows > 0): ?>
    <div class="table-container">
        <table>
            <thead>
            <?php if ($aksi === 'sisa_stok' && $role === 'admin'): ?>
                <tr>
                    <th>No</th><th>ID</th><th>Nama Produk</th><th>Harga</th><th>Stok Sekarang</th>
                    <th>Stok Kemarin</th><th>Terjual Kemarin</th><th>Sisa Kemarin</th><th>Status</th><th>Aksi</th>
                </tr>
            <?php elseif ($aksi === 'transaksi'): ?>
                <tr>
                    <th>No</th><th>ID Transaksi</th><th>Nama Produk</th><th>Jumlah</th><th>Total Harga</th><th>Tanggal</th><th>Status</th>
                </tr>
            <?php else: ?>
                <tr>
                    <th>No</th><th>ID Produk</th><th>Nama Produk</th><th>Harga / pcs</th><th>Stok Tersedia</th><th>Jumlah Terjual</th>
                </tr>
            <?php endif; ?>
            </thead>
            <tbody>
            <?php
            $no = 1;
            while ($row = $data->fetch_assoc()):
                if ($aksi === 'sisa_stok' && $role === 'admin'):
                    $stok_kemarin = ($row['stok_kemarin'] !== null && $row['stok_kemarin'] !== '') ? (int)$row['stok_kemarin'] : null;
                    $terjual_kemarin = isset($row['terjual_kemarin']) ? (int)$row['terjual_kemarin'] : 0;

                    if ($stok_kemarin === null) {
                        $sisa_kemarin_display = '-';
                        $persentase_sisa = 0;
                        $status_text = '-';
                        $status_class = '';
                        $stok_kemarin_display = '-';
                    } else {
                        $sisa_kemarin = max(0, $stok_kemarin - $terjual_kemarin);
                        $persentase_sisa = ($stok_kemarin > 0) ? round(($sisa_kemarin / $stok_kemarin) * 100, 1) : 0;
                        $stok_kemarin_display = $stok_kemarin;
                        $sisa_kemarin_display = $sisa_kemarin;

                        if ($persentase_sisa <= 1) {
                            $status_class = 'status-overstock';
                            $status_text = 'Habis';
                        } elseif ($persentase_sisa <= 5) {
                            $status_class = 'status-bagus';
                            $status_text = 'Menipis';
                        } else {
                            $status_class = 'status-optimal';
                            $status_text = 'Aman';
                        }
                    }
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['id_produk']) ?></td>
                    <td><strong><?= htmlspecialchars($row['nama_produk']) ?></strong></td>
                    <td>Rp <?= number_format($row['harga'],0,',','.') ?></td>
                    <td><strong style="color:#1366d6;"><?= htmlspecialchars($row['stok_sekarang']) ?> pcs</strong></td>
                    <td><?= $stok_kemarin_display ?><?= ($stok_kemarin_display !== '-') ? ' pcs' : '' ?></td>
                    <td style="color:#10b981;font-weight:700;"><?= $terjual_kemarin ?> pcs</td>
                    <td style="color:#ef4444;font-weight:700;"><?= $sisa_kemarin_display ?><?= ($sisa_kemarin_display !== '-') ? ' pcs' : '' ?></td>
                    <td>
                        <?php if ($stok_kemarin !== null): ?>
                            <span class="status-badge <?= $status_class ?>"><?= $status_text ?></span>
                        <?php else: echo '-'; endif; ?>
                    </td>
                    <td>
                        <button class="btn-success" style="padding:8px 12px;font-size:13px" onclick="openResetModal(<?= $row['id_produk'] ?>, '<?= addslashes($row['nama_produk']) ?>', <?= $row['stok_sekarang'] ?>)">Reset Stok</button>
                    </td>
                </tr>
            <?php
                elseif ($aksi === 'transaksi'):
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['id_transaksi']) ?></td>
                    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                    <td><?= htmlspecialchars($row['jumlah']) ?> pcs</td>
                    <td>Rp <?= number_format($row['total_harga'],0,',','.') ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($row['tanggal_pemesanan'])) ?></td>
                    <td><?= htmlspecialchars($row['status_pesanan']) ?></td>
                </tr>
            <?php
                else:
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['id_produk']) ?></td>
                    <td><strong><?= htmlspecialchars($row['nama_produk']) ?></strong></td>
                    <td>Rp <?= number_format($row['harga'],0,',','.') ?></td>
                    <td><strong style="color:#1366d6;"><?= htmlspecialchars($row['stok']) ?> pcs</strong></td>
                    <td style="color:#10b981;font-weight:700;"><?= htmlspecialchars($row['total_terjual']) ?> pcs</td>
                </tr>
            <?php
                endif;
            endwhile;
            ?>
            </tbody>
        </table>
    </div>

    <?php else: ?>
    <div class="table-container">
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p style="font-size:18px;font-weight:700">Tidak ada data ditemukan</p>
            <p style="margin-top:8px">Coba gunakan filter / kata pencarian lain</p>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- Modal Reset Stok -->
<div id="resetModal" class="modal">
    <div class="modal-content">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
            <h2 style="color:#AC1754;margin:0">Reset Stok Produk</h2>
            <span style="cursor:pointer;font-size:24px" onclick="closeResetModal()">&times;</span>
        </div>
        <form method="post">
            <input type="hidden" name="product_id" id="modal_product_id">
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" id="modal_product_name" readonly>
            </div>
            <div class="form-group">
                <label>Stok Saat Ini</label>
                <input type="text" id="modal_current_stock" readonly>
            </div>
            <div class="form-group">
                <label>Stok Baru <span style="color:red">*</span></label>
                <input type="number" name="stok_baru" id="modal_new_stock" required min="0" value="0">
            </div>
            <div style="display:flex;gap:10px;margin-top:12px">
                <button type="button" onclick="closeResetModal()" style="flex:1;background:#6b7280;color:#fff;border:none;padding:10px;border-radius:6px">Batal</button>
                <button type="submit" name="reset_stok" class="btn-success" style="flex:1;border:none;padding:10px;border-radius:6px">Reset Stok</button>
            </div>
        </form>
    </div>
</div>

<script>
function openResetModal(id, name, currentStock) {
    document.getElementById('modal_product_id').value = id;
    document.getElementById('modal_product_name').value = name;
    document.getElementById('modal_current_stock').value = currentStock + ' pcs';
    document.getElementById('modal_new_stock').value = '';
    document.getElementById('resetModal').style.display = 'block';
}
function closeResetModal() {
    document.getElementById('resetModal').style.display = 'none';
}
window.onclick = function(e) {
    var modal = document.getElementById('resetModal');
    if (e.target == modal) closeResetModal();
}
</script>

</body>
</html>