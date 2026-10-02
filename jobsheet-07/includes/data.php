<?php
const KATEGORI = ['Kaktus', 'Sukulen', 'Lainnya'];
const WA_NOMOR = '6281234567890';
const FOTO_DEFAULT = [
    'Kaktus' => 'assets/img/mammillaria.svg',
    'Sukulen' => 'assets/img/echeveria.svg',
    'Lainnya' => 'assets/img/aloe.svg',
];

function muatData()
{
    if (!isset($_SESSION['tanaman'])) {
        $_SESSION['tanaman'] = [
            ['id' => 't1', 'nama' => 'Mammillaria Spinosissima', 'kategori' => 'Kaktus', 'harga' => 45000, 'stok' => 24, 'foto' => 'assets/img/mammillaria.svg', 'deskripsi' => 'Kaktus bulat berduri halus dengan mahkota bunga pink saat musim berbunga.', 'shopee' => 'https://shopee.co.id/'],
            ['id' => 't2', 'nama' => 'Cereus Peruvianus', 'kategori' => 'Kaktus', 'harga' => 65000, 'stok' => 12, 'foto' => 'assets/img/cereus.svg', 'deskripsi' => 'Kaktus tiang tinggi yang kuat, cocok untuk sudut teras yang terang.', 'shopee' => 'https://shopee.co.id/'],
            ['id' => 't3', 'nama' => 'Echeveria Elegans', 'kategori' => 'Sukulen', 'harga' => 35000, 'stok' => 30, 'foto' => 'assets/img/echeveria.svg', 'deskripsi' => 'Roset biru kehijauan yang rapi, favorit untuk hiasan meja kerja.', 'shopee' => 'https://shopee.co.id/'],
            ['id' => 't4', 'nama' => 'Haworthia Zebra', 'kategori' => 'Sukulen', 'harga' => 40000, 'stok' => 18, 'foto' => 'assets/img/haworthia.svg', 'deskripsi' => 'Daun runcing bergaris putih, tahan di dalam ruangan dengan cahaya cukup.', 'shopee' => 'https://shopee.co.id/'],
            ['id' => 't5', 'nama' => 'Opuntia Bunny Ears', 'kategori' => 'Kaktus', 'harga' => 55000, 'stok' => 9, 'foto' => 'assets/img/opuntia.svg', 'deskripsi' => 'Batang pipih menyerupai telinga kelinci, tumbuh melebar dengan cepat.', 'shopee' => 'https://shopee.co.id/'],
            ['id' => 't6', 'nama' => 'Aloe Vera Mini', 'kategori' => 'Lainnya', 'harga' => 30000, 'stok' => 20, 'foto' => 'assets/img/aloe.svg', 'deskripsi' => 'Lidah buaya ukuran pot kecil, mudah dirawat dan serbaguna.', 'shopee' => ''],
        ];
    }
    if (!isset($_SESSION['pelanggan'])) {
        $_SESSION['pelanggan'] = [
            ['id' => 'p1', 'nama' => 'Andini Putri', 'whatsapp' => '081234500111', 'email' => 'andini@mail.com', 'kota' => 'Malang'],
            ['id' => 'p2', 'nama' => 'Bagus Santoso', 'whatsapp' => '085755500222', 'email' => '', 'kota' => 'Batu'],
            ['id' => 'p3', 'nama' => 'Citra Lestari', 'whatsapp' => '082133300333', 'email' => 'citra@mail.com', 'kota' => 'Surabaya'],
        ];
    }
}

function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

function rupiah($angka)
{
    return 'Rp' . number_format((int) $angka, 0, ',', '.');
}

function setFlash($tipe, $pesan)
{
    $_SESSION['flash'] = ['type' => $tipe, 'pesan' => $pesan];
}

function ambilFlash()
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function linkWa($nomor, $pesan = '')
{
    $bersih = preg_replace('/\D/', '', $nomor);
    if (strpos($bersih, '0') === 0) {
        $bersih = '62' . substr($bersih, 1);
    }
    return 'https://wa.me/' . $bersih . ($pesan !== '' ? '?text=' . rawurlencode($pesan) : '');
}
