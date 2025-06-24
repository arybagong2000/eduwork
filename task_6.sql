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