<?php
// kalkulator.php
$hasil = null;
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = (float) ($_POST['a'] ?? 0);
    $b = (float) ($_POST['b'] ?? 0);
    $operator = $_POST['operator'] ?? '+';

    switch ($operator) {
        case '+':
            $hasil = $a + $b;
            break;

        case '-':
            $hasil = $a - $b;
            break;

        case '*':
            $hasil = $a * $b;
            break;

        case '/':
            if ($b === 0) {
                $pesan = 'Pembagian nol tidak diperbolehkan.';
            } else {
                $hasil = $a / $b;
            }
            break;

        default:
            $pesan = 'Operator tidak valid.';
    }
}
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Kalkulator</title>
</head>

<body>

    <h1>Kalkulator Sederhana</h1>

    <form method="post">
        <input type="number" step="any" name="a" required>

        <select name="operator">
            <option>+</option>
            <option>-</option>
            <option>*</option>
            <option>/</option>
        </select>

        <input type="number" step="any" name="b" required>

        <button type="submit">Hitung</button>
    </form>

    <?php if ($pesan): ?>
        <p><?= htmlspecialchars($pesan) ?></p>
    <?php elseif ($hasil !== null): ?>
        <p>Hasil: <?= htmlspecialchars((string)$hasil) ?></p>
    <?php endif; ?>

<h1>Biodata Mahasiswa</h1>

<?php
function statusKelulusan(float $ipk): string
{
    if ($ipk >= 3.50) return 'Sangat Memuaskan';
    if ($ipk >= 3.00) return 'Memuaskan';
    return 'Perlu Peningkatan';
}

$mahasiswa = [
    'nim' => '4524210101',
    'nama' => 'Syalva Kirania Kresti',
    'prodi' => 'Teknik Informatika',
    'semester' => 5,
    'ipk' => 3.72,
     'email' => 'sylvakrn4524101@univpancasila.ac.id'
];

if ($mahasiswa['ipk'] < 0 || $mahasiswa['ipk'] > 4) {
    echo "<p>IPK tidak valid. IPK harus berada antara 0 sampai 4.</p>";
}
?>

<ul>
    <?php foreach ($mahasiswa as $kunci => $nilai): ?>
        <li><?= ucfirst($kunci) ?>: <?= htmlspecialchars((string)$nilai) ?></li>
    <?php endforeach; ?>
</ul>

<p>
    Predikat:
    <?= statusKelulusan($mahasiswa['ipk']) ?>
</p>

</body>

</html>

</body>

</html>