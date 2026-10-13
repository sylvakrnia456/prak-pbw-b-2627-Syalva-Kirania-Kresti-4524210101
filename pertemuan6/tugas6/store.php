
<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}

$nim = trim($_POST['nim'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$prodi = trim($_POST['prodi'] ?? '');
$angkatan = filter_var($_POST['angkatan'] ?? null, FILTER_VALIDATE_INT);
$ipk = filter_var($_POST['ipk'] ?? null, FILTER_VALIDATE_FLOAT);

// Validasi data sebelum dimasukkan ke database.
if (
    $nim === '' || $nama === '' || $prodi === '' ||
    $angkatan === false || $angkatan === null ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $ipk === false || $ipk === null || $ipk < 0 || $ipk > 4
) {
    header('Location: create.php?error=validasi');
    exit;
}

// Periksa apakah NIM sudah digunakan.
$cek = mysqli_prepare($koneksi, "SELECT nim FROM mahasiswa WHERE nim = ?");
mysqli_stmt_bind_param($cek, "s", $nim);
mysqli_stmt_execute($cek);
$hasil = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($hasil) > 0) {
    mysqli_stmt_close($cek);
    header('Location: create.php?error=duplikat');
    exit;
}
mysqli_stmt_close($cek);

// Simpan data menggunakan prepared statement.
$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO mahasiswa (nim, nama, email, prodi, angkatan, ipk)
     VALUES (?, ?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "ssssid",
    $nim,
    $nama,
    $email,
    $prodi,
    $angkatan,
    $ipk
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header('Location: index.php?pesan=tambah');
    exit;
}

$errorCode = mysqli_stmt_errno($stmt);
mysqli_stmt_close($stmt);

if ($errorCode === 1062) {
    header('Location: create.php?error=duplikat');
    exit;
}

die('Data gagal disimpan. Periksa koneksi dan struktur tabel database.');
?>
