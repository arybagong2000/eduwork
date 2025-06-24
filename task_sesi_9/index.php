<?php
include 'connect_db.php';

// Ambil kategori unik untuk dropdown
$kategoriList = [];
$sqlKat = "SELECT DISTINCT kategori FROM Products ORDER BY kategori ASC";
$resultKat = mysqli_query($conn, $sqlKat);
while ($rowKat = mysqli_fetch_assoc($resultKat)) {
    $kategoriList[] = $rowKat['kategori'];
}

// Proses filter kategori jika ada request
$selectedKategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Query data produk (filter jika ada kategori)
if ($selectedKategori && $selectedKategori != 'all') {
    $sql = "SELECT * FROM Products WHERE kategori = '" . mysqli_real_escape_string($conn, $selectedKategori) . "'";
} else {
    $sql = "SELECT * FROM Products";
}
$result = mysqli_query($conn, $sql);

// Ambil data produk
$produk = [];
while ($row = mysqli_fetch_assoc($result)) {
    $produk[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Daftar Produk</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #fff;
    }
    .produk-card {
      border: 1.5px solid #ff8400;
      border-radius: 12px;
      background: #fff;
      box-shadow: 0 2px 10px rgba(255,132,0,0.06);
      transition: transform 0.15s;
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .produk-card:hover {
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 4px 24px rgba(255,132,0,0.13);
    }
    .produk-img {
      height: 160px;
      object-fit: cover;
      border-radius: 12px 12px 0 0;
    }
    .produk-title {
      color: #ff8400;
      font-weight: 600;
      font-size: 1.1em;
      margin-bottom: 0.2em;
    }
    .produk-harga {
      color: #222;
      font-weight: bold;
      font-size: 1.15em;
      margin-bottom: 0.5em;
    }
    .produk-btn {
      background: #ff8400;
      color: #fff;
      border-radius: 6px;
      font-weight: 500;
      border: none;
      padding: 8px 16px;
      transition: background 0.18s;
      margin-top: 0.5em;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .produk-btn:hover {
      background: #d36c00;
      color: #fff;
    }
    .produk-desc {
      color: #444;
      font-size: 0.98em;
      margin-bottom: 0.8em;
    }
    .produk-kategori {
      font-size: 0.97em;
      background: #ff8400;
      color: #fff;
      display: inline-block;
      padding: 2px 12px;
      border-radius: 7px;
      margin-bottom: 0.5em;
      font-weight: 500;
      letter-spacing: 0.5px;
    }
    .produk-qty {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 0.5em;
      gap: 10px;
    }
    .produk-qty-btn {
      background: #eee;
      border: none;
      border-radius: 50%;
      width: 28px;
      height: 28px;
      font-size: 1.1em;
      color: #ff8400;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.15s;
    }
    .produk-qty-btn:active, .produk-qty-btn:focus {
      background: #ffecd1;
      color: #d36c00;
      outline: none;
    }
    .produk-qty-num {
      min-width: 24px;
      text-align: center;
      font-weight: 600;
      color: #ff8400;
      font-size: 1.08em;
    }
    @media (max-width: 991px) {
      .produk-img {
        height: 130px;
      }
    }
    @media (max-width: 767px) {
      .produk-img {
        height: 110px;
      }
    }
    @media (max-width: 575px) {
      .produk-img {
        height: 90px;
      }
    }
    .btn-orange {
        background: #ff8400;
        color: #fff;
        border-radius: 6px;
        font-weight: 500;
        border: none;
        padding: 8px 16px;
        transition: background 0.18s;
    }
    .btn-orange:hover, .btn-orange:focus {
        background: #d36c00;
        color: #fff;
    }
    .navbar {
      box-shadow: 0 2px 10px rgba(255,132,0,0.08);
    }
    .navbar-nav .nav-link.active {
      color: #fff !important;
      background: #ff8400 !important;
      border-radius: 7px;
    }
    .navbar-nav .nav-link {
      font-weight: 500;
      color: #ff8400 !important;
      margin-right: 4px;
      transition: background .12s;
    }
    .navbar-nav .nav-link:hover {
      background: #ffecd1;
      color: #d36c00 !important;
    }
    .navbar-admin {
      margin-left: auto;
    }
  </style>
</head>
<body>
  <!-- Top Menu -->
  <nav class="navbar navbar-expand-lg bg-white mb-4">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php" style="color:#ff8400">TOKO</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? ' active' : '' ?>" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'cart.php' ? ' active' : '' ?>" href="cart.php">Keranjang</a>
          </li>
        </ul>
        <ul class="navbar-nav navbar-admin">
          <li class="nav-item">
            <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'products.php' ? ' active' : '' ?>" href="products.php">Admin</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-3">
    <h2 class="mb-4 fw-bold text-center" style="color:#ff8400">Daftar Produk</h2>
    <form method="get" class="row mb-4 justify-content-center">
      <div class="col-md-4 col-sm-8 mb-2">
        <select class="form-select" name="kategori" id="kategori">
          <option value="all" <?= $selectedKategori == 'all' || $selectedKategori == '' ? 'selected' : '' ?>>Semua Kategori</option>
          <?php foreach ($kategoriList as $kat): ?>
            <option value="<?= htmlspecialchars($kat) ?>" <?= $selectedKategori == $kat ? 'selected' : '' ?>><?= htmlspecialchars($kat) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2 col-sm-4 mb-2">
        <button type="submit" class="btn btn-orange w-100">Filter</button>
      </div>
    </form>
    <div class="row" id="produk-list">
      <?php if (empty($produk)): ?>
        <div class="col-12">
          <div class="alert alert-warning text-center">Produk dengan kategori tersebut tidak ditemukan.</div>
        </div>
      <?php else: ?>
        <?php foreach ($produk as $item): 
          $id = $item['Id'];
        ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
            <div class="produk-card w-100 p-2">
              <img src="<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama_produk']) ?>" class="produk-img w-100 mb-2">
              <span class="produk-kategori"><?= htmlspecialchars($item['kategori']) ?></span>
              <div class="produk-title"><?= htmlspecialchars($item['nama_produk']) ?></div>
              <div class="produk-harga"><?= htmlspecialchars($item['harga']) ?></div>
              <div class="produk-desc"><?= htmlspecialchars($item['deskripsi']) ?></div>
              <div class="produk-qty mt-auto mb-0">
                <button class="produk-qty-btn" onclick="return changeQty(<?= $id ?>, -1)"><i class="bi bi-dash"></i></button>
                <span class="produk-qty-num" id="qty-<?= $id ?>">1</span>
                <button class="produk-qty-btn" onclick="return changeQty(<?= $id ?>, 1)"><i class="bi bi-plus"></i></button>
              </div>
              <button class="produk-btn w-100" onclick="return addToCart(<?= $id ?>)">
                <i class="bi bi-cart-plus"></i> Tambah
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Simpan qty produk di object JS (bisa diganti dengan sessionStorage/localStorage jika mau persist)
    var qtyProduk = {};
    <?php foreach ($produk as $item): ?>
      qtyProduk[<?= $item['Id'] ?>] = 1;
    <?php endforeach; ?>

    function changeQty(id, delta) {
      var elNum = document.getElementById('qty-' + id);
      var qty = qtyProduk[id] || 1;
      qty += delta;
      if (qty < 1) qty = 1;
      qtyProduk[id] = qty;
      elNum.textContent = qty;
      return false;
    }

    function addToCart(id) {
      var qty = qtyProduk[id] || 1;
      fetch('add_to_cart.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'product_id=' + id + '&qty=' + qty
      })
      .then(res => res.json())
      .then(data => {
        if (data.status == 'ok') {
          alert('Produk berhasil ditambahkan ke keranjang!');
          window.location.href = 'cart.php';
        } else {
          alert('Gagal menambah ke keranjang.');
        }
      });
      return false;
    }
  </script>
</body>
</html>