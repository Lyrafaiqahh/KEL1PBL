--_________________________________________________________________________________________________________________________________________________________________________________________________________________

-- Membuat database
CREATE DATABASE sibeta;
GO
USE sibeta;

--_____________________________________________________________________________________________________________________
-- Fungsi untuk mengenkripsi password
CREATE OR ALTER FUNCTION dbo.EncryptPassword(@password NVARCHAR(4000))
RETURNS NVARCHAR(4000)
AS
BEGIN
    RETURN CONVERT(NVARCHAR(4000), HASHBYTES('SHA2_256', @password), 2);
END;
GO

--_________________________________________________________________________________________________________________________________________________________________________________________________________________

-- Tabel mahasiswa
CREATE TABLE mahasiswa (
    nim VARCHAR(10) PRIMARY KEY,
    password VARCHAR(255) NOT NULL, -- Password terenkripsi 
    nama VARCHAR(100),
    tgl_lahir DATE,
    alamat VARCHAR(MAX),
    telp_mahasiswa VARCHAR(15),
    status_semester VARCHAR(50),
    telp_wali VARCHAR(15),
    id_prodi INT , -- Kolom id_prodi untuk foreign key ke prodi
    id_jurusan INT, -- Kolom id_jurusan untuk foreign key ke jurusan
	role INT DEFAULT 2,
    CONSTRAINT FK_mahasiswa_prodi FOREIGN KEY (id_prodi) REFERENCES prodi(id_prodi),
    CONSTRAINT FK_mahasiswa_jurusan FOREIGN KEY (id_jurusan) REFERENCES jurusan(id_jurusan)
);

-- Tabel admin
CREATE TABLE admin (
    nip VARCHAR(20) PRIMARY KEY,
    password VARCHAR(255) NOT NULL, -- Password terenkripsi 
    nama VARCHAR(100),
    role INT DEFAULT 1,
    jabatan VARCHAR(50),
    telp_admin VARCHAR(15),
    email VARCHAR(100)
);

-- Tabel jurusan
CREATE TABLE jurusan (
    id_jurusan INT PRIMARY KEY IDENTITY(1,1),
    nama_jurusan VARCHAR(100)
);

-- Tabel prodi
CREATE TABLE prodi (
    id_prodi INT PRIMARY KEY IDENTITY(1,1),
    nama_prodi VARCHAR(100),
    kelas VARCHAR(10)
);

-- Tabel kompen
CREATE TABLE kompen (
    id_kompen INT PRIMARY KEY IDENTITY(1,1),
    jumlah_kompen INT,
    tanggal_selesai DATE,
    file_kompen VARCHAR(MAX),
    nim VARCHAR(10), -- Kolom nim untuk foreign key ke mahasiswa
    CONSTRAINT FK_kompen_mahasiswa FOREIGN KEY (nim) REFERENCES mahasiswa(nim)
);

-- Tabel pkl
CREATE TABLE pkl (
    id_pkl INT PRIMARY KEY IDENTITY(1,1),
    laporan_pkl VARCHAR(MAX),
	sertifikat_pkl VARCHAR(MAX),
    nilai_pkl VARCHAR(MAX),
    nim VARCHAR(10), -- Kolom nim untuk foreign key ke mahasiswa
    id_jurusan INT, -- Kolom id_jurusan untuk foreign key ke jurusan
    CONSTRAINT FK_pkl_mahasiswa FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT FK_pkl_jurusan FOREIGN KEY (id_jurusan) REFERENCES jurusan(id_jurusan)
);

-- Tabel sertifikat
CREATE TABLE sertifikat (
    no_sertifikat VARCHAR(20) PRIMARY KEY,
    file_sertifikat VARCHAR(MAX),
    jenis_sertifikat VARCHAR(100),
    poin_skkm INT,
    nim VARCHAR(10), -- Kolom nim untuk foreign key ke mahasiswa
    CONSTRAINT FK_sertifikat_mahasiswa FOREIGN KEY(nim) REFERENCES mahasiswa(nim)
);

-- Tabel skripsi
CREATE TABLE skripsi (
    id_skripsi INT PRIMARY KEY IDENTITY(1,1),
    judul VARCHAR(500),
	nilai VARCHAR(MAX),
	lembar_pengesahan VARCHAR(MAX),
    nim VARCHAR(10), -- Kolom nim untuk foreign key ke mahasiswa
    CONSTRAINT FK_skripsi_mahasiswa FOREIGN KEY (nim) REFERENCES mahasiswa(nim)
);

-- Tabel berkas_penyelesaian
CREATE TABLE form_berkas (
    id_form INT PRIMARY KEY IDENTITY(1,1),
    form_jurusan VARCHAR(MAX),
    form_perpustakaan VARCHAR(MAX),
    form_beta VARCHAR(MAX),
	nim VARCHAR(10), -- Kolom nim untuk foreign key ke mahasiswa
    CONSTRAINT FK_berkas_mahasiswa FOREIGN KEY (nim) REFERENCES mahasiswa(nim)
);

-- Tabel faq
CREATE TABLE faq (
    id_faq INT PRIMARY KEY IDENTITY(1,1),
    pertanyaan VARCHAR(MAX),
    jawaban VARCHAR(MAX),
    nim VARCHAR(10), -- Kolom nim untuk foreign key ke mahasiswa
    CONSTRAINT FK_kuisioner_mahasiswa FOREIGN KEY (nim) REFERENCES mahasiswa(nim)
);

--_________________________________________________________________________________________________________________________________________________________________________________________________________________

-- View kompen
CREATE VIEW view_kompen AS
SELECT 
    m.nim,
    m.nama AS nama_mahasiswa,
    j.nama_jurusan,
    k.jumlah_kompen,
    k.tanggal_selesai,
    k.file_kompen
FROM 
    mahasiswa m
JOIN 
    jurusan j ON m.id_jurusan = j.id_jurusan
JOIN 
    kompen k ON m.nim = k.nim;

-- View pkl
CREATE VIEW view_pkl AS
SELECT 
    m.nim,
    m.nama AS nama_mahasiswa,
    j.nama_jurusan,
    p.laporan_pkl,
    p.sertifikat_pkl,
    p.nilai_pkl
FROM 
    mahasiswa m
JOIN 
    jurusan j ON m.id_jurusan = j.id_jurusan
JOIN 
    pkl p ON m.nim = p.nim;

-- View skkm
CREATE VIEW view_skkm AS
SELECT 
    m.nim,
    m.nama AS nama_mahasiswa,
    j.nama_jurusan,
    s.jenis_sertifikat,
    s.poin_skkm
FROM 
    mahasiswa m
JOIN 
    jurusan j ON m.id_jurusan = j.id_jurusan
JOIN 
    sertifikat s ON m.nim = s.nim;

-- View skripsi
CREATE VIEW view_skripsi AS
SELECT 
    m.nim,
    m.nama AS nama_mahasiswa,
    j.nama_jurusan,
    s.judul,
    s.nilai,
    s.lembar_pengesahan
FROM 
    mahasiswa m
JOIN 
    jurusan j ON m.id_jurusan = j.id_jurusan
JOIN 
    skripsi s ON m.nim = s.nim;

-- View data mahasiswa
CREATE VIEW view_mahasiswa_lengkap AS
SELECT 
    m.nim,
    m.nama AS nama_mahasiswa,
    m.tgl_lahir,
    m.alamat,
    m.telp_mahasiswa,
    m.status_semester,
    m.telp_wali,
    p.nama_prodi,
    j.nama_jurusan
FROM 
    mahasiswa m
JOIN 
    prodi p ON m.id_prodi = p.id_prodi
JOIN 
    jurusan j ON m.id_jurusan = j.id_jurusan;

-- View faq
CREATE VIEW view_faq AS
SELECT 
    f.id_faq,
    m.nim,
    m.nama AS nama_mahasiswa,
    f.pertanyaan,
    f.jawaban
FROM 
    faq f
JOIN 
    mahasiswa m ON f.nim = m.nim;

--__________________________________________________________________________________________________________

-- Trigger untuk hashing password mahasiswa
CREATE TRIGGER trg_hash_password_mahasiswa
ON mahasiswa
INSTEAD OF INSERT
AS
BEGIN
	INSERT INTO mahasiswa (nim, password, nama, tgl_lahir, alamat, telp_mahasiswa, status_semester, telp_wali, id_prodi, id_jurusan, role)
    SELECT 
        nim, 
        HASHBYTES('SHA2_256', password), -- Menggunakan SHA256 untuk hashing password
        nama, tgl_lahir, alamat, telp_mahasiswa, status_semester, telp_wali, id_prodi, id_jurusan, role
    FROM inserted;
END;

-- Trigger untuk hashing password admin
CREATE TRIGGER trg_hash_password_admin
ON admin
INSTEAD OF INSERT
AS
BEGIN
    INSERT INTO admin (nip, password, nama, role, jabatan, telp_admin, email)
    SELECT 
        nip, 
        HASHBYTES('SHA2_256', password), -- Menggunakan SHA256 untuk hashing password
        nama, role, jabatan, telp_admin, email
    FROM inserted;
END;

-- Trigger Isi default file_kompen jika NULL saat insert
CREATE TRIGGER trg_default_file_kompen
ON kompen
AFTER INSERT
AS
BEGIN
    UPDATE kompen
    SET file_kompen = 'File belum diunggah'
    WHERE file_kompen IS NULL;
END;

--_____________________________________________________________________________________________________________________

-- Stored Procedure untuk Menambahkan Mahasiswa
CREATE OR ALTER PROCEDURE sp_InsertMahasiswa
    @nim VARCHAR(10),
    @password NVARCHAR(4000),
    @nama NVARCHAR(100),
    @tgl_lahir DATE,
    @alamat NVARCHAR(MAX),
    @telp_mahasiswa VARCHAR(15),
    @status_semester NVARCHAR(50),
	@telp_wali VARCHAR(15),
    @id_prodi INT,
    @id_jurusan INT
AS
BEGIN
    SET NOCOUNT ON;
    INSERT INTO mahasiswa (nim, password, nama, tgl_lahir, alamat, telp_mahasiswa, status_semester, telp_wali, id_prodi, id_jurusan)
    VALUES (
        @nim,
        dbo.EncryptPassword(@password),
        @nama,
		@tgl_lahir,
        @alamat,
        @telp_mahasiswa,
        @status_semester,
        @telp_wali,
        @id_prodi,
        @id_jurusan
    );
END;
GO

-- Stored Procedure untuk Menambahkan Admin
CREATE OR ALTER PROCEDURE sp_InsertAdmin
    @nip VARCHAR(20),
    @password NVARCHAR(4000),
    @nama NVARCHAR(100),
    @role INT,
    @jabatan NVARCHAR(50),
    @telp_admin VARCHAR(15),
    @email NVARCHAR(100)
AS
BEGIN
	SET NOCOUNT ON;
    INSERT INTO admin (nip, password, nama, role, jabatan, telp_admin, email)
    VALUES (
        @nip,
        dbo.EncryptPassword(@password),
        @nama,
        @role,
        @jabatan,
        @telp_admin,
        @email
    );
END;
GO

--_________________________________________________________________________________________________________________________________________________________________________________________________________________

-- Insert data into mahasiswa
INSERT INTO mahasiswa (nim, password, nama, tgl_lahir, alamat, telp_mahasiswa, status_semester, telp_wali, id_prodi, id_jurusan)
VALUES 
('2341760035', 'pass1234', 'Qusnul Diah Mawanti', '2005-02-25', 'Bojonegoro', '085234572917', 'Aktif', '085612345678', 1, 1),
('2341760013', 'pass1234', 'Lyra Faiqah Bilqil', '2004-07-31', 'Sidoarjo', '085655896780', 'Aktif', '082234003469', 2, 2),
('2341760115', 'pass1234', 'Muhammad Ircham Daffansyah', '2005-11-20', 'Malang', '082145343418', 'Aktif', '081333152790', 3, 3),
('2341760140', 'pass1234', 'Gegas Anugrah Derajat', '2004-04-04', 'Bandung', '084567890123', 'Aktif', '085912345678', 4, 4);

-- Insert data into admin
INSERT INTO admin (nip, password, nama, role, jabatan, telp_admin, email)
VALUES 
('198503152020121001', 'admin123', 'Ahmad Yusuf', '1', 'Administrator', '081234567891', 'admin@kampus.ac.id'),
('199002202018092002', 'dosen123', 'Drs. Maya Lestari, M.Pd.', '1', 'Dosen Utama', '082345678912', 'dosen@kampus.ac.id');

-- Insert data into jurusan
INSERT INTO jurusan (nama_jurusan)
VALUES 
('Teknologi Informasi'),
('Teknik Kimia'),
('Teknik Elektro'),
('Teknik Mesin');

-- Insert data into prodi
INSERT INTO prodi (nama_prodi, kelas)
VALUES 
('Teknik Informatika', 'A'),
('Teknik Kimia', 'B'),
('Teknik Elektro', 'A'),
('Teknik Mesin', 'C');

-- Insert data into kompen
INSERT INTO kompen (jumlah_kompen, tanggal_selesai, nim)
VALUES 
(4, '2024-10-25', '2341760035');

INSERT INTO kompen (jumlah_kompen, tanggal_selesai, file_kompen, nim)
VALUES 
(2, '2024-11-01', 'file kompen','2341760013');

-- Insert data into pkl
INSERT INTO pkl (laporan_pkl, sertifikat_pkl, nilai_pkl, nim, id_jurusan)
VALUES 
('laporan PKL', 'sertifikat PKL', 'nilai pkl', '2341760035', 1);

INSERT INTO pkl (nim, id_jurusan)
VALUES 
('2341760013', 2);

-- Insert data into pkl
INSERT INTO sertifikat (no_sertifikat, file_sertifikat, jenis_sertifikat, poin_skkm, nim)
VALUES 
('SERT001', 'Sertifikat1', 'lomba', 1, '2341760035');

INSERT INTO sertifikat (no_sertifikat, jenis_sertifikat, poin_skkm, nim)
VALUES 
('SERT002', 'kepanitiaan', 2, '2341760013');

-- Insert data into skripsi
INSERT INTO skripsi (judul, nilai, lembar_pengesahan, nim)
VALUES 
('skripsi1', 'nilai skripsi', 'pengesahan skripsi1', '2341760035');

INSERT INTO skripsi (judul, nim)
VALUES 
('skripsi2', '2341760013');

-- Insert data into form_berkas
INSERT INTO form_berkas (form_jurusan, form_perpustakaan, form_beta, nim)
VALUES 
('form jurusan1', 'form_perpustakaan1', 'form_beta1', '2341760035');

INSERT INTO form_berkas (nim)
VALUES 
('2341760013');

-- Insert data into faq
INSERT INTO faq (pertanyaan, jawaban, nim)
VALUES 
('Apa itu sistem bebas tanggungan?', 'Sistem bebas tanggungan adalah status yang diberikan kepada mahasiswa yang telah menyelesaikan semua kewajiban finansial dan administratif.', '2341760035'),
('Bagaimana cara mendapatkan status bebas tanggungan?', 'Mahasiswa dapat mendapatkan status bebas tanggungan dengan melunasi semua kewajiban finansial dan administratif yang berlaku.', '2341760013');

--_____________________________________________________________________________________________________________________

-- Menggunakan Stored Procedure)
EXEC sp_InsertMahasiswa 
    @nim = '2341760050',
    @password = 'secure123',
    @nama = 'Budi Santoso',
    @tgl_lahir = '2004-11-16',
    @alamat = 'Jakarta',
    @telp_mahasiswa = '085676980123',
    @status_semester = 'Aktif',
    @telp_wali = '085733435642',
	@id_prodi = 1,
    @id_jurusan = 1;

EXEC sp_InsertAdmin 
    @nip = '199010102022001',
    @password = 'admin456',
    @nama = 'Rahmania',
    @role = 1,
    @jabatan = 'Administrator',
    @telp_admin = '081301028426',
	@email = 'rahmania@kampus.ac.id';

--_________________________________________________________________________________________________________________________________________________________________________________________________________________

-- Menampilkan semua data dari tabel mahasiswa
SELECT * FROM mahasiswa;

-- Menampilkan semua data dari tabel admin
SELECT * FROM admin;

-- Menampilkan semua data dari tabel jurusan
SELECT * FROM jurusan;

-- Menampilkan semua data dari tabel prodi
SELECT * FROM prodi;

-- Menampilkan semua data dari tabel kompen
SELECT * FROM kompen;

-- Menampilkan semua data dari tabel pkl
SELECT * FROM pkl;

-- Menampilkan semua data dari tabel sertifikat
SELECT * FROM sertifikat;

-- Menampilkan semua data dari tabel skripsi
SELECT * FROM skripsi;

-- Menampilkan semua data dari tabel skripsi
SELECT * FROM form_berkas;

-- Menampilkan semua data dari tabel faq
SELECT * FROM faq;

--_________________________________________________________________________________________________________________________________________________________________________________________________________________

-- Menampilkan view
SELECT * FROM view_kompen;
SELECT * FROM view_pkl;
SELECT * FROM view_skkm;
SELECT * FROM view_skripsi;
SELECT * FROM view_mahasiswa_lengkap;
SELECT * FROM view_faq;

--_____________________________________________________________________________________________________________________
-- Uji Coba Data dengan Enkripsi
SELECT nim, password, nama FROM mahasiswa;
SELECT nip, password, nama FROM admin;
