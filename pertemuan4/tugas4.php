<?php

require_once 'koneksi.php';

mysqli_select_db($koneksi, 'akademik');

echo "========================================\n";
echo "        TUGAS 4 - HASIL MODIFIKASI\n";
echo "========================================\n\n";


// ==================================================
// BAGIAN 1 - MODIFIKASI DARI CONTOH 1
// INSERT DATA MAHASISWA
// ==================================================

echo "=== 1. INSERT DATA MAHASISWA ===\n";

$sqlInsert = "INSERT IGNORE INTO mahasiswa (nim, nama, email, prodi, angkatan, ipk) VALUES
('2026001', 'Andi Pratama', 'andi@kampus.ac.id', 'Teknik Informatika', 2026, 3.75),
('2026002', 'Siti Rahma', 'siti@kampus.ac.id', 'Sistem Informasi', 2026, 3.82),
('2026003', 'Budi Santoso', 'budi@kampus.ac.id', 'Teknik Informatika', 2026, 3.20),
('2026004', 'Rina Maharani', 'rina@kampus.ac.id', 'Sistem Informasi', 2026, 3.60)";

if (mysqli_query($koneksi, $sqlInsert)) {
    echo "[INSERT] Data mahasiswa berhasil dimasukkan ke tabel.\n\n";
} else {
    echo "[ERROR] Gagal memasukkan data: " . mysqli_error($koneksi) . "\n\n";
}


// ==================================================
// SELECT MAHASISWA DENGAN IPK >= 3.50
// ==================================================

echo "--- Hasil Query SELECT ---\n";

$sqlSelect = "SELECT nim, nama, prodi, ipk
              FROM mahasiswa
              WHERE ipk >= 3.50
              ORDER BY ipk DESC, nama ASC
              LIMIT 10";

$resultSelect = mysqli_query($koneksi, $sqlSelect);

if ($resultSelect && mysqli_num_rows($resultSelect) > 0) {

    while ($row = mysqli_fetch_assoc($resultSelect)) {
        echo "NIM   : " . $row['nim'] . "\n";
        echo "Nama  : " . $row['nama'] . "\n";
        echo "Prodi : " . $row['prodi'] . "\n";
        echo "IPK   : " . $row['ipk'] . "\n";
        echo "-----------------------------\n";
    }

} else {
    echo "Tidak ada data mahasiswa dengan kriteria tersebut.\n";
}


// ==================================================
// BAGIAN 2 - DARI CONTOH 2
// UPDATE DATA IPK
// ==================================================

echo "\n=== 2. PROSES UPDATE DATA ===\n";

$sqlUpdate = "UPDATE mahasiswa
              SET ipk = 3.40
              WHERE nim = '2026003'";

if (mysqli_query($koneksi, $sqlUpdate)) {
    echo "Data IPK mahasiswa dengan NIM 2026003 berhasil diubah menjadi 3.40.\n\n";
} else {
    echo "Gagal UPDATE: " . mysqli_error($koneksi) . "\n\n";
}


// ==================================================
// REKAP JUMLAH MAHASISWA PER PRODI
// MODIFIKASI: HAVING COUNT(*) >= 2
// ==================================================

echo "=== 3. REKAP JUMLAH MAHASISWA PER PRODI ===\n";

$sqlRekap = "SELECT prodi, COUNT(*) AS jumlah_mahasiswa
             FROM mahasiswa
             GROUP BY prodi
             HAVING COUNT(*) >= 2
             ORDER BY jumlah_mahasiswa DESC";

$resultRekap = mysqli_query($koneksi, $sqlRekap);

if ($resultRekap && mysqli_num_rows($resultRekap) > 0) {

    while ($row = mysqli_fetch_assoc($resultRekap)) {
        echo "Prodi  : " . $row['prodi'] . "\n";
        echo "Jumlah : " . $row['jumlah_mahasiswa'] . " mahasiswa\n";
        echo "-----------------------------\n";
    }

} else {
    echo "Tidak ada prodi yang memiliki minimal 2 mahasiswa.\n";
}


// ==================================================
// VERIFIKASI DATA SEBELUM DELETE
// ==================================================

echo "\n=== 4. VERIFIKASI DATA ===\n";

$sqlVerifikasi = "SELECT * 
                  FROM mahasiswa 
                  WHERE nim = '2026003'";

$resultVerifikasi = mysqli_query($koneksi, $sqlVerifikasi);

if ($resultVerifikasi && mysqli_num_rows($resultVerifikasi) > 0) {

    $row = mysqli_fetch_assoc($resultVerifikasi);

    echo "Data ditemukan:\n";
    echo "NIM   : " . $row['nim'] . "\n";
    echo "Nama  : " . $row['nama'] . "\n";
    echo "Prodi : " . $row['prodi'] . "\n";
    echo "IPK   : " . $row['ipk'] . "\n";

} else {
    echo "Data mahasiswa tidak ditemukan.\n";
}


// ==================================================
// DELETE DATA
// ==================================================

echo "\n=== 5. PROSES DELETE DATA ===\n";

$sqlDelete = "DELETE FROM mahasiswa
              WHERE nim = '2026003'";

if (mysqli_query($koneksi, $sqlDelete)) {
    echo "Data mahasiswa dengan NIM 2026003 berhasil dihapus dari tabel.\n";
} else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi) . "\n";
}


mysqli_close($koneksi);

?>