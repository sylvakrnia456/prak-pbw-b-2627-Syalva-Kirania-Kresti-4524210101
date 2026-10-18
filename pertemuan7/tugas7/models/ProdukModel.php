
<?php

class ProdukModel
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }

    public function getAll()
    {
        return $this->koneksi->query(
            "SELECT * FROM produk ORDER BY id DESC"
        );
    }

    public function getById($id)
    {
        $stmt = $this->koneksi->prepare(
            "SELECT * FROM produk WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $produk = $result->fetch_assoc();

        $stmt->close();

        return $produk;
    }

    public function create($nama, $harga, $stok)
    {
        $stmt = $this->koneksi->prepare(
            "INSERT INTO produk (nama_produk, harga, stok)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param("sdi", $nama, $harga, $stok);
        $berhasil = $stmt->execute();

        $stmt->close();

        return $berhasil;
    }

    public function update($id, $nama, $harga, $stok)
    {
        $stmt = $this->koneksi->prepare(
            "UPDATE produk
             SET nama_produk = ?, harga = ?, stok = ?
             WHERE id = ?"
        );

        $stmt->bind_param("sdii", $nama, $harga, $stok, $id);
        $berhasil = $stmt->execute();

        $stmt->close();

        return $berhasil;
    }
}
?>
