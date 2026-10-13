
<?php
include "koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM mahasiswa ORDER BY nama ASC"
);

if (!$query) {
    die("Gagal mengambil data: " . mysqli_error($koneksi));
}

$total = mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Dashboard Mahasiswa</title>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-100 font-sans text-gray-800">

    <header class="bg-gradient-to-r from-indigo-700 via-blue-600 to-purple-600 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-8">
            <p class="text-blue-100 text-sm font-medium">SISTEM INFORMASI AKADEMIK</p>
            <h1 class="text-3xl font-extrabold mt-2">Dashboard Mahasiswa 🎓</h1>
            <p class="mt-2 text-blue-100">Kelola data mahasiswa dengan mudah dan praktis.</p>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-md border-l-4 border-indigo-500">
                <p class="text-gray-500 text-sm">Total Mahasiswa</p>
                <h2 class="text-4xl font-extrabold text-indigo-700 mt-2">
                    <?= $total ?>
                </h2>
                <p class="text-sm text-gray-400 mt-2">Data terdaftar di sistem</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-md border-l-4 border-purple-500">
                <p class="text-gray-500 text-sm">Pengelolaan Data</p>
                <h2 class="text-2xl font-bold text-purple-700 mt-3">CRUD</h2>
                <p class="text-sm text-gray-400 mt-2">Tambah, lihat, edit, hapus</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-md border-l-4 border-blue-500">
                <p class="text-gray-500 text-sm">Status Sistem</p>
                <h2 class="text-2xl font-bold text-blue-700 mt-3">● Aktif</h2>
                <p class="text-sm text-gray-400 mt-2">Halaman pengelolaan mahasiswa</p>
            </div>
        </div>

        <section class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">📋 Daftar Mahasiswa</h2>
                    <p class="text-gray-500 text-sm mt-1">Informasi mahasiswa yang tersimpan.</p>
                </div>

                <a href="create.php"
                   class="inline-block text-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold px-5 py-3 rounded-xl shadow-md transition transform hover:-translate-y-1">
                    + Tambah Mahasiswa
                </a>
            </div>

            <div class="overflow-x-auto px-6 pb-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-indigo-50 text-indigo-900">
                            <th class="p-4 rounded-l-lg">NIM</th>
                            <th class="p-4">Nama</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Program Studi</th>
                            <th class="p-4">Angkatan</th>
                            <th class="p-4">IPK</th>
                            <th class="p-4 rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if ($total > 0): ?>
                        <?php while ($data = mysqli_fetch_assoc($query)): ?>
                        <tr class="border-b border-gray-100 hover:bg-indigo-50 transition">
                            <td class="p-4 font-semibold text-indigo-700">
                                <?= htmlspecialchars($data['nim']) ?>
                            </td>
                            <td class="p-4 font-medium">
                                <?= htmlspecialchars($data['nama']) ?>
                            </td>
                            <td class="p-4 text-gray-600">
                                <?= htmlspecialchars($data['email']) ?>
                            </td>
                            <td class="p-4">
                                <?= htmlspecialchars($data['prodi']) ?>
                            </td>
                            <td class="p-4">
                                <?= htmlspecialchars($data['angkatan']) ?>
                            </td>
                            <td class="p-4">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold text-sm">
                                    <?= htmlspecialchars($data['ipk']) ?>
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <a href="edit.php?nim=<?= urlencode($data['nim']) ?>"
                                   class="inline-block bg-amber-100 text-amber-700 hover:bg-amber-200 px-3 py-2 rounded-lg font-semibold">
                                    ✏️ Edit
                                </a>

                                <a href="delete.php?nim=<?= urlencode($data['nim']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus data ini?')"
                                   class="inline-block bg-red-100 text-red-700 hover:bg-red-200 px-3 py-2 rounded-lg font-semibold ml-1">
                                    🗑️ Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-10 text-center">
                                <div class="text-4xl mb-3">📭</div>
                                <p class="font-bold text-gray-600">Belum ada data mahasiswa</p>
                                <p class="text-gray-400 text-sm mt-1">
                                    Klik tombol Tambah Mahasiswa untuk memulai.
                                </p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <footer class="text-center text-gray-400 text-sm mt-8">
            Sistem Informasi Akademik · Pengelolaan Data Mahasiswa
        </footer>

    </main>
</body>
</html>
