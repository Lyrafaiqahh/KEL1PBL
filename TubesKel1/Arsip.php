<?php
// Periksa apakah formulir dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['upload_kompen'])) {
        // Validasi jumlah jam
        $jumlah_jam = $_POST['jumlah_jam'];
        if ($jumlah_jam < 0) {
            die("Jumlah jam tidak boleh negatif.");
        }

        // Logika untuk menangani upload kompen
        $tanggal_kompen = $_POST['tanggal_kompen'];
        $softfile_kompen = $_FILES['softfile_kompen'];

        // Validasi file upload
        if ($softfile_kompen['error'] !== UPLOAD_ERR_OK) {
            die("Terjadi kesalahan saat mengunggah file.");
        }

        // Simpan file dan validasi (Contoh path penyimpanan)
        $upload_dir = "uploads/kompen/";
        $file_path = $upload_dir . basename($softfile_kompen['name']);
        
        if (!move_uploaded_file($softfile_kompen['tmp_name'], $file_path)) {
            die("Gagal menyimpan file kompen.");
        }

        echo "Kompen berhasil diunggah.";
    }
}

    if (isset($_POST['upload_skripsi'])) {
        $judul_skripsi = $_POST['judul_skripsi'];
        $softfile_nilai = $_FILES['softfile_nilai'];
        $softfile_surat = $_FILES['softfile_surat'];

        $upload_dir = "uploads/skripsi/";
        move_uploaded_file($softfile_nilai['tmp_name'], $upload_dir . basename($softfile_nilai['name']));
        move_uploaded_file($softfile_surat['tmp_name'], $upload_dir . basename($softfile_surat['name']));
        echo "Skripsi berhasil diunggah.";
    }

    if (isset($_POST['upload_pkl'])) {
        $softfile_laporan = $_FILES['softfile_laporan'];
        $softfile_surat = $_FILES['softfile_surat'];
        $softfile_penilaian = $_FILES['softfile_penilaian'];

        $upload_dir = "uploads/pkl/";
        move_uploaded_file($softfile_laporan['tmp_name'], $upload_dir . basename($softfile_laporan['name']));
        move_uploaded_file($softfile_surat['tmp_name'], $upload_dir . basename($softfile_surat['name']));
        move_uploaded_file($softfile_penilaian['tmp_name'], $upload_dir . basename($softfile_penilaian['name']));
        echo "Laporan PKL berhasil diunggah.";
    }

    if (isset($_POST['upload_skkm'])) {
        $jenis_sertifikat = $_POST['jenis_sertifikat'];
        $softfile_skkm = $_FILES['softfile_skkm'];

        $upload_dir = "uploads/skkm/";
        move_uploaded_file($softfile_skkm['tmp_name'], $upload_dir . basename($softfile_skkm['name']));
        echo "Sertifikat SKKM berhasil diunggah.";
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Arsip.css?v=1.0.1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
  <title>Arsip Berkas Mahasiswa</title>
</head>
<body>
  <header>
    <div class="top-nav">
      <div class="logo">
        <img src="img/logo.png" alt="Logo">
      </div>
      <div class="right-actions">
        <div class="menu-bar">
          <ul>
          <li class="menu-item"><a href="dashboard.html">Beranda</a></li>
            <li class="menu-item active"><a href="Arsip.php">Arsip Berkas</a></li>
            <li class="menu-item"><a href="Form.html">Form Beta</a></li>
            <li class="menu-item"><a href="FAQ.html">FAQ</a></li>
          
          </ul>
        </div>
        <!-- Profile Icon -->
        <div class="profile">
          <img src="img/profile.jpg" alt="Profile Avatar">
        </div>
      </div>
    </div>
  </header>

  <main class="main-content">
  <!-- Bagian Kompen -->
  <section id="kompen">
        <h2>Kompen</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Jumlah Jam Kompen:</label>
            <input type="number" name="jumlah_jam" min="0" required>
            <label>Tanggal Penyelesaian Kompen:</label>
            <input type="date" name="tanggal_kompen" required><br>
            <label>Upload Softfile Kompen:</label>
            <input type="file" name="softfile_kompen" required><br>
            <button type="submit" name="upload_kompen">Upload Kompen</button>
        </form>
    </section>

    <!-- Bagian Skripsi -->
    <section id="skripsi">
        <h2>Skripsi</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Judul Skripsi:</label>
            <input type="text" name="judul_skripsi" required><br>
            <label>Upload Nilai Skripsi:</label>
            <input type="file" name="softfile_nilai" required><br>
            <label>Upload Lembar Pengesahan Skripsi:</label>
            <input type="file" name="softfile_surat" required><br>
            <button type="submit" name="upload_skripsi">Upload Skripsi</button>
        </form>
    </section>

    <
    <!-- Bagian PKL -->
    <section id="pkl">
        <h2>PKL</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Upload Laporan PKL:</label>
            <input type="file" name="softfile_laporan" required><br>
            <label>Upload Sertifikat PKL:</label>
            <input type="file" name="softfile_surat" required><br>
            <label>Upload Penilaian PKL:</label>
            <input type="file" name="softfile_penilaian" required><br>
            <button type="submit" name="upload_pkl">Upload PKL</button>
        </form>
    </section>

    <!-- Bagian SKKM -->
    <section id="skkm">
        <h2>SKKM</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Pilih Jenis Sertifikat:</label>
            <select name="jenis_sertifikat">
                <option value="seminar">Seminar</option>
                <option value="kepanitiaan">Kepanitiaan</option>
                <option value="lomba">Lomba</option>
            </select><br>
            <label>Upload Sertifikat SKKM:</label>
            <input type="file" name="softfile_skkm" required><br>
            <button type="submit" name="upload_skkm">Upload SKKM</button>
        </form>
    </section>
</main>
<script src="Arsip.js" defer></script>
</body>
</html>