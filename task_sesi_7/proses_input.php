<?php
// Ambil data dari form
$nama_produk = isset($_POST['nama_produk']) ? trim($_POST['nama_produk']) : '';
$harga       = isset($_POST['harga']) ? trim($_POST['harga']) : '';
$deskripsi   = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : '';
$stok        = isset($_POST['stok']) ? trim($_POST['stok']) : '';

$errors = [];

// Validasi: Jangan sampai ada yang kosong
if ($nama_produk === '') {
    $errors[] = "Nama produk tidak boleh kosong.";
}
if ($harga === '' || !is_numeric($harga)) {
    $errors[] = "Harga harus diisi dengan angka.";
}
if ($deskripsi === '') {
    $errors[] = "Deskripsi tidak boleh kosong.";
}
if ($stok === '' || !is_numeric($stok)) {
    $errors[] = "Stok harus diisi dengan angka.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Input Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff; }
        .result-container {
            max-width: 480px;
            margin: 60px auto;
            padding: 32px 24px;
            border: 1.5px solid #ff8400;
            border-radius: 14px;
            box-shadow: 0 2px 16px rgba(255,132,0,0.09);
            background: #fff;
        }
        .judul {
            color: #ff8400;
            font-weight: 700;
        }
        .btn-orange {
            background: #ff8400;
            color: #fff;
            font-weight: 500;
            border: none;
            border-radius: 6px;
            padding: 10px 18px;
            transition: background 0.15s;
        }
        .btn-orange:hover {
            background: #d36c00;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h2 class="mb-4 text-center judul">Hasil Input Produk</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="text-center">
                <a href="form_products.html" class="btn btn-orange mt-3">Kembali ke Form</a>
            </div>
        <?php else: ?>
            <table class="table table-bordered">
                <tr>
                    <th>Nama Produk</th>
                    <td><?= htmlspecialchars($nama_produk) ?></td>
                </tr>
                <tr>
                    <th>Harga</th>
                    <td>Rp <?= number_format((int)$harga, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td><?= nl2br(htmlspecialchars($deskripsi)) ?></td>
                </tr>
                <tr>
                    <th>Stok</th>
                    <td><?= htmlspecialchars($stok) ?></td>
                </tr>
            </table>
            <div class="text-center">
                <a href="form_products.html" class="btn btn-orange mt-3">Input Produk Lain</a>
            </div>
        <?php endif; ?>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>