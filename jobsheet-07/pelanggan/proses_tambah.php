<?php
session_start();
require_once __DIR__ . '/../includes/data.php';
muatData();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$whatsapp = trim($_POST['whatsapp'] ?? '');
$kota = trim($_POST['kota'] ?? '');
$email = trim($_POST['email'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = 'Nama wajib diisi.';
}
if (!preg_match('/^(\+62|62|0)8[0-9]{8,12}$/', $whatsapp)) {
    $errors[] = 'Nomor WhatsApp tidak valid.';
}
if ($kota === '') {
    $errors[] = 'Kota wajib diisi.';
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid.';
}

if (!empty($errors)) {
    $_SESSION['old'] = ['nama' => $nama, 'whatsapp' => $whatsapp, 'kota' => $kota, 'email' => $email];
    setFlash('error', implode(' ', $errors));
    header('Location: tambah.php');
    exit;
}

$_SESSION['pelanggan'][] = [
    'id' => uniqid('p'),
    'nama' => $nama,
    'whatsapp' => $whatsapp,
    'email' => $email,
    'kota' => $kota,
];

setFlash('success', 'Pelanggan "' . $nama . '" berhasil ditambahkan.');
header('Location: list.php');
exit;
