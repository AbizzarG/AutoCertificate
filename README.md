# AutoCertificate

Generator sertifikat otomatis berbasis PHP yang menggunakan GD Library untuk membuat sertifikat personalisasi dengan template gambar.

## Fitur

- **Antarmuka Web Intuitif** - Form input yang mudah digunakan dengan tampilan modern
- **Kustomisasi Lengkap** - Dukungan untuk berbagai field sertifikat (nama, NIM, nomor sertifikat, dll)
- **Auto-Center Text** - Nama penerima otomatis diposisikan di tengah
- **Multi-Font Support** - Mendukung font Poppins dan PinyonScript untuk tampilan profesional
- **Download Langsung** - Sertifikat dapat langsung diunduh setelah dibuat

## Persyaratan Sistem

- PHP 7.0 atau lebih tinggi
- PHP GD Library (untuk manipulasi gambar)
- Web server (Apache/Nginx) atau PHP built-in server

## Instalasi

1. Clone atau download repository ini:
```bash
git clone <repository-url>
cd AutoCertificate
```

2. Pastikan PHP GD Library sudah terinstall:
```bash
php -m | grep -i gd
```

3. Jalankan web server:
```bash
php -S localhost:8000
```

4. Buka browser dan akses:
```
http://localhost:8000
```

## Struktur Folder

```
AutoCertificate/
├── index.php                    # File utama aplikasi
├── Template.png                 # Template sertifikat (background)
├── Poppins-Regular.ttf         # Font untuk teks reguler
├── PinyonScript-Regular.ttf    # Font untuk nama (style kursif)
├── hasil_sertifikat/           # Folder output sertifikat (auto-created)
│   ├── Sertifikat_*.png
└── README.md
```

## Cara Penggunaan

1. **Siapkan Template**
   - Letakkan file template sertifikat Anda dengan nama `Template.png` di folder root
   - Template harus dalam format PNG atau JPG

2. **Akses Form**
   - Buka aplikasi melalui browser
   - Isi form dengan data sertifikat:
     - Nama Penerima (akan otomatis di-center)
     - NIM
     - Nomor Sertifikat
     - Tahun Sertifikat
     - Tahun Pelaksanaan
     - Tanggal Pelaksanaan
     - Nama Kepala Desa

3. **Generate Sertifikat**
   - Klik tombol "PROSES SERTIFIKAT"
   - Sertifikat akan dibuat dan tersimpan di folder `hasil_sertifikat/`
   - Klik link download untuk mengunduh sertifikat

## Konfigurasi

### Mengubah Posisi Teks

Edit array `$dataSertifikat` di [index.php](index.php) untuk mengatur posisi dan style teks:

```php
'nama_penerima' => [
    'text'  => $_POST['nama_penerima'],
    'x'     => 'CENTER',  // atau angka untuk posisi manual
    'y'     => 760,       // posisi Y (vertikal)
    'size'  => 90,        // ukuran font
    'font'  => '/PinyonScript-Regular.ttf',
    'color' => [225, 167, 48]  // RGB color
]
```

### Parameter yang Bisa Dikonfigurasi

- `x`: Posisi horizontal (gunakan 'CENTER' untuk auto-center, atau nilai numerik)
- `y`: Posisi vertikal (dalam pixel dari atas)
- `size`: Ukuran font (dalam points)
- `font`: Path ke file font (relative dari root)
- `color`: Array RGB `[R, G, B]` (nilai 0-255)

## Contoh Output

Sertifikat yang dihasilkan akan disimpan dengan format nama:
```
Sertifikat_Nama_Penerima.png
```

Contoh: `Sertifikat_M._Abizzar_Gamadrian.png`

## Font yang Digunakan

- **Poppins Regular** - Untuk teks umum (nomor, tanggal, NIM)
- **Pinyon Script** - Untuk nama penerima (style elegant/kursif)

Anda dapat menambahkan font lain dengan meletakkan file `.ttf` di folder root dan mengupdate path di konfigurasi.

## Troubleshooting

### Error: Font tidak ditemukan
Pastikan file font berada di lokasi yang benar dan path di konfigurasi sudah tepat.

### Error: Template.png tidak ditemukan
Pastikan file template bernama persis `Template.png` (case-sensitive) dan berada di folder root.

### Gambar tidak muncul
Pastikan PHP GD Library sudah terinstall:
```bash
sudo apt-get install php-gd  # Ubuntu/Debian
```

### Permission denied pada folder hasil_sertifikat
Berikan permission write:
```bash
chmod 755 hasil_sertifikat/
```

## Teknologi

- PHP (GD Library)
- HTML5
- CSS3 (Grid Layout)

## License

Proyek ini dibuat untuk keperluan edukasi dan dapat digunakan secara bebas.

## Kontribusi

Kontribusi selalu diterima! Silakan buat pull request atau laporkan issue jika menemukan bug.

## Author

Dibuat dengan ❤️ untuk mempermudah pembuatan sertifikat
