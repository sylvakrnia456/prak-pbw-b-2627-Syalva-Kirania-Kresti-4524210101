
<?php
require_once 'koneksi.php';

function e($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$nim = trim($_GET['nim'] ?? '');

if ($nim === '') {
    header('Location: index.php');
    exit;
}

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nim, nama, email, prodi, angkatan, ipk
     FROM mahasiswa WHERE nim = ?"
);
mysqli_stmt_bind_param($stmt, "s", $nim);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$data) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa | KampusKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-orange-100">

<header class="bg-gradient-to-r from-amber-500 to-orange-600 p-8 text-white shadow-lg">
    <div class="mx-auto max-w-5xl">
        <p class="text-sm uppercase tracking-widest text-amber-100">KampusKu</p>
        <h1 class="mt-2 text-3xl font-extrabold">Edit Mahasiswa ✏️</h1>
        <p class="mt-2 text-amber-50">Perbarui informasi mahasiswa.</p>
    </div>
</header>

<main class="mx-auto max-w-5xl px-6 py-8">
    <section class="rounded-2xl bg-white p-6 shadow-xl md:p-8">
        <h2 class="mb-2 text-xl font-bold">Formulir Perubahan Data</h2>
        <p class="mb-6 text-sm text-slate-500">Periksa data sebelum menyimpan perubahan.</p>

        <form action="update.php" method="POST" class="grid gap-5 md:grid-cols-2">
            <label>
                <span class="mb-2 block font-semibold">NIM</span>
                <input type="text" name="nim" readonly
                    value="<?= e($data['nim']) ?>"
                    class="w-full cursor-not-allowed rounded-xl border bg-slate-100 p-3 text-slate-500">
            </label>

            <label>
                <span class="mb-2 block font-semibold">Nama Lengkap *</span>
                <input type="text" name="nama" required maxlength="100"
                    value="<?= e($data['nama']) ?>"
                    class="w-full rounded-xl border p-3 outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-100">
            </label>

            <label>
                <span class="mb-2 block font-semibold">Email *</span>
                <input type="email" name="email" required maxlength="100"
                    value="<?= e($data['email']) ?>"
                    class="w-full rounded-xl border p-3 outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-100">
            </label>

            <label>
                <span class="mb-2 block font-semibold">Program Studi *</span>
                <input type="text" name="prodi" required maxlength="100"
                    value="<?= e($data['prodi']) ?>"
                    class="w-full rounded-xl border p-3 outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-100">
            </label>

            <label>
                <span class="mb-2 block font-semibold">Angkatan *</span>
                <input type="number" name="angkatan" required min="2000" max="<?= date('Y') + 1 ?>"
                    value="<?= e($data['angkatan']) ?>"
                    class="w-full rounded-xl border p-3 outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-100">
            </label>

            <label>
                <span class="mb-2 block font-semibold">IPK *</span>
                <input type="number" name="ipk" required min="0" max="4" step="0.01"
                    value="<?= e($data['ipk']) ?>"
                    class="w-full rounded-xl border p-3 outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-100">
            </label>

            <div class="flex flex-col-reverse gap-3 border-t pt-6 sm:flex-row sm:justify-end md:col-span-2">
                <a href="index.php"
                   class="rounded-xl border px-5 py-3 text-center font-semibold hover:bg-slate-100">
                    ← Batal
                </a>
                <button type="submit"
                   class="rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-3 font-bold text-white shadow hover:from-amber-600 hover:to-orange-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
