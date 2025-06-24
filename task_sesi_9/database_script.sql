-- 1. Membuat tabel Products dengan kategori dan gambar
CREATE TABLE Products (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    nama_produk VARCHAR(100) NOT NULL,
    harga VARCHAR(20) NOT NULL,
    deskripsi TEXT NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    kategori VARCHAR(50) NOT NULL
);

-- 2. Insert data sesuai array produk di atas
INSERT INTO Products (nama_produk, harga, deskripsi, gambar, kategori) VALUES
('Kemeja Linen Pria', 'Rp 159.000', 'Kemeja lengan panjang bahan linen premium, adem dan stylish untuk segala suasana.', 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=400&q=80', 'Fashion'),
('Sneakers Putih Wanita', 'Rp 249.000', 'Sepatu sneakers putih unisex, ringan, nyaman, cocok untuk aktivitas harian.', 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=400&q=80', 'Fashion'),
('Jam Tangan Digital', 'Rp 199.000', 'Jam tangan digital sporty, tahan air, fitur alarm dan stopwatch.', 'https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b?auto=format&fit=crop&w=400&q=80', 'Aksesoris'),
('Tas Ransel Kulit', 'Rp 299.000', 'Tas ransel kulit sintetis premium, banyak kompartemen, cocok untuk kerja/kuliah.', 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80', 'Fashion'),
('Headphone Bluetooth', 'Rp 189.000', 'Headphone wireless bluetooth, suara jernih, baterai tahan lama.', 'https://images.unsplash.com/photo-1511367461989-f85a21fda167?auto=format&fit=crop&w=400&q=80', 'Elektronik'),
('Baju Kaos Polos', 'Rp 69.000', 'Kaos polos bahan cotton combed 30s, nyaman dipakai sehari-hari.', 'https://images.unsplash.com/photo-1512436991641-f9633a875f6f?auto=format&fit=crop&w=400&q=80', 'Fashion'),
('Botol Minum Stainless', 'Rp 59.000', 'Botol minum stainless steel 500ml, menjaga suhu minuman lebih lama.', 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80', 'Aksesoris'),
('Dompet Kulit Pria', 'Rp 79.000', 'Dompet kulit pria minimalis dengan banyak slot kartu dan uang.', 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80', 'Aksesoris');

-- 3. Membuat tabel carts
CREATE TABLE carts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    session_id VARCHAR(64) NOT NULL,
    qty INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES Products(Id)
);