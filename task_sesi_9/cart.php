<?php
session_start();
include 'connect_db.php';

// Set session_id unik jika belum ada
if (!isset($_SESSION['cart_sid'])) {
    $_SESSION['cart_sid'] = session_id();
}
$sid = $_SESSION['cart_sid'];

// Notifikasi
$notif = '';
if (isset($_GET['notif'])) {
    if ($_GET['notif'] == "deleted") {
        $notif = '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            Item berhasil dihapus dari keranjang.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}

// Hapus item cart
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    mysqli_query($conn, "DELETE FROM carts WHERE id=$remove_id AND session_id='$sid'");
    header("Location: cart.php?notif=deleted");
    exit();
}

// Ambil cart user, join produk
$sql = "SELECT carts.*, Products.nama_produk, Products.gambar, Products.harga, Products.kategori
        FROM carts
        JOIN Products ON Products.Id = carts.product_id
        WHERE carts.session_id = '$sid'
        ORDER BY carts.id DESC";
$res = mysqli_query($conn, $sql);

$carts = [];
while ($row = mysqli_fetch_assoc($res)) {
    $carts[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .btn-orange { background: #ff8400; color:#fff; border: none; }
        .btn-orange:hover { background: #d36c00; color: #fff; }
        .produk-img {height:56px;width:56px;object-fit:cover;border-radius:8px;}
        .card {box-shadow:0 2px 12px rgba(255,132,0,0.06);}
        .navbar {box-shadow: 0 2px 10px rgba(255,132,0,0.08);}
        .navbar-nav .nav-link.active {color: #fff !important; background: #ff8400 !important; border-radius: 7px; }
        .navbar-nav .nav-link {font-weight: 500; color: #ff8400 !important; margin-right: 4px; transition: background .12s; }
        .navbar-nav .nav-link:hover {background: #ffecd1; color: #d36c00 !important;}
        .navbar-admin {margin-left: auto; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white mb-4">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php" style="color:#ff8400">TOKO</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="cart.php">Keranjang</a>
          </li>
        </ul>
        <ul class="navbar-nav navbar-admin">
          <li class="nav-item">
            <a class="nav-link" href="products.php">Admin</a>
          </li>
        </ul>
      </div>
    </div>
</nav>
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center" style="color:#ff8400">Keranjang Belanja</h2>
    <?= $notif ?>

    <div class="mb-3">
        <a href="index.php" class="btn btn-orange">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Produk
        </a>
    </div>

    <div class="card">
        <div class="card-header">List Keranjang</div>
        <div class="card-body p-0">
            <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
                <thead style="background:#ff8400;color:#fff;">
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $total = 0;
                if ($carts): 
                    foreach($carts as $i => $row):
                        // Harga tanpa Rp dan titik
                        $harga = preg_replace('/[^\d]/', '', $row['harga']);
                        $harga = intval($harga);
                        $subtotal = $harga * $row['qty'];
                        $total += $subtotal;
                ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td>
                            <img src="<?= htmlspecialchars($row['gambar']) ?>" class="produk-img me-2 mb-1">
                            <?= htmlspecialchars($row['nama_produk']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['kategori']) ?></td>
                        <td><?= htmlspecialchars($row['harga']) ?></td>
                        <td><?= $row['qty'] ?></td>
                        <td>Rp <?= number_format($subtotal,0,',','.') ?></td>
                        <td>
                            <a href="cart.php?remove=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Hapus item ini dari keranjang?')">
                                <i class="bi bi-trash"></i> Remove
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    <tr style="background:#fff3e0">
                        <td colspan="5" class="text-end fw-bold">TOTAL</td>
                        <td colspan="2" class="fw-bold">Rp <?= number_format($total,0,',','.') ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Keranjang kosong.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>