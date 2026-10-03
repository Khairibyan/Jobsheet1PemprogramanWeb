<?php
session_start();
require_once __DIR__ . '/fungsi.php';
require_once __DIR__ . '/koneksi.php';

$akar = str_replace('\\', '/', dirname(__DIR__));
$folder = str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME']));
$rel = trim(substr($folder, strlen($akar)), '/');
$base = $rel === '' ? '' : str_repeat('../', substr_count($rel, '/') + 1);
$aktif = $aktif ?? '';
$menu = [
    'beranda' => ['index.php', 'Beranda'],
    'tanaman' => ['tanaman/list.php', 'Koleksi'],
    'pelanggan' => ['pelanggan/list.php', 'Pelanggan'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? e($page_title) . ' | ' : ''; ?>Nursery Kaktus Malang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div class="wrap topbar-inner">
            <a class="logo" href="<?php echo $base; ?>index.php">Nursery<span>Kaktus</span>.Malang</a>
            <button type="button" id="nav-toggle-btn" class="nav-toggle" aria-label="Menu">&#9776;</button>
            <nav id="menu-utama">
                <ul>
                    <?php foreach ($menu as $kunci => $item): ?>
                    <li><a href="<?php echo $base . $item[0]; ?>"<?php echo $aktif === $kunci ? ' class="aktif"' : ''; ?>><?php echo $item[1]; ?></a></li>
                    <?php endforeach; ?>
                    <li><a class="btn btn-gelap" href="<?php echo $base; ?>tanaman/tambah.php">+ Tambah Tanaman</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
