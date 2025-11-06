<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_pesanan = $_GET['id'];

    // Mulai transaksi
    $koneksi->begin_transaction();

    try {
        // Ambil semua produk dari pesanan ini
        $detail = $koneksi->prepare("SELECT id, jumlah FROM tb_detailpes WHERE id_pesanan = ?");
        $detail->bind_param("s", $id_pesanan);
        $detail->execute();
        $result = $detail->get_result();

        // Kembalikan stok ke tb_produk
        while ($row = $result->fetch_assoc()) {
            $id_produk = $row['id'];
            $jumlah = $row['jumlah'];

            $update = $koneksi->prepare("UPDATE tb_produk SET stok = stok + ? WHERE id = ?");
            $update->bind_param("is", $jumlah, $id_produk);
            $update->execute();
        }

        // Hapus data di detail, pembayaran, dan pesanan
        $hapus_detail = $koneksi->prepare("DELETE FROM tb_detailpes WHERE id_pesanan = ?");
        $hapus_detail->bind_param("s", $id_pesanan);
        $hapus_detail->execute();

        $hapus_bayar = $koneksi->prepare("DELETE FROM tb_pembayaran WHERE id_pesanan = ?");
        $hapus_bayar->bind_param("s", $id_pesanan);
        $hapus_bayar->execute();

        $hapus_pesanan = $koneksi->prepare("DELETE FROM tb_pesanan WHERE id_pesanan = ?");
        $hapus_pesanan->bind_param("s", $id_pesanan);
        $hapus_pesanan->execute();

        // Sukses → commit perubahan
        $koneksi->commit();

        echo "<script>
            alert('Pesanan berhasil dihapus dan stok produk dikembalikan!');
            window.location.href = 'index.php';
        </script>";

    } catch (Exception $e) {
        // Kalau error → rollback
        $koneksi->rollback();
        echo "<script>
            alert('Gagal menghapus pesanan: " . addslashes($e->getMessage()) . "');
            window.location.href = 'index.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID pesanan tidak ditemukan.');
        window.location.href = 'index.php';
    </script>";
}
?>
