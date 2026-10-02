<?php
session_start();
require_once __DIR__ . '/../includes/data.php';
muatData();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$kategori = $_POST['kategori'] ?? '';
$harga = trim($_POST['harga'] ?? '');
$stok = trim($_POST['stok'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$shopee = trim($_POST['shopee'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = 'Nama tanaman wajib diisi.';
}
if (!in_array($kategori, KATEGORI, true)) {
    $errors[] = 'Kategori tidak valid.';
}
if (!ctype_digit($harga) || (int) $harga < 1000) {
    $errors[] = 'Harga minimal Rp1.000.';
}
if (!ctype_digit($stok)) {
    $errors[] = 'Stok harus berupa angka 0 atau lebih.';
}
if ($shopee !== '' && !filter_var($shopee, FILTER_VALIDATE_URL)) {
    $errors[] = 'Link Shopee tidak valid.';
}

$foto = FOTO_DEFAULT[$kategori] ?? FOTO_DEFAULT['Lainnya'];
$berkas = $_FILES['foto'] ?? null;
$ekstensiFoto = null;

if ($berkas && $berkas['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($berkas['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Foto gagal diunggah.';
    } elseif ($berkas['size'] > 2 * 1024 * 1024) {
        $errors[] = 'Ukuran foto maksimal 2 MB.';
    } else {
        $tipe = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
        $info = @getimagesize($berkas['tmp_name']);
        if (!$info || !isset($tipe[$info[2]])) {
            $errors[] = 'Format foto harus JPG, PNG, atau WEBP.';
        } else {
            $ekstensiFoto = $tipe[$info[2]];
        }
    }
}

if (!empty($errors)) {
    $_SESSION['old'] = ['nama' => $nama, 'kategori' => $kategori, 'harga' => $harga, 'stok' => $stok, 'deskripsi' => $deskripsi, 'shopee' => $shopee];
    setFlash('error', implode(' ', $errors));
    header('Location: tambah.php');
    exit;
}

if ($ekstensiFoto !== null) {
    $folder = __DIR__ . '/../uploads';
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
    $namaFile = uniqid('tanaman_', true) . '.' . $ekstensiFoto;
    if (move_uploaded_file($berkas['tmp_name'], $folder . '/' . $namaFile)) {
        $foto = 'uploads/' . $namaFile;
    }
}

$_SESSION['tanaman'][] = [
    'id' => uniqid('t'),
    'nama' => $nama,
    'kategori' => $kategori,
    'harga' => (int) $harga,
    'stok' => (int) $stok,
    'foto' => $foto,
    'deskripsi' => $deskripsi !== '' ? $deskripsi : 'Belum ada deskripsi.',
    'shopee' => $shopee,
];

setFlash('success', 'Tanaman "' . $nama . '" berhasil ditambahkan.');
header('Location: list.php');
exit;
