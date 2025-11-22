<?php
// --- 1. KONFIGURASI SISTEM ---
$fontName = '/Poppins-Regular.ttf'; // Pastikan file ini ada
$fontFile = realpath(__DIR__ . '/' . $fontName);
$templateFile = __DIR__ . '/template.png'; // Pastikan file ini ada
$outputDir = __DIR__ . '/hasil_sertifikat/';
$fontSize = 50; // Ukuran font default (bisa diubah)
$fontColor = [0, 0, 0]; // Warna Hitam (R, G, B)

// Buat folder output jika belum ada
if (!file_exists($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// Variabel untuk menampung pesan sukses/error
$pesan = "";
$fileDownload = "";

// --- 2. PROSES JIKA TOMBOL DITEKAN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Cek kelengkapan file aset
    if (!$fontFile || !file_exists($fontFile)) {
        die("Error: File font '$fontName' tidak ditemukan.");
    }
    if (!file_exists($templateFile)) {
        die("Error: File template.png tidak ditemukan.");
    }

    // Load Gambar
    $ext = pathinfo($templateFile, PATHINFO_EXTENSION);
    $image = (strtolower($ext) == 'png') ? imagecreatefrompng($templateFile) : imagecreatefromjpeg($templateFile);
    $color = imagecolorallocate($image, $fontColor[0], $fontColor[1], $fontColor[2]);

    // --- DAFTAR INPUT & KOORDINAT (Sesuai Request Anda) ---
    // Format: 'name_di_form' => [X, Y, 'Nilai yang diinput']
    $inputs = [
        'no_sertifikat' => ['x' => 660,  'y' => 437,  'text' => $_POST['no_sertifikat']],
        'thn_sertifikat'=> ['x' => 1253, 'y' => 437,  'text' => $_POST['thn_sertifikat']],
        'nama_penerima' => ['x' => 580,  'y' => 760,  'text' => $_POST['nama_penerima']],
        'nim_penerima'  => ['x' => 955,  'y' => 820,  'text' => $_POST['nim_penerima']],
        'thn_laksana'   => ['x' => 1420, 'y' => 930,  'text' => $_POST['thn_laksana']],
        'tgl_laksana'   => ['x' => 730,  'y' => 975,  'text' => $_POST['tgl_laksana']],
        'kades'         => ['x' => 370,  'y' => 1160, 'text' => $_POST['kades']],
    ];

    // Loop untuk menulis setiap data ke gambar
    foreach ($inputs as $key => $data) {
        imagettftext($image, $fontSize, 0, $data['x'], $data['y'], $color, $fontFile, $data['text']);
    }

    // Simpan File
    $namaBersih = str_replace(' ', '_', $_POST['nama_penerima']);
    $namaFile = "Sertifikat_" . $namaBersih . ".png";
    $targetFile = $outputDir . $namaFile;
    
    imagepng($image, $targetFile);
    imagedestroy($image);

    $pesan = "Sertifikat Berhasil Dibuat!";
    $fileDownload = 'hasil_sertifikat/' . $namaFile;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator Sertifikat Desa</title>
    <style>
        body { font-family: sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="number"], input[type="date"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; transition: 0.3s; }
        button:hover { background-color: #0056b3; }
        .alert { padding: 15px; background-color: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 20px; text-align: center; }
        .btn-download { display: inline-block; margin-top: 10px; text-decoration: none; font-weight: bold; color: #155724; border-bottom: 2px solid #155724; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Buat Sertifikat Otomatis</h2>

        <?php if ($pesan): ?>
            <div class="alert">
                <?= $pesan ?> <br>
                <a href="<?= $fileDownload ?>" download class="btn-download">Download Sertifikat (Klik Disini)</a>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Nomor Sertifikat</label>
                <input type="text" name="no_sertifikat" placeholder="Contoh: 001/DS/2024" required>
            </div>
            
            <div class="form-group">
                <label>Tahun Sertifikat</label>
                <input type="text" name="thn_sertifikat" placeholder="Contoh: 2024" required>
            </div>

            <div class="form-group">
                <label>Nama Penerima</label>
                <input type="text" name="nama_penerima" placeholder="Nama Lengkap" required>
            </div>

            <div class="form-group">
                <label>NIM Penerima</label>
                <input type="text" name="nim_penerima" placeholder="Contoh: 10112345" required>
            </div>

            <div class="form-group">
                <label>Tahun Pelaksanaan</label>
                <input type="text" name="thn_laksana" placeholder="Contoh: 2024" required>
            </div>

            <div class="form-group">
                <label>Tanggal Pelaksanaan</label>
                <input type="text" name="tgl_laksana" placeholder="Contoh: 17 Agustus 2024" required>
            </div>

            <div class="form-group">
                <label>Nama Kepala Desa</label>
                <input type="text" name="kades" placeholder="Nama Kades" required>
            </div>

            <button type="submit">Cetak Sertifikat</button>
        </form>
    </div>

</body>
</html>