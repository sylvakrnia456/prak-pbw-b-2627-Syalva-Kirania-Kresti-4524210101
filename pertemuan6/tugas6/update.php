
<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nim = trim($_POST['nim'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$prodi = trim($_POST['prodi'] ?? '');
$angkatan = filter_var($_POST['angkatan'] ?? null, FILTER_VALIDATE_INT);
$ipk = filter_var($_POST['ipk'] ?? null, FILTER_VALIDATE_FLOAT);

// Validasi sebelum memperbarui data.
if (
    $nim === '' || $nama === '' || $prodi === '' ||
    $angkatan === false || $angkatan === null ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $ipk === false || $ipk === null || $ipk < 0 || $ipk > 4
) {
    die('Data tidak valid. Periksa kembali email, angkatan, dan IPK.');
}

$stmt = mysqli_prepare(
    $koneksi,
    "UPDATE mahasiswa
     SET nama = ?, email = ?, prodi = ?, angkatan = ?, ipk = ?
     WHERE nim = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "sssids",
    $nama,
    $email,
    $prodi,
    $angkatan,
    $ipk,
    $nim
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header('Location: index.php?pesan=update');
    exit;
}

mysqli_stmt_close($stmt);
die('Data gagal diperbarui. Periksa koneksi database.');
?>
