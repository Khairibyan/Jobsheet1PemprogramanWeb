<?php
session_start();
require_once __DIR__ . '/../includes/data.php';
muatData();

$id = $_POST['id'] ?? '';
$nama = '';

foreach ($_SESSION['tanaman'] as $indeks => $t) {
    if ($t['id'] === $id) {
        $nama = $t['nama'];
        if (strpos($t['foto'], 'uploads/') === 0) {
            $path = __DIR__ . '/../' . $t['foto'];
            if (is_file($path)) {
                unlink($path);
            }
        }
        unset($_SESSION['tanaman'][$indeks]);
        $_SESSION['tanaman'] = array_values($_SESSION['tanaman']);
        break;
    }
}

if ($nama !== '') {
    setFlash('success', 'Tanaman "' . $nama . '" dihapus.');
} else {
    setFlash('error', 'Tanaman tidak ditemukan.');
}
header('Location: list.php');
exit;
