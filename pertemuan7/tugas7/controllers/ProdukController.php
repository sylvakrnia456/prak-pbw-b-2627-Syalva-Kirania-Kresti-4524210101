
<?php

require_once __DIR__ . "/../models/ProdukModel.php";

class ProdukController
{
    private $model;

    public function __construct($koneksi)
    {
        $this->model = new ProdukModel($koneksi);
    }

    public function index()
    {
        $produk = $this->model->getAll();
        include __DIR__ . "/../views/index.php";
    }

    public function create()
    {
        include __DIR__ . "/../views/create.php";
    }

    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php");
            exit;
        }

        $nama = trim($_POST["nama_produk"] ?? "");
        $harga = $_POST["harga"] ?? "";
        $stok = $_POST["stok"] ?? "";

        if (!$this->validasi($nama, $harga, $stok)) {
            header("Location: index.php?action=create&status=invalid");
            exit;
        }

        $berhasil = $this->model->create(
            $nama,
            (float) $harga,
            (int) $stok
        );

        header("Location: index.php?status=" .
            ($berhasil ? "added" : "failed"));
        exit;
    }

    public function edit()
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            header("Location: index.php?status=notfound");
            exit;
        }

        $produk = $this->model->getById($id);

        if (!$produk) {
            header("Location: index.php?status=notfound");
            exit;
        }

        include __DIR__ . "/../views/edit.php";
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php");
            exit;
        }

        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $nama = trim($_POST["nama_produk"] ?? "");
        $harga = $_POST["harga"] ?? "";
        $stok = $_POST["stok"] ?? "";

        if (!$id || $id < 1 ||
            !$this->validasi($nama, $harga, $stok)) {
            header("Location: index.php?status=invalid");
            exit;
        }

        if (!$this->model->getById($id)) {
            header("Location: index.php?status=notfound");
            exit;
        }

        $berhasil = $this->model->update(
            $id,
            $nama,
            (float) $harga,
            (int) $stok
        );

        header("Location: index.php?status=" .
            ($berhasil ? "updated" : "failed"));
        exit;
    }

    private function validasi($nama, $harga, $stok)
    {
        return $nama !== ""
            && mb_strlen($nama) <= 100
            && is_numeric($harga)
            && is_numeric($stok)
            && (float) $harga >= 0
            && (float) $harga <= 9999999999.99
            && (float) $stok >= 0
            && (float) $stok <= 2147483647
            && (float) $stok == (int) $stok;
    }
}
?>
