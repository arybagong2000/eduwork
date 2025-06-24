<?php
include 'connect_db.php';

// Notifikasi
$notif = '';
if (isset($_GET['notif'])) {
    $msg = '';
    switch ($_GET['notif']) {
        case 'add': $msg = 'Produk berhasil ditambahkan.'; break;
        case 'edit': $msg = 'Produk berhasil diubah.'; break;
        case 'delete': $msg = 'Produk berhasil dihapus.'; break;
    }
    if ($msg) {
        $notif = '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">'.$msg.
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}

// Proses hapus data
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM Products WHERE Id=$id");
    header("Location: products.php?notif=delete");
    exit();
}

// Proses tambah data
if (isset($_POST['create'])) {
    $nama = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_POST['gambar'];
    mysqli_query($conn, "INSERT INTO Products (nama_produk,kategori,harga,deskripsi,gambar) VALUES ('$nama','$kategori','$harga','$deskripsi','$gambar')");
    header("Location: products.php?notif=add");
    exit();
}

// Proses update data
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nama = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_POST['gambar'];
    mysqli_query($conn, "UPDATE Products SET nama_produk='$nama', kategori='$kategori', harga='$harga', deskripsi='$deskripsi', gambar='$gambar' WHERE Id=$id");
    header("Location: products.php?notif=edit");
    exit();
}

// Ambil data untuk edit jika ada permintaan edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = mysqli_query($conn, "SELECT * FROM Products WHERE Id=$id");
    $editData = mysqli_fetch_assoc($res);
}

// Ambil semua data produk
$produk = mysqli_query($conn, "SELECT * FROM Products ORDER BY Id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DAFTAR PRODUK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-orange { background: #ff8400; color:#fff; border: none; }
        .btn-orange:hover { background: #d36c00; color: #fff; }
        .produk-img {height:56px;width:56px;object-fit:cover;border-radius:8px;}
        .card {box-shadow:0 2px 12px rgba(255,132,0,0.06);}
        .hide {display:none;}
        .navbar {box-shadow: 0 2px 10px rgba(255,132,0,0.08);}
        .navbar-nav .nav-link.active {color: #fff !important; background: #ff8400 !important; border-radius: 7px; }
        .navbar-nav .nav-link {font-weight: 500; color: #ff8400 !important; margin-right: 4px; transition: background .12s; }
        .navbar-nav .nav-link:hover {background: #ffecd1; color: #d36c00 !important;}
        .navbar-admin {margin-left: auto; }
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
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center" style="color:#ff8400">DAFTAR PRODUK</h2>
    <?= $notif ?>
    
    <!-- Button Tambah Produk (hanya tampil jika tidak sedang add/edit) -->
    <div id="btn-tambah-wrap" class="mb-3 text-end <?= ($editData ? 'hide' : '') ?>">
        <button class="btn btn-orange" id="btn-tambah">Tambah Produk</button>
    </div>
    
    <!-- Form Tambah/Edit -->
    <div class="card mb-4 <?= ($editData ? '' : 'hide') ?>" id="form-produk-wrap">
        <div class="card-header"><?= $editData ? 'Edit Produk' : 'Tambah Produk' ?></div>
        <div class="card-body">
            <form method="post" id="form-produk">
                <?php if ($editData): ?>
                    <input type="hidden" name="id" value="<?= $editData['Id'] ?>">
                <?php endif; ?>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required value="<?= $editData ? htmlspecialchars($editData['nama_produk']) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" required value="<?= $editData ? htmlspecialchars($editData['kategori']) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Harga</label>
                        <input type="text" name="harga" class="form-control" required value="<?= $editData ? htmlspecialchars($editData['harga']) : '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="2" required><?= $editData ? htmlspecialchars($editData['deskripsi']) : '' ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">URL Gambar</label>
                        <input type="text" name="gambar" class="form-control" required value="<?= $editData ? htmlspecialchars($editData['gambar']) : '' ?>">
                    </div>
                </div>
                <div class="mt-3">
                    <?php if ($editData): ?>
                        <button type="submit" name="update" class="btn btn-orange">Update</button>
                        <a href="products.php" class="btn btn-secondary ms-2" id="batal-edit">Batal</a>
                    <?php else: ?>
                        <button type="submit" name="create" class="btn btn-orange">Tambah</button>
                        <button type="button" class="btn btn-secondary ms-2" id="batal-tambah">Batal</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    
    <!-- List Produk -->
    <div class="card <?= ($editData ? 'hide' : '') ?>" id="list-produk-wrap">
        <div class="card-header">Daftar Produk</div>
        <div class="card-body p-0">
            <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
                <thead style="background:#ff8400;color:#fff;">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="10%">Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th width="17%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($produk)): ?>
                        <tr>
                            <td><?= $row['Id'] ?></td>
                            <td><img src="<?= htmlspecialchars($row['gambar']) ?>" class="produk-img"></td>
                            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                            <td><?= htmlspecialchars($row['kategori']) ?></td>
                            <td><?= htmlspecialchars($row['harga']) ?></td>
                            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                            <td>
                                <a href="products.php?edit=<?= $row['Id'] ?>" class="btn btn-sm btn-warning btn-edit">Edit</a>
                                <a href="products.php?delete=<?= $row['Id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin ingin hapus produk ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if (mysqli_num_rows($produk) == 0): ?>
                        <tr><td colspan="7" class="text-center">Belum ada produk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var btnTambah = document.getElementById('btn-tambah');
    var formWrap = document.getElementById('form-produk-wrap');
    var listWrap = document.getElementById('list-produk-wrap');
    var btnWrap = document.getElementById('btn-tambah-wrap');
    var batalTambah = document.getElementById('batal-tambah');
    var batalEdit = document.getElementById('batal-edit');

    // Tampilkan form tambah produk
    if(btnTambah) {
        btnTambah.addEventListener('click', function() {
            formWrap.classList.remove('hide');
            listWrap.classList.add('hide');
            btnWrap.classList.add('hide');
            // kosongkan form
            var fields = formWrap.querySelectorAll('input[type="text"], textarea');
            fields.forEach(f => f.value = '');
            formWrap.querySelector('button[name="create"]').style.display = '';
            if (formWrap.querySelector('button[name="update"]')) {
                formWrap.querySelector('button[name="update"]').style.display = 'none';
            }
        });
    }
    // Batal tambah
    if(batalTambah) {
        batalTambah.addEventListener('click', function() {
            formWrap.classList.add('hide');
            listWrap.classList.remove('hide');
            btnWrap.classList.remove('hide');
        });
    }
    // Batal edit (kembali ke list)
    if(batalEdit) {
        batalEdit.addEventListener('click', function(e) {
            // biar reload ke list saja
            e.preventDefault();
            window.location.href = "products.php";
        });
    }
});
</script>
</body>
</html>