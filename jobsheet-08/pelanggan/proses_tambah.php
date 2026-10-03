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
    'whatsapp' => trim($_POST['whatsapp'] ?? ''),
    'kota' => trim($_POST['kota'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
];

$errors = validasiPelanggan($data);

if (!empty($errors)) {
    $_SESSION['old'] = $data;
    setFlash('error', implode(' ', $errors));
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    'INSERT INTO pelanggan (nama, whatsapp, email, kota)
     VALUES (:nama, :whatsapp, :email, :kota)
     RETURNING id'
);
$stmt->execute([
    ':nama' => $data['nama'],
    ':whatsapp' => $data['whatsapp'],
    ':email' => $data['email'],
    ':kota' => $data['kota'],
]);

setFlash('success', 'Pelanggan "' . $data['nama'] . '" berhasil ditambahkan.');
header('Location: list.php');
exit;
