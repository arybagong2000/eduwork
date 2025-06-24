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
      margin-top: auto;
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
  </style>
</head>
<body>
  <div class="container py-5">
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
        <?php foreach ($produk as $item): ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
            <div class="produk-card w-100 p-2">
              <img src="<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama_produk']) ?>" class="produk-img w-100 mb-2">
              <span class="produk-kategori"><?= htmlspecialchars($item['kategori']) ?></span>
              <div class="produk-title"><?= htmlspecialchars($item['nama_produk']) ?></div>
              <div class="produk-harga"><?= htmlspecialchars($item['harga']) ?></div>
              <div class="produk-desc"><?= htmlspecialchars($item['deskripsi']) ?></div>
              <button class="produk-btn mt-auto w-100">Beli Sekarang</button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>