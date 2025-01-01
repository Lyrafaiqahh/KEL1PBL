<?php
session_start();

if (!isset($_SESSION['nim'])) {
    die("Anda belum login. Silakan login terlebih dahulu.");
}

$nim = $_SESSION['nim'];
$message = "";

include 'db_connection.php';

// Fungsi untuk menyimpan data ke database
function createData($conn, $sql, $params) {
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    if ($stmt && sqlsrv_execute($stmt)) {
        return "Data berhasil diunggah dan dicatat!";
    } else {
        return "Error: " . print_r(sqlsrv_errors(), true);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menangani upload kompen
    if (isset($_POST['upload_kompen'])) {
        $jumlah_jam = $_POST['jumlah_jam'];
        $tanggal_kompen = $_POST['tanggal_kompen'];
        $softfile_kompen = $_FILES['softfile_kompen'];

        $upload_dir = "uploads/kompen/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_name = str_replace(' ', '_', $softfile_kompen['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($softfile_kompen['tmp_name'], $file_path)) {
            $sql = "INSERT INTO kompen (jumlah_kompen, tanggal_selesai, file_kompen, nim) VALUES (?, ?, ?, ?)";
            $params = [$jumlah_jam, $tanggal_kompen, $file_path, $nim];
            $message = createData($conn, $sql, $params);
        } else {
            $message = "Gagal mengunggah file.";
        }
    }

    // Menangani upload skripsi
if (isset($_POST['upload_skripsi'])) {
    $judul_skripsi = $_POST['judul_skripsi'];
    $softfile_nilai = $_FILES['softfile_nilai'];
    $softfile_surat = $_FILES['softfile_surat'];

    $upload_dir = "uploads/skripsi/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $file_nilai_path = $upload_dir . basename($softfile_nilai['name']);
    $file_surat_path = $upload_dir . basename($softfile_surat['name']);

    if (move_uploaded_file($softfile_nilai['tmp_name'], $file_nilai_path) && move_uploaded_file($softfile_surat['tmp_name'], $file_surat_path)) {
        $sql = "INSERT INTO skripsi (judul, nilai, lembar_pengesahan, nim) VALUES (?, ?, ?, ?)";
        $params = [$judul_skripsi, $file_nilai_path, $file_surat_path, $nim];
        $message = createData($conn, $sql, $params);
    } else {
        $message = "Gagal mengunggah file skripsi.";
    }
}


    if (isset($_POST['upload_pkl'])) {
        // Pastikan file-file ini ada sebelum mengaksesnya
        $softfile_laporan = isset($_FILES['softfile_laporan']) ? $_FILES['softfile_laporan'] : null;
        $softfile_sertifikat = isset($_FILES['softfile_surat']) ? $_FILES['softfile_surat'] : null;  // Perhatikan nama inputan file
        $softfile_nilai = isset($_FILES['softfile_penilaian']) ? $_FILES['softfile_penilaian'] : null;  // Perhatikan nama inputan file
        $id_jurusan = isset($_POST['id_jurusan']) ? $_POST['id_jurusan'] : null;
    
        // Cek jika id_jurusan dikirimkan
        if (!$id_jurusan) {
            $message = "ID jurusan tidak ditemukan.";
        } elseif ($softfile_laporan && $softfile_sertifikat && $softfile_nilai) {
            $upload_dir = "uploads/pkl/";
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
            // Tentukan path untuk masing-masing file
            $file_laporan_path = $upload_dir . basename($softfile_laporan['name']);
            $file_sertifikat_path = $upload_dir . basename($softfile_sertifikat['name']);
            $file_nilai_path = $upload_dir . basename($softfile_nilai['name']);
    
            // Pindahkan file ke server dan cek apakah file berhasil diunggah
            if (move_uploaded_file($softfile_laporan['tmp_name'], $file_laporan_path) &&
                move_uploaded_file($softfile_sertifikat['tmp_name'], $file_sertifikat_path) &&
                move_uploaded_file($softfile_nilai['tmp_name'], $file_nilai_path)) {
    
                // Query SQL untuk menyimpan data PKL
                $sql = "INSERT INTO pkl (laporan_pkl, sertifikat_pkl, nilai_pkl, nim, id_jurusan) VALUES (?, ?, ?, ?, ?)";
                $params = [$file_laporan_path, $file_sertifikat_path, $file_nilai_path, $nim, $id_jurusan];
                $message = createData($conn, $sql, $params);
            } else {
                $message = "Gagal mengunggah file PKL. Pastikan semua file yang dibutuhkan diunggah dengan benar.";
            }
        } else {
            $message = "Gagal mengunggah file PKL. Pastikan semua file yang dibutuhkan diunggah.";
        }
    }if (isset($_POST['upload_pkl'])) {
        // Pastikan file-file ini ada sebelum mengaksesnya
        $softfile_laporan = isset($_FILES['softfile_laporan']) ? $_FILES['softfile_laporan'] : null;
        $softfile_sertifikat = isset($_FILES['softfile_surat']) ? $_FILES['softfile_surat'] : null;
        $softfile_nilai = isset($_FILES['softfile_penilaian']) ? $_FILES['softfile_penilaian'] : null;  // Perhatikan nama inputan file
        $id_jurusan = isset($_POST['id_jurusan']) ? $_POST['id_jurusan'] : null;
    
        // Cek jika id_jurusan dikirimkan
        if (!$id_jurusan) {
            $message = "ID jurusan tidak ditemukan.";
        } elseif ($softfile_laporan && $softfile_sertifikat && $softfile_nilai) {
            $upload_dir = "uploads/pkl/";
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
            // Tentukan path untuk masing-masing file
            $file_laporan_path = $upload_dir . basename($softfile_laporan['name']);
            $file_sertifikat_path = $upload_dir . basename($softfile_sertifikat['name']);
            $file_nilai_path = $upload_dir . basename($softfile_nilai['name']);
    
            // Pindahkan file ke server dan cek apakah file berhasil diunggah
            if (move_uploaded_file($softfile_laporan['tmp_name'], $file_laporan_path) &&
                move_uploaded_file($softfile_sertifikat['tmp_name'], $file_sertifikat_path) &&
                move_uploaded_file($softfile_nilai['tmp_name'], $file_nilai_path)) {
    
                // Query SQL untuk menyimpan data PKL
                $sql = "INSERT INTO pkl (laporan_pkl, sertifikat_pkl, nilai_pkl, nim, id_jurusan) VALUES (?, ?, ?, ?, ?)";
                $params = [$file_laporan_path, $file_sertifikat_path, $file_nilai_path, $nim, $id_jurusan];
                $message = createData($conn, $sql, $params);
            } else {
                $message = "Gagal mengunggah file PKL. Pastikan semua file yang dibutuhkan diunggah dengan benar.";
            }
        } else {
            $message = "Gagal mengunggah file PKL. Pastikan semua file yang dibutuhkan diunggah.";
        }
    }
    
   // Menangani upload SKKM
   if (isset($_POST['upload_skkm'])) {
    $jenis_sertifikat = $_POST['jenis_sertifikat'];
    $softfile_skkm = $_FILES['softfile_skkm'];

    $upload_dir = "uploads/skkm/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $file_skkm_path = $upload_dir . basename($softfile_skkm['name']);

    // Set poin_skkm based on jenis_sertifikat
    switch ($jenis_sertifikat) {
        case 'seminar':
            $poin_skkm = 1;
            break;
        case 'kepanitiaan':
            $poin_skkm = 2;
            break;
        case 'lomba':
            $poin_skkm = 3;
            break;
        default:
            $poin_skkm = 0; // Default in case of an unknown jenis_sertifikat
            break;
    }

    // Generate no_sertifikat by getting the last one from the database and incrementing
    $sql_last_sertifikat = "SELECT no_sertifikat FROM sertifikat ORDER BY no_sertifikat DESC LIMIT 1";
    $result = sqlsrv_query($conn, $sql_last_sertifikat);
    if ($result) {
        $row = sqlsrv_fetch_array($result);
        $last_no_sertifikat = $row['no_sertifikat'];
        $no_sertifikat = str_pad((intval($last_no_sertifikat) + 1), 5, '0', STR_PAD_LEFT); // Assuming no_sertifikat is numeric
    } else {
        $no_sertifikat = '00001'; // Default to first sertifikat if no entries exist
    }

    // Validate and upload file
    if (move_uploaded_file($softfile_skkm['tmp_name'], $file_skkm_path)) {
        $sql = "INSERT INTO sertifikat (no_sertifikat, file_sertifikat, jenis_sertifikat, poin_skkm, nim) VALUES (?, ?, ?, ?, ?)";
        $params = [$no_sertifikat, $file_skkm_path, $jenis_sertifikat, $poin_skkm, $nim];
        $message = createData($conn, $sql, $params);
    } else {
        $message = "Gagal mengunggah file SKKM.";
    }
}


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Arsip.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
  <title>Arsip Berkas Mahasiswa</title>
</head>
<body>
<header>
    <div class="background"></div>
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
    </div>
  </header>

  <main class="main-content">
    <!-- Bagian Kompen -->
    <section id="kompen">
        <h2>Kompen</h2>
        <form action="Arsip.php" method="post" enctype="multipart/form-data">
            <label for="jumlah_jam">Jumlah Jam:</label>
            <input type="number" name="jumlah_jam" id="jumlah_jam" required>
            <br>
            <label for="tanggal_kompen">Tanggal Selesai:</label>
            <input type="date" name="tanggal_kompen" id="tanggal_kompen" required>
            <br>
            <label for="softfile_kompen">Upload File Kompen:</label>
            <input type="file" name="softfile_kompen" id="softfile_kompen" required>
            <br>
            <button type="submit" name="upload_kompen">Unggah Kompen</button>
        </form>
    </section>

    <!-- Bagian Skripsi -->
    <section id="skripsi">
        <h2>Skripsi</h2>
        <form action="Arsip.php" method="POST" enctype="multipart/form-data">
            <label>Judul Skripsi:</label>
            <input type="text" name="judul_skripsi" required><br>
            <label>Upload Nilai Skripsi:</label>
            <input type="file" name="softfile_nilai" required><br>
            <label>Upload Lembar Pengesahan Skripsi:</label>
            <input type="file" name="softfile_surat" required><br>
            <button type="submit" name="upload_skripsi">Upload Skripsi</button>
        </form>
    </section>

    <!-- Bagian PKL -->
    <section id="pkl">
    <h2>PKL</h2>
    <form action="Arsip.php" method="POST" enctype="multipart/form-data">
        <label>Upload Laporan PKL:</label>
        <input type="file" name="softfile_laporan" required><br>
        <label>Upload Sertifikat PKL:</label>
        <input type="file" name="softfile_surat" required><br>
        <label>Upload Penilaian PKL:</label>
        <input type="file" name="softfile_penilaian" required><br>
        
        <label for="id_jurusan">Pilih Jurusan:</label>
        <select name="id_jurusan" required>
            <option value="1">TI (Teknik Informatika)</option>
            <option value="2">SIB (Sistem Informasi Bisnis)</option>
        </select><br>
        
        <button type="submit" name="upload_pkl">Upload PKL</button>
    </form>
</section>

            <!-- Bagian SKKM -->
            <section id="skkm">
    <h2>SKKM</h2>
    <form action="Arsip.php" method="POST" enctype="multipart/form-data">
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
</html>