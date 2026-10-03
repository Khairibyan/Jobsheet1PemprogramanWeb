<?php
session_start();
require_once __DIR__ . '/../includes/fungsi.php';
require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$data = [
    'nama' => trim($_POST['nama'] ?? ''),
    'kategori' => $_POST['kategori'] ?? '',
    'harga' => trim($_POST['harga'] ?? ''),
    'stok' => trim($_POST['stok'] ?? ''),
    'deskripsi' => trim($_POST['deskripsi'] ?? ''),
    'shopee' => trim($_POST['shopee'] ?? ''),
];

$errors = validasiTanaman($data);
[$galatFoto, $ekstensi] = periksaFoto($_FILES['foto'] ?? null);
if ($galatFoto) {
    $errors[] = $galatFoto;
}

if (!empty($errors)) {
    $_SESSION['old'] = $data;
    setFlash('error', implode(' ', $errors));
    header('Location: tambah.php');
    exit;
}

$foto = FOTO_DEFAULT[$data['kategori']];
if ($ekstensi !== null) {
    $foto = simpanFoto($_FILES['foto'], $ekstensi) ?? $foto;
}

$stmt = $pdo->prepare(
    'INSERT INTO tanaman (nama, kategori, harga, stok, foto, deskripsi, shopee)
     VALUES (:nama, :kategori, :harga, :stok, :foto, :deskripsi, :shopee)
     RETURNING id'
);
$stmt->execute([
    ':nama' => $data['nama'],
    ':kategori' => $data['kategori'],
    ':harga' => (int) $data['harga'],
    ':stok' => (int) $data['stok'],
    ':foto' => $foto,
    ':deskripsi' => $data['deskripsi'] !== '' ? $data['deskripsi'] : 'Belum ada deskripsi.',
    ':shopee' => $data['shopee'],
]);

setFlash('success', 'Tanaman "' . $data['nama'] . '" berhasil ditambahkan.');
header('Location: list.php');
exit;
