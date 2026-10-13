
<?php
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa | KampusKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-100">

<header class="bg-gradient-to-r from-blue-700 to-purple-700 p-8 text-white shadow-lg">
    <div class="mx-auto max-w-5xl">
        <p class="text-sm uppercase tracking-widest text-blue-100">KampusKu</p>
        <h1 class="mt-2 text-3xl font-extrabold">Tambah Mahasiswa 📝</h1>
        <p class="mt-2 text-blue-100">Masukkan informasi mahasiswa pada formulir berikut.</p>
    </div>
</header>

<main class="mx-auto max-w-5xl px-6 py-8">
    <section class="rounded-2xl bg-white p-6 shadow-xl md:p-8">
        <h2 class="mb-2 text-xl font-bold text-slate-800">Formulir Data Mahasiswa</h2>
        <p class="mb-6 text-sm text-slate-500">Kolom bertanda * wajib diisi.</p>

        <?php if ($error === 'duplikat'): ?>
            <div class="mb-5 rounded-xl bg-rose-100 p-4 text-rose-700">
                NIM sudah terdaftar. Gunakan NIM lain.
            </div>
        <?php elseif ($error === 'validasi'): ?>
            <div class="mb-5 rounded-xl bg-rose-100 p-4 text-rose-700">
                Data tidak valid. Periksa email, angkatan, dan IPK.
            </div>
        <?php endif; ?>

        <form action="store.php" method="POST" class="grid gap-5 md:grid-cols-2">
            <label>
                <span class="mb-2 block font-semibold">NIM *</span>
                <input type="text" name="nim" required maxlength="20"
                    placeholder="Masukkan NIM"
                    class="w-full rounded-xl border p-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </label>

            <label>
                <span class="mb-2 block font-semibold">Nama Lengkap *</span>
                <input type="text" name="nama" required maxlength="100"
                    placeholder="Masukkan nama"
                    class="w-full rounded-xl border p-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </label>

            <label>
                <span class="mb-2 block font-semibold">Email *</span>
                <input type="email" name="email" required maxlength="100"
                    placeholder="nama@email.com"
                    class="w-full rounded-xl border p-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </label>

            <label>
                <span class="mb-2 block font-semibold">Program Studi *</span>
                <input type="text" name="prodi" required maxlength="100"
                    placeholder="Contoh: Informatika"
                    class="w-full rounded-xl border p-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </label>

            <label>
                <span class="mb-2 block font-semibold">Angkatan *</span>
                <input type="number" name="angkatan" required min="2000" max="<?= date('Y') + 1 ?>"
                    placeholder="Contoh: 2024"
                    class="w-full rounded-xl border p-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </label>

            <label>
                <span class="mb-2 block font-semibold">IPK *</span>
                <input type="number" name="ipk" required min="0" max="4" step="0.01"
                    placeholder="Contoh: 3.75"
                    class="w-full rounded-xl border p-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </label>

            <div class="flex flex-col-reverse gap-3 border-t pt-6 sm:flex-row sm:justify-end md:col-span-2">
                <a href="index.php"
                   class="rounded-xl border px-5 py-3 text-center font-semibold hover:bg-slate-100">
                    ← Kembali
                </a>
                <button type="submit"
                   class="rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 font-bold text-white shadow hover:from-blue-700 hover:to-indigo-700">
                    Simpan Data
                </button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
