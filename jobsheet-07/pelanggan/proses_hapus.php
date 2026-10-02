<?php
session_start();
require_once __DIR__ . '/../includes/data.php';
muatData();

$id = $_POST['id'] ?? '';
$nama = '';

foreach ($_SESSION['pelanggan'] as $indeks => $p) {
    if ($p['id'] === $id) {
        $nama = $p['nama'];
        unset($_SESSION['pelanggan'][$indeks]);
        $_SESSION['pelanggan'] = array_values($_SESSION['pelanggan']);
        break;
    }
}

if ($nama !== '') {
    setFlash('success', 'Pelanggan "' . $nama . '" dihapus.');
} else {
    setFlash('error', 'Pelanggan tidak ditemukan.');
}
header('Location: list.php');
exit;
