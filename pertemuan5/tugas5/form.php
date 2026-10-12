<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Data Mahasiswa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
            padding: 30px;
        }

        .container {
            width: 450px;
            max-width: 100%;
            box-sizing: border-box;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: teal;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 8px 0 15px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: teal;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Form Data Mahasiswa</h2>

    <form action="simpan.php" method="post">
        NIM:
        <input type="text" name="nim"
               maxlength="20" required>

        Nama:
        <input type="text" name="nama"
               maxlength="100" required>

        Email:
        <input type="email" name="email"
               maxlength="100" required>

        Prodi:
        <input type="text" name="prodi"
               maxlength="100" required>

        Angkatan:
        <input type="number" name="angkatan"
               min="2000" max="2100" required>

        IPK:
        <input type="number" name="ipk"
               min="0" max="4" step="0.01" required>

        <button type="submit">Simpan Data</button>
    </form>
</div>

</body>
</html>