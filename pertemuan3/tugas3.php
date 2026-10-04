<?php

require_once 'koneksi.php';

// Membuat database
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS akademik";

if (mysqli_query($koneksi, $sqlCreateDB)) {
    echo "Database berhasil dibuat atau sudah ada.<br>";
} else {
    echo "Error membuat database: " . mysqli_error($koneksi) . "<br>";
}

// Mengatur charset
mysqli_set_charset($koneksi, "utf8mb4");

// Memilih database
if (mysqli_select_db($koneksi, "akademik")) {
    echo "Database akademik berhasil dipilih.<br><br>";
} else {
    echo "Gagal memilih database: " . mysqli_error($koneksi) . "<br>";
}


// ===============================
// TABEL DARI CONTOH 2
// ===============================

$sqlCreateTables = [

    // Tabel mahasiswa
    "CREATE TABLE IF NOT EXISTS mahasiswa (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nim VARCHAR(15) NOT NULL UNIQUE,
        nama VARCHAR(100) NOT NULL,
        email VARCHAR(120) NOT NULL UNIQUE,
        prodi VARCHAR(80) NOT NULL,
        angkatan YEAR NOT NULL,
        ipk DECIMAL(3,2) DEFAULT 0.00
    ) ENGINE=InnoDB",

    // Tabel dosen
    "CREATE TABLE IF NOT EXISTS dosen (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nidn VARCHAR(20) NOT NULL UNIQUE,
        nama VARCHAR(100) NOT NULL,
        email VARCHAR(120) NOT NULL UNIQUE
    ) ENGINE=InnoDB",

    // Tabel mata kuliah
    "CREATE TABLE IF NOT EXISTS mata_kuliah (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        kode_mk VARCHAR(12) NOT NULL UNIQUE,
        nama_mk VARCHAR(100) NOT NULL,
        sks TINYINT UNSIGNED NOT NULL,
        dosen_id BIGINT UNSIGNED,

        CONSTRAINT fk_matakuliah_dosen_id
            FOREIGN KEY (dosen_id)
            REFERENCES dosen(id)
            ON UPDATE CASCADE
            ON DELETE SET NULL
    ) ENGINE=InnoDB",

    // Tabel KRS
    "CREATE TABLE IF NOT EXISTS krs (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        mahasiswa_id BIGINT UNSIGNED NOT NULL,
        semester TINYINT UNSIGNED NOT NULL,
        tahun_ajaran VARCHAR(9) NOT NULL,

        CONSTRAINT uq_krs_mahasiswa_sem_thn UNIQUE (
            mahasiswa_id,
            semester,
            tahun_ajaran
        ),

        CONSTRAINT fk_krs_mahasiswa_id
            FOREIGN KEY (mahasiswa_id)
            REFERENCES mahasiswa(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
    ) ENGINE=InnoDB",

    // Tabel detail KRS
    "CREATE TABLE IF NOT EXISTS mk_krs (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        krs_id BIGINT UNSIGNED NOT NULL,
        mata_kuliah_id BIGINT UNSIGNED NOT NULL,

        CONSTRAINT fk_mkkrs_krs_id
            FOREIGN KEY (krs_id)
            REFERENCES krs(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE,

        CONSTRAINT fk_mkkrs_matakuliah_id
            FOREIGN KEY (mata_kuliah_id)
            REFERENCES mata_kuliah(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
    ) ENGINE=InnoDB"
];


// Menjalankan semua query
foreach ($sqlCreateTables as $query) {
    if (mysqli_query($koneksi, $query)) {
        echo "Tabel berhasil dibuat atau sudah ada.<br>";
    } else {
        echo "Gagal membuat tabel: " . mysqli_error($koneksi) . "<br>";
    }
}


// ===============================
// MODIFIKASI 1
// Menambahkan field status
// ===============================

$cekStatus = mysqli_query(
    $koneksi,
    "SHOW COLUMNS FROM mahasiswa LIKE 'status'"
);

if (mysqli_num_rows($cekStatus) == 0) {

    $sqlTambahStatus = "
        ALTER TABLE mahasiswa
        ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'Aktif'
        AFTER ipk
    ";

    if (mysqli_query($koneksi, $sqlTambahStatus)) {
        echo "Modifikasi 1 berhasil: field status ditambahkan.<br>";
    } else {
        echo "Gagal menambahkan field status: "
            . mysqli_error($koneksi) . "<br>";
    }

} else {
    echo "Modifikasi 1: field status sudah tersedia.<br>";
}


// ===============================
// MODIFIKASI 2
// Membuat tabel nilai
// ===============================

$sqlNilai = "
    CREATE TABLE IF NOT EXISTS nilai (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        mahasiswa_id BIGINT UNSIGNED NOT NULL,
        mata_kuliah_id BIGINT UNSIGNED NOT NULL,
        nilai_angka DECIMAL(5,2) NOT NULL,
        nilai_huruf VARCHAR(2) NOT NULL,

        CONSTRAINT fk_nilai_mahasiswa
            FOREIGN KEY (mahasiswa_id)
            REFERENCES mahasiswa(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE,

        CONSTRAINT fk_nilai_matakuliah
            FOREIGN KEY (mata_kuliah_id)
            REFERENCES mata_kuliah(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
    ) ENGINE=InnoDB
";

if (mysqli_query($koneksi, $sqlNilai)) {
    echo "Modifikasi 2 berhasil: tabel nilai dibuat.<br>";
} else {
    echo "Gagal membuat tabel nilai: "
        . mysqli_error($koneksi) . "<br>";
}


// ===============================
// HASIL MODIFIKASI
// ===============================

echo "<br>";
echo "<strong>=== HASIL MODIFIKASI TUGAS 3 ===</strong><br>";
echo "Database: akademik<br>";
echo "Field baru: status pada tabel mahasiswa<br>";
echo "Tabel baru: nilai<br>";
echo "Relasi tabel nilai: mahasiswa dan mata_kuliah<br>";


// Menutup koneksi
mysqli_close($koneksi);

?>