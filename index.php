<?php
// --- 1. SETUP FOLDER ---
$templateFile = __DIR__ . '/template.png';
$outputDir    = __DIR__ . '/hasil_sertifikat/';

if (!file_exists($outputDir)) { mkdir($outputDir, 0777, true); }

$pesan = "";
$fileDownload = "";

// --- 2. PROSES UTAMA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!file_exists($templateFile)) { die("Error: File template.png tidak ditemukan."); }

    // Load Gambar Template
    $ext = pathinfo($templateFile, PATHINFO_EXTENSION);
    $image = (strtolower($ext) == 'png') ? imagecreatefrompng($templateFile) : imagecreatefromjpeg($templateFile);

    // --- 3. KONFIGURASI SPESIFIK PER ITEM ---
    // Di sini Anda mengatur Font, Ukuran, Warna, dan Posisi masing-masing
    
    $dataSertifikat = [
        
        // 1. Nomor Sertifikat (Biasanya font tegas/kecil)
        'no_sertifikat' => [
            'text'  => $_POST['no_sertifikat'],
            'x'     => 657  , 
            'y'     => 437,
            'size'  => 30,                 // Ukuran Font
            'font'  => '/Poppins-Regular.ttf',   // Nama File Font
            'color' => [30, 54, 83]           
        ],

        // 2. Tahun Sertifikat
        'thn_sertifikat' => [
            'text'  => $_POST['thn_sertifikat'],
            'x'     => 1233, 
            'y'     => 437,
            'size'  => 30,
            'font'  => '/Poppins-Regular.ttf',
            'color' => [30, 54, 83]        
        ],

        // 3. Nama Penerima (Biasanya Paling Besar & Font Bagus)
        'nama_penerima' => [
            'text'  => $_POST['nama_penerima'],
            'x'     => 'CENTER', 
            'y'     => 760,
            'size'  => 90,                 // Ukuran Lebih Besar
            'font'  => '/PinyonScript-Regular.ttf',   // Font Sambung/Latin
            'color' => [225, 167, 48]      // Warna Emas (Dark Goldenrod)
        ],

        // 4. NIM Penerima
        'nim_penerima' => [
            'text'  => $_POST['nim_penerima'],
            'x'     => 930, 
            'y'     => 854,
            'size'  => 36,
            'font'  => '/Poppins-Regular.ttf',
            'color' => [30, 54, 83]
        ],

        // 5. Tahun Pelaksanaan
        'thn_laksana' => [
            'text'  => $_POST['thn_laksana'],
            'x'     => 1420, 
            'y'     => 930,
            'size'  => 26,
            'font'  => '/Poppins-Regular.ttf',
            'color' => [0, 0, 0]
        ],

        // 6. Tanggal Pelaksanaan
        'tgl_laksana' => [
            'text'  => $_POST['tgl_laksana'],
            'x'     => 730, 
            'y'     => 975,
            'size'  => 26,
            'font'  => '/Poppins-Regular.ttf',
            'color' => [0, 0, 0]
        ],

        // 7. Nama Kepala Desa
        'kades' => [
            'text'  => $_POST['kades'],
            'x'     => 320, 
            'y'     => 1160,
            'size'  => 30,
            'font'  => '/Poppins-Regular.ttf', // Atau font tanda tangan jika ada
            'color' => [30, 54, 83]       // Warna Navy Blue
        ]
    ];

    // --- LOOP PROCESSING ---
    foreach ($dataSertifikat as $key => $item) {
        // 1. Validasi Font Path
        $fontPath = realpath(__DIR__ . '/' . $item['font']);
        if (!$fontPath) {
            // Fallback jika font khusus tidak ada, pakai default sistem (biar tidak error fatal)
            // Tapi sebaiknya pastikan file font ada.
            die("Error: Font '{$item['font']}' tidak ditemukan di folder.");
        }

        // 2. Buat Warna Khusus untuk item ini
        // Format array color [Red, Green, Blue]
        $colorAllocated = imagecolorallocate($image, $item['color'][0], $item['color'][1], $item['color'][2]);

        // 3. Tulis Teks
        imagettftext(
            $image, 
            $item['size'], 
            0, // Sudut kemiringan (0 = lurus)
            $item['x'], 
            $item['y'], 
            $colorAllocated, 
            $fontPath, 
            $item['text']
        );
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
    <title>Generator Sertifikat Custom</title>
    <style>
        body { font-family: sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px;}
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 600px; }
        h2 { text-align: center; margin-bottom: 20px; }
        .grid-form { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .full-width { grid-column: span 2; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 0.9rem; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 15px; background-color: #28a745; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 10px;}
        button:hover { background-color: #218838; }
        .alert { background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; text-align: center; margin-bottom: 15px; }
        .btn-dl { color: #155724; font-weight: bold; }
    </style>
</head>
<body>

<div class="card">
    <h2>Input Data Sertifikat</h2>

    <?php if ($pesan): ?>
        <div class="alert">
            <?= $pesan ?> <br>
            <a href="<?= $fileDownload ?>" download class="btn-dl">>> Download Sertifikat Siap Cetak <<</a>
        </div>
    <?php endif; ?>

    <form method="POST" class="grid-form">
        <div class="full-width">
            <label>Nama Penerima</label>
            <input type="text" name="nama_penerima" required>
        </div>
        
        <div>
            <label>NIM</label>
            <input type="text" name="nim_penerima" required>
        </div>
        <div>
            <label>Nomor Sertifikat</label>
            <input type="text" name="no_sertifikat" required>
        </div>

        <div>
            <label>Tahun Sertifikat</label>
            <input type="text" name="thn_sertifikat" value="2024" required>
        </div>
        <div>
            <label>Tahun Pelaksanaan</label>
            <input type="text" name="thn_laksana" value="2024" required>
        </div>

        <div class="full-width">
            <label>Tanggal Pelaksanaan</label>
            <input type="text" name="tgl_laksana" placeholder="Contoh: 17 Agustus 2024" required>
        </div>

        <div class="full-width">
            <label>Nama Kepala Desa</label>
            <input type="text" name="kades" required>
        </div>

        <button type="submit" class="full-width">PROSES SERTIFIKAT</button>
    </form>
</div>

</body>
</html>