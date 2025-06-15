-- Membuat tabel untuk pesanan
CREATE TABLE orders (
    id TEXT PRIMARY KEY,
    date TEXT NOT NULL,
    customer TEXT NOT NULL,
    total REAL NOT NULL,
    status TEXT NOT NULL CHECK(status IN ('pending', 'processing', 'completed', 'cancelled'))
);

-- Membuat tabel untuk pengiriman
CREATE TABLE shipping (
    id TEXT PRIMARY KEY,
    order_id TEXT NOT NULL,
    customer_name TEXT NOT NULL,
    customer_address TEXT NOT NULL,
    shipping_method TEXT NOT NULL CHECK(shipping_method IN ('reguler', 'express')),
    status TEXT NOT NULL CHECK(status IN ('pending', 'processing', 'shipped', 'delivered')),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Membuat tabel untuk item keranjang
CREATE TABLE cart_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id TEXT,
    product_name TEXT NOT NULL,
    price REAL NOT NULL,
    quantity INTEGER NOT NULL,
    subtotal REAL NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Memasukkan data contoh ke tabel orders
INSERT INTO orders (id, date, customer, total, status) VALUES
('ORD-001', '2023-05-15', 'Budi Santoso', 250000, 'completed'),
('ORD-002', '2023-05-16', 'Ani Wijaya', 180000, 'processing'),
('ORD-003', '2023-05-17', 'Citra Dewi', 320000, 'pending');

-- Memasukkan data contoh ke tabel shipping
INSERT INTO shipping (id, order_id, customer_name, customer_address, shipping_method, status) VALUES
('SHIP-001', 'ORD-001', 'Budi Santoso', 'Jl. Merdeka No. 123, Jakarta', 'reguler', 'shipped'),
('SHIP-002', 'ORD-002', 'Ani Wijaya', 'Jl. Sudirman No. 456, Bandung', 'reguler', 'processing'),
('SHIP-003', 'ORD-003', 'Citra Dewi', 'Jl. Gatot Subroto No. 789, Surabaya', 'express', 'pending');

-- Memasukkan data contoh ke tabel cart_items
INSERT INTO cart_items (order_id, product_name, price, quantity, subtotal) VALUES
('ORD-001', 'Tanaman Monstera', 100000, 2, 200000),
('ORD-001', 'Tanaman Kaktus', 50000, 1, 50000),
('ORD-002', 'Tanaman Lidah Buaya', 90000, 2, 180000),
('ORD-003', 'Tanaman Anggrek', 160000, 2, 320000);