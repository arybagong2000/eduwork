<?php
// Panggil file ini via AJAX/fetch/POST dari produk.php saat klik tombol tambah cart
session_start();
include 'connect_db.php';

header('Content-Type: application/json');

// Pastikan method POST dan ada data yang dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && isset($_POST['qty'])) {
    $pid = intval($_POST['product_id']);
    $qty = max(1, intval($_POST['qty']));
    if (!isset($_SESSION['cart_sid'])) {
        $_SESSION['cart_sid'] = session_id();
    }
    $sid = $_SESSION['cart_sid'];

    // Cek apakah produk tsb sudah ada di cart session ini
    $cek = mysqli_query($conn, "SELECT * FROM carts WHERE session_id='$sid' AND product_id=$pid");
    if ($row = mysqli_fetch_assoc($cek)) {
        // Jika sudah ada, tambahkan qty
        $newqty = $row['qty'] + $qty;
        mysqli_query($conn, "UPDATE carts SET qty=$newqty WHERE id=".$row['id']);
    } else {
        // Jika belum ada, insert baru
        mysqli_query($conn, "INSERT INTO carts (product_id, session_id, qty) VALUES ($pid, '$sid', $qty)");
    }
    echo json_encode(['status'=>'ok', 'message'=>'Produk ditambahkan ke keranjang.']);
} else {
    echo json_encode(['status'=>'fail', 'message'=>'Gagal menambah cart.']);
}