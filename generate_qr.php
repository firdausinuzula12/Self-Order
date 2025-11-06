<?php
require_once 'phpqrcode/qrlib.php';

// Folder penyimpanan QR code
$qrFolder = 'qrcodes/';
if (!file_exists($qrFolder)) {
    mkdir($qrFolder, 0777, true);
}

function generateQRCode($id_pesanan) {
    global $qrFolder;

    // Nama file QR
    $fileName = $qrFolder . $id_pesanan . '.png';

    // Data yang mau ditaruh di QR (bisa dikembangkan)
    $data = "ID Pesanan: " . $id_pesanan . "\n";
    $data .= "Cek transaksi kamu di kasir dengan ID ini.";

    // Generate QR Code
    QRcode::png($data, $fileName, QR_ECLEVEL_L, 5);

    return $fileName;
}
?>
