
<?php
function e($nilai) {
    return htmlspecialchars((string)$nilai, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Produk - Kirania Store</title>
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
.primary{background:#6758e8;color:white}.light{background:white;border:1px solid #eceef5;color:#555970}
.form-panel{background:white;border:1px solid #eceef5;border-radius:14px;padding:28px;max-width:800px}
.form-panel h2{font-size:18px;margin-top:0}
.form-group{display:flex;flex-direction:column;gap:9px;margin-bottom:22px}
label{font-size:12px;font-weight:bold}
input{padding:13px;border:1px solid #e3e5ef;border-radius:8px;font-size:13px;width:100%}
input:focus{outline:2px solid #d9d4ff;border-color:#6758e8}
small{color:#85899e}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.actions{display:flex;justify-content:flex-end;gap:10px;border-top:1px solid #eceef5;padding-top:20px}
.footer{text-align:center;color:#999db0;font-size:11px;margin-top:25px}
@media(max-width:700px){.app{display:block}.sidebar{width:100%;padding:15px}.brand{margin-bottom:18px}.main{padding:20px 12px}.topbar{align-items:flex-start;flex-direction:column}.form-panel{padding:20px 15px}.form-row{grid-template-columns:1fr}}
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
        <div><p class="eyebrow">MANAJEMEN TOKO</p><h1>Edit Produk</h1><p class="muted">Perbarui informasi produk yang tersimpan.</p></div>
        <a class="btn light" href="index.php">← Kembali</a>
    </header>

    <section class="form-panel">
        <h2>✎ Informasi Produk</h2>
        <p class="muted">ID Produk: #<?= e($produk["id"]) ?></p>
        <form action="index.php?action=update" method="POST">
            <input type="hidden" name="id" value="<?= e($produk["id"]) ?>">
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" maxlength="100" value="<?= e($produk["nama_produk"]) ?>" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="harga">Harga Produk (Rp)</label>
                    <input type="number" id="harga" name="harga" min="0" max="9999999999.99" step="0.01" value="<?= e($produk["harga"]) ?>" required>
                </div>
                <div class="form-group">
                    <label for="stok">Jumlah Stok</label>
                    <input type="number" id="stok" name="stok" min="0" max="2147483647" step="1" value="<?= e($produk["stok"]) ?>" required>
                </div>
            </div>
            <div class="actions">
                <a class="btn light" href="index.php">Batal</a>
                <button class="btn primary" type="submit">✓ Simpan Perubahan</button>
            </div>
        </form>
    </section>
    <footer class="footer">Kirania Store &copy; <?= date("Y") ?> · Sistem Manajemen Produk MVC</footer>
</main>
</div>
</body>
</html>
