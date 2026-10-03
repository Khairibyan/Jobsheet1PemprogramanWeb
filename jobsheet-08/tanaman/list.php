<?php
$page_title = 'Koleksi Tanaman';
$aktif = 'tanaman';
include __DIR__ . '/../includes/header.php';

$flash = ambilFlash();
$daftar = $pdo->query('SELECT * FROM tanaman ORDER BY id DESC')->fetchAll();
?>
        <section class="band">
            <div class="wrap">
                <h1>Koleksi Tanaman</h1>
                <p>Kelola stok kaktus dan sukulen yang tersedia di nursery.</p>
            </div>
        </section>

        <section class="seksi">
            <div class="wrap">
                <?php if ($flash): ?>
                <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
                <?php endif; ?>

                <div class="toolbar">
                    <input type="search" id="cari" placeholder="Cari nama tanaman...">
                    <select id="filter-kategori">
                        <option value="">Semua kategori</option>
                        <?php foreach (KATEGORI as $k): ?>
                        <option value="<?php echo e($k); ?>"><?php echo e($k); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="jumlah"><b id="jumlah-tampil"><?php echo count($daftar); ?></b> tanaman</span>
                    <a class="btn btn-gelap" href="tambah.php">+ Tambah Tanaman</a>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanaman</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftar)): ?>
                            <tr><td colspan="5" class="kosong">Belum ada tanaman. Tambahkan lewat tombol di atas.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($daftar as $t): ?>
                            <tr data-cari="<?php echo e(strtolower($t['nama'])); ?>" data-kategori="<?php echo e($t['kategori']); ?>">
                                <td>
                                    <div class="sel-produk">
                                        <img class="thumb" src="<?php echo $base . e($t['foto']); ?>" alt="<?php echo e($t['nama']); ?>">
                                        <div>
                                            <strong><?php echo e($t['nama']); ?></strong>
                                            <small><?php echo e($t['deskripsi']); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="pill pill-<?php echo strtolower(e($t['kategori'])); ?>"><?php echo e($t['kategori']); ?></span></td>
                                <td><?php echo rupiah($t['harga']); ?></td>
                                <td><?php echo (int) $t['stok']; ?></td>
                                <td class="aksi">
                                    <?php if ($t['shopee'] !== ''): ?>
                                    <a class="btn btn-kecil btn-garis-gelap" href="<?php echo e($t['shopee']); ?>" target="_blank" rel="noopener">Shopee</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <tr id="baris-kosong" hidden><td colspan="5" class="kosong">Tidak ada tanaman yang cocok.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
