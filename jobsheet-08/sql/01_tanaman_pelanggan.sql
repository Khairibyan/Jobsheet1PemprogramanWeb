CREATE TABLE tanaman (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(120) NOT NULL,
    kategori VARCHAR(20) NOT NULL CHECK (kategori IN ('Kaktus', 'Sukulen', 'Lainnya')),
    harga INTEGER NOT NULL CHECK (harga >= 0),
    stok INTEGER NOT NULL DEFAULT 0 CHECK (stok >= 0),
    foto VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL DEFAULT '',
    shopee VARCHAR(255) NOT NULL DEFAULT '',
    created_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE pelanggan (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    whatsapp VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL DEFAULT '',
    kota VARCHAR(60) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW()
);

INSERT INTO tanaman (nama, kategori, harga, stok, foto, deskripsi, shopee) VALUES
('Mammillaria Spinosissima', 'Kaktus', 45000, 24, 'assets/img/mammillaria.svg', 'Kaktus bulat berduri halus dengan mahkota bunga pink saat musim berbunga.', 'https://shopee.co.id/'),
('Cereus Peruvianus', 'Kaktus', 65000, 12, 'assets/img/cereus.svg', 'Kaktus tiang tinggi yang kuat, cocok untuk sudut teras yang terang.', 'https://shopee.co.id/'),
('Echeveria Elegans', 'Sukulen', 35000, 30, 'assets/img/echeveria.svg', 'Roset biru kehijauan yang rapi, favorit untuk hiasan meja kerja.', 'https://shopee.co.id/'),
('Haworthia Zebra', 'Sukulen', 40000, 18, 'assets/img/haworthia.svg', 'Daun runcing bergaris putih, tahan di dalam ruangan dengan cahaya cukup.', 'https://shopee.co.id/'),
('Opuntia Bunny Ears', 'Kaktus', 55000, 9, 'assets/img/opuntia.svg', 'Batang pipih menyerupai telinga kelinci, tumbuh melebar dengan cepat.', 'https://shopee.co.id/'),
('Aloe Vera Mini', 'Lainnya', 30000, 20, 'assets/img/aloe.svg', 'Lidah buaya ukuran pot kecil, mudah dirawat dan serbaguna.', '');

INSERT INTO pelanggan (nama, whatsapp, email, kota) VALUES
('Andini Putri', '081234500111', 'andini@mail.com', 'Malang'),
('Bagus Santoso', '085755500222', '', 'Batu'),
('Citra Lestari', '082133300333', 'citra@mail.com', 'Surabaya');
