
<?php
require_once 'koneksi.php';

// Pastikan NIM tersedia sebelum proses penghapusan.
$nim = trim($_GET['nim'] ?? '');

if ($nim === '') {
    header('Location: index.php');
    exit;
}

// Gunakan prepared statement agar parameter lebih aman.
$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM mahasiswa WHERE nim = ?"
);
mysqli_stmt_bind_param($stmt, "s", $nim);

if (mysqli_stmt_execute($stmt)) {
    $jumlahTerhapus = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($jumlahTerhapus > 0) {
        header('Location: index.php?pesan=hapus');
    } else {
        header('Location: index.php');
    }
    exit;
}

mysqli_stmt_close($stmt);
die('Data gagal dihapus. Periksa koneksi database.');
?>
