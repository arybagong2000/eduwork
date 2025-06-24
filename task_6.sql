CREATE DATABASE toko;
USE toko;
-- Table: Products
CREATE TABLE Products (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    nama_produk VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    deskripsi TEXT,
    Stok INT NOT NULL
);

-- Table: Users
CREATE TABLE Users (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
);

-- Table: Orders (dengan foreign key ke Users dan Products)
CREATE TABLE Orders (
    Order_id INT PRIMARY KEY AUTO_INCREMENT,
    User_id INT NOT NULL,
    Product_id INT NOT NULL,
    Quantity INT NOT NULL,
    Total INT NOT NULL,
    FOREIGN KEY (User_id) REFERENCES Users(Id),
    FOREIGN KEY (Product_id) REFERENCES Products(Id)
);

-- Insert data ke tabel Products
INSERT INTO Products (nama_produk, harga, deskripsi, Stok) VALUES
('Kemeja Linen Pria', 159000, 'Kemeja lengan panjang bahan linen premium, adem dan stylish untuk segala suasana.', 20),
('Sneakers Putih Wanita', 249000, 'Sepatu sneakers putih unisex, ringan, nyaman, cocok untuk aktivitas harian.', 15),
('Jam Tangan Digital', 199000, 'Jam tangan digital sporty, tahan air, fitur alarm dan stopwatch.', 10),
('Tas Ransel Kulit', 299000, 'Tas ransel kulit sintetis premium, banyak kompartemen, cocok untuk kerja/kuliah.', 8);

-- Insert data ke tabel Users
INSERT INTO Users (nama, email, password) VALUES
('Budi Santoso', 'budi@mail.com', 'passwordbudi'),
('Siti Aminah', 'siti@mail.com', 'passwordsiti'),
('Joko Widodo', 'joko@mail.com', 'passwordjoko');

-- Insert data ke tabel Orders
INSERT INTO Orders (User_id, Product_id, Quantity, Total) VALUES
(1, 1, 2, 318000),  -- Budi beli 2 Kemeja Linen Pria
(2, 2, 1, 249000),  -- Siti beli 1 Sneakers Putih Wanita
(3, 3, 1, 199000),  -- Joko beli 1 Jam Tangan Digital
(1, 4, 1, 299000);  -- Budi beli 1 Tas Ransel Kulit

-- Update data pada tabel Products
UPDATE Products
SET nama_produk = 'Kemeja Linen Lengan Pendek',
    harga = 145000,
    deskripsi = 'Kemeja linen lengan pendek, nyaman untuk dipakai sehari-hari.',
    Stok = 25
WHERE Id = 1;

-- Update data pada tabel Users
UPDATE Users
SET nama = 'Budi Setiawan',
    email = 'budi.setiawan@mail.com',
    password = 'newpassbudi'
WHERE Id = 1;

-- Update data pada tabel Orders
UPDATE Orders
SET User_id = 2,
    Product_id = 3,
    Quantity = 2,
    Total = 398000
WHERE Order_id = 1;

-- Hapus data dari tabel Orders (misal hapus order dengan Order_id = 1)
DELETE FROM Orders WHERE Order_id = 1;

-- Hapus data dari tabel Users (misal hapus user dengan Id = 1)
DELETE FROM Users WHERE Id = 1;

-- Hapus data dari tabel Products (misal hapus produk dengan Id = 1)
DELETE FROM Products WHERE Id = 1;

-- Membaca data dari tabel Products
SELECT * FROM Products;

-- Membaca data dari tabel Users
SELECT * FROM Users;

-- Membaca data dari tabel Orders
SELECT * FROM Orders;

-- Melihat data pesanan (Orders) beserta nama user dan nama produk, dengan relasi
SELECT
  Orders.Order_id,
  Users.nama AS nama_user,
  Products.nama_produk,
  Orders.Quantity,
  Orders.Total
FROM Orders
JOIN Users ON Orders.User_id = Users.Id
JOIN Products ON Orders.Product_id = Products.Id;

-- Jika ingin menampilkan semua data detail:
SELECT
  Orders.Order_id,
  Users.Id AS user_id,
  Users.nama AS nama_user,
  Users.email,
  Products.Id AS product_id,
  Products.nama_produk,
  Products.harga,
  Products.deskripsi,
  Products.Stok,
  Orders.Quantity,
  Orders.Total
FROM Orders
JOIN Users ON Orders.User_id = Users.Id
JOIN Products ON Orders.Product_id = Products.Id;