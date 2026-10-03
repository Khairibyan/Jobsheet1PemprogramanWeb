<?php
$page_title = 'Daftar Pelanggan';
$aktif = 'pelanggan';
include __DIR__ . '/../includes/header.php';

$flash = ambilFlash();
$daftar = $pdo->query('SELECT * FROM pelanggan ORDER BY id DESC')->fetchAll();
?>
        <section class="band">
            <div class="wrap">
                <h1>Daftar Pelanggan</h1>
                <p>Catatan pembeli yang pernah memesan tanaman.</p>
            </div>
        </section>

        <section class="seksi">
            <div class="wrap">
                <?php if ($flash): ?>
                <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
                <?php endif; ?>

                <div class="toolbar">
                    <input type="search" id="cari" placeholder="Cari nama pelanggan...">
                    <span class="jumlah"><b id="jumlah-tampil"><?php echo count($daftar); ?></b> pelanggan</span>
                    <a class="btn btn-gelap" href="tambah.php">+ Tambah Pelanggan</a>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>WhatsApp</th>
                                <th>Kota</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftar)): ?>
                            <tr><td colspan="4" class="kosong">Belum ada pelanggan.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($daftar as $p): ?>
                            <tr data-cari="<?php echo e(strtolower($p['nama'])); ?>">
                                <td>
                                    <div class="sel-produk">
                                        <span class="avatar"><?php echo e(strtoupper(substr($p['nama'], 0, 1))); ?></span>
                                        <div>
                                            <strong><?php echo e($p['nama']); ?></strong>
                                            <small><?php echo $p['email'] !== '' ? e($p['email']) : 'Tanpa email'; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo e($p['whatsapp']); ?></td>
                                <td><?php echo e($p['kota']); ?></td>
                                <td class="aksi">
                                    <a class="btn btn-kecil btn-garis-gelap" href="<?php echo e(linkWa($p['whatsapp'], 'Halo ' . $p['nama'] . ', ')); ?>" target="_blank" rel="noopener">Chat</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <tr id="baris-kosong" hidden><td colspan="4" class="kosong">Tidak ada pelanggan yang cocok.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
