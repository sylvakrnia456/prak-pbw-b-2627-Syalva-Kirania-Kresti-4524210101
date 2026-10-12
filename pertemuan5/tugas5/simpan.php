<?php
require_once "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Akses tidak valid. Silakan isi form terlebih dahulu.");
}

$nim      = trim($_POST["nim"] ?? "");
$nama     = trim($_POST["nama"] ?? "");
$email    = trim($_POST["email"] ?? "");
$prodi    = trim($_POST["prodi"] ?? "");
$angkatan = $_POST["angkatan"] ?? "";
$ipk      = $_POST["ipk"] ?? "";

$errors = [];

// Validasi data mahasiswa
if ($nim == "" || strlen($nim) > 20) {
    $errors[] = "NIM wajib diisi dan maksimal 20 karakter.";
}

if ($nama == "" || strlen($nama) > 100) {
    $errors[] = "Nama wajib diisi dan maksimal 100 karakter.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

if ($prodi == "") {
    $errors[] = "Program studi wajib diisi.";
}

if (!filter_var($angkatan, FILTER_VALIDATE_INT)
    || $angkatan < 2000 || $angkatan > 2100) {
    $errors[] = "Angkatan harus antara 2000 dan 2100.";
}

if (!is_numeric($ipk) || $ipk < 0 || $ipk > 4) {
    $errors[] = "IPK harus berada antara 0 sampai 4.";
}

if (!empty($errors)) {
    echo "<h3>Data tidak valid:</h3><ul>";

    foreach ($errors as $error) {
        echo "<li>" .
        htmlspecialchars($error, ENT_QUOTES, "UTF-8") .
        "</li>";
    }

    echo "</ul><a href='form.php'>Kembali ke Form</a>";
    exit;
}

// Menyimpan data menggunakan prepared statement
$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO mahasiswa
    (nim, nama, email, prodi, angkatan, ipk)
    VALUES (?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    die("Query gagal disiapkan.");
}

mysqli_stmt_bind_param(
    $stmt,
    "sssssd",
    $nim,
    $nama,
    $email,
    $prodi,
    $angkatan,
    $ipk
);

if (mysqli_stmt_execute($stmt)) {
    echo "<h2>Data berhasil disimpan!</h2>";
    echo "<p>Data mahasiswa berhasil ditambahkan.</p>";
    echo "<a href='form.php'>Tambah Data Lagi</a><br>";
    echo "<a href='data.php'>Lihat Data Mahasiswa</a>";
} else {
    echo "<h2>Data gagal disimpan.</h2>";
    echo "<p>Periksa apakah NIM sudah terdaftar atau struktur tabel sudah sesuai.</p>";
    echo "<a href='form.php'>Kembali ke Form</a>";
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>