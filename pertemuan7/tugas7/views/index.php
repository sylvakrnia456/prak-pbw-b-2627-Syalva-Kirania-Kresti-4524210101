
<?php
function e($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, "UTF-8");
}

$totalProduk = 0;
$totalStok = 0;
$totalNilai = 0;

foreach ($produk as $item) {
    $totalProduk++;
    $totalStok += (int) $item["stok"];
    $totalNilai += (float) $item["harga"] * (int) $item["stok"];
}
$produk->data_seek(0);

$status = $_GET["status"] ?? "";
$pesan = [
    "added" => "Produk berhasil ditambahkan!",
    "updated" => "Produk berhasil diperbarui!",
    "notfound" => "Produk tidak ditemukan.",
    "failed" => "Proses gagal. Silakan coba kembali.",
    "invalid" => "Data tidak valid. Periksa kembali input."
][$status] ?? "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daftar Produk - Kirania Store</title>
<style>
*{box-sizing:border-box}
body{margin:0;font-family:Arial,sans-serif;background:#f5f6fb;color:#282943}
.app{display:flex;min-height:100vh}
.sidebar{width:235px;flex-shrink:0;background:white;padding:28px 18px;border-right:1px solid #eceef5}
.brand{display:flex;align-items:center;gap:12px;margin-bottom:42px}
.logo{background:linear-gradient(135deg,#8877ff,#5545d5);color:white;border-radius:12px;padding:13px;font-size:22px;font-weight:bold}
.brand h2{margin:0 0 5px}.brand small{color:#85899e}
.menu-label{font-size:10px;color:#999db0;letter-spacing:1px;margin:0 10px 15px}
.menu{display:block;padding:14px;border-radius:9px;text-decoration:none;color:#777b91;margin-bottom:7px;font-weight:bold}
.menu.active,.menu:hover{background:#efedff;color:#6758e8}
.main{flex:1;min-width:0;padding:35px}
.topbar{display:flex;justify-content:space-between;align-items:center;gap:15px;margin-bottom:27px}
.eyebrow{color:#6758e8;font-size:11px;font-weight:bold;letter-spacing:1.5px}
h1{font-size:29px;margin:8px 0}
.muted{color:#85899e;font-size:13px}
.btn{display:inline-block;border:0;border-radius:8px;padding:12px 15px;text-decoration:none;font-weight:bold;font-size:12px;cursor:pointer}
.primary{background:#6758e8;color:white}.edit{background:#efedff;color:#6758e8;padding:9px 12px}
.stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:24px}
.stat,.panel{background:white;border:1px solid #eceef5;border-radius:14px}
.stat{padding:22px}.stat p{color:#85899e;font-size:12px}.stat h2{font-size:23px;overflow-wrap:anywhere}
.panel{overflow:hidden}.panel-head{padding:22px;display:flex;justify-content:space-between;align-items:center;gap:12px}
.panel-head h2{margin:0 0 7px;font-size:17px}
table{width:100%;border-collapse:collapse;text-align:left}
th,td{padding:16px 18px;border-bottom:1px solid #f0f1f7;white-space:nowrap;font-size:12px}
th{background:#f9f9fd;color:#85899e;font-size:10px}
td{color:#555970}.product{font-weight:bold;color:#303249}
.stock{display:inline-block;border-radius:20px;padding:7px 9px;font-size:10px}
.available{background:#e3f8ed;color:#16875c}.low{background:#fff1d9;color:#bd7620}
.alert{padding:14px;border-radius:9px;margin-bottom:20px;background:#e4f8ec;color:#16875c}
.alert.error{background:#fff0ef;color:#c44747}
.footer{text-align:center;color:#999db0;font-size:11px;margin-top:25px}
@media(max-width:900px){.stats{grid-template-columns:1fr}.main{padding:20px}.sidebar{width:190px}}
@media(max-width:650px){.app{display:block}.sidebar{width:100%;padding:15px}.brand{margin-bottom:18px}.main{padding:18px 12px}.topbar{align-items:flex-start;flex-direction:column}h1{font-size:24px}.panel{overflow-x:auto}th,td{padding:12px}}
</style>
</head>
<body>
<div class="app">
<aside class="sidebar">
    <div class="brand"><div class="logo">K</div><div><h2>Kirania Store</h2><small>Product Management</small></div></div>
    <p class="menu-label">MENU UTAMA</p>
    <a class="menu active" href="index.php">▦ &nbsp; Daftar Produk</a>
    <a class="menu" href="index.php?action=create">＋ &nbsp; Tambah Produk</a>
</aside>

<main class="main">
    <header class="topbar">
        <div>
            <p class="eyebrow">MANAJEMEN TOKO</p>
            <h1>Daftar Produk</h1>
            <p class="muted">Kelola produk, harga, dan stok tokomu.</p>
        </div>
        <a class="btn primary" href="index.php?action=create">＋ Tambah Produk</a>
    </header>

    <?php if ($pesan): ?>
        <div class="alert <?= in_array($status, ["failed","invalid","notfound"]) ? "error" : "" ?>">
            <?= e($pesan) ?>
        </div>
    <?php endif; ?>

    <section class="stats">
        <div class="stat"><p>Total Produk</p><h2><?= $totalProduk ?></h2><span class="muted">Jenis produk</span></div>
        <div class="stat"><p>Total Stok</p><h2><?= $totalStok ?></h2><span class="muted">Unit persediaan</span></div>
        <div class="stat"><p>Nilai Persediaan</p><h2>Rp <?= number_format($totalNilai,0,",",".") ?></h2><span class="muted">Harga dikali stok</span></div>
    </section>

    <section class="panel">
        <div class="panel-head">
            <div><h2>Semua Produk</h2><span class="muted">Data dari database MySQL</span></div>
            <span class="muted"><?= $totalProduk ?> produk</span>
        </div>
        <table>
            <thead><tr><th>ID</th><th>Nama Produk</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php if ($produk && $produk->num_rows > 0): ?>
                <?php while ($item = $produk->fetch_assoc()): ?>
                <tr>
                    <td>#<?= e($item["id"]) ?></td>
                    <td class="product">📦 <?= e($item["nama_produk"]) ?></td>
                    <td>Rp <?= number_format((float)$item["harga"],0,",",".") ?></td>
                    <td><?= e($item["stok"]) ?> unit</td>
                    <td>
                        <?php if ((int)$item["stok"] <= 5): ?>
                            <span class="stock low">Stok rendah</span>
                        <?php else: ?>
                            <span class="stock available">Tersedia</span>
                        <?php endif; ?>
                    </td>
                    <td><a class="btn edit" href="index.php?action=edit&id=<?= (int)$item["id"] ?>">✎ Edit</a></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">Belum ada produk. Tambahkan produk baru.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </section>
    <footer class="footer">Kirania Store &copy; <?= date("Y") ?> · Sistem Manajemen Produk MVC</footer>
</main>
</div>
</body>
</html>
