<?php
$page_title = 'Beranda';
$aktif = 'beranda';
include __DIR__ . '/includes/header.php';

$totalJenis = (int) $pdo->query('SELECT COUNT(*) FROM tanaman')->fetchColumn();
$totalStok = (int) $pdo->query('SELECT COALESCE(SUM(stok), 0) FROM tanaman')->fetchColumn();
$totalPelanggan = (int) $pdo->query('SELECT COUNT(*) FROM pelanggan')->fetchColumn();
$pilihan = $pdo->query('SELECT * FROM tanaman ORDER BY id LIMIT 3')->fetchAll();
?>
        <section class="hero" style="background-image:url('<?php echo $base; ?>assets/img/hero.svg')">
            <div class="wrap">
                <span class="badge">Nursery Kaktus &amp; Sukulen &mdash; Malang, Jawa Timur</span>
                <h1>Kaktus dan sukulen sehat, siap menemani mejamu.</h1>
                <p>Dirawat langsung di Malang, dikemas aman sampai tujuan. Pilih koleksi yang kamu suka, kami yang urus sisanya.</p>
                <div class="hero-aksi">
                    <a class="btn btn-gelap" href="<?php echo $base; ?>tanaman/list.php">Lihat Semua Koleksi</a>
                    <a class="btn btn-garis" href="<?php echo linkWa(WA_NOMOR, 'Halo, saya mau tanya koleksi tanaman.'); ?>" target="_blank" rel="noopener">Tanya via WhatsApp</a>
                </div>
                <dl class="statistik">
                    <div><dt>Jenis tanaman</dt><dd><?php echo $totalJenis; ?></dd></div>
                    <div><dt>Total stok</dt><dd><?php echo $totalStok; ?></dd></div>
                    <div><dt>Pelanggan</dt><dd><?php echo $totalPelanggan; ?></dd></div>
                </dl>
            </div>
        </section>

        <section class="seksi">
            <div class="wrap fitur">
                <article><h3>Tanaman sehat</h3><p>Setiap tanaman dicek akar dan batangnya sebelum dikemas.</p></article>
                <article><h3>Harga jelas</h3><p>Harga dan stok tampil apa adanya, tanpa biaya tersembunyi.</p></article>
                <article><h3>Kemasan aman</h3><p>Dibungkus berlapis agar duri dan pot tetap utuh sampai rumah.</p></article>
            </div>
        </section>

        <section class="seksi">
            <div class="wrap">
                <div class="seksi-kepala">
                    <div>
                        <span class="badge badge-gelap">Koleksi pilihan</span>
                        <h2>Yang paling sering dicari bulan ini</h2>
                    </div>
                    <a class="btn btn-garis-gelap" href="<?php echo $base; ?>tanaman/list.php">Lihat semua &rarr;</a>
                </div>
                <div class="grid-kartu">
                    <?php foreach ($pilihan as $no => $t): ?>
                    <article class="kartu">
                        <img src="<?php echo $base . e($t['foto']); ?>" alt="<?php echo e($t['nama']); ?>">
                        <div class="kartu-isi">
                            <span class="nomor"><?php echo str_pad($no + 1, 2, '0', STR_PAD_LEFT); ?></span>
                            <h3><?php echo e($t['nama']); ?></h3>
                            <p class="meta"><?php echo e($t['kategori']); ?> &middot; stok <?php echo (int) $t['stok']; ?></p>
                            <p><?php echo e($t['deskripsi']); ?></p>
                            <p class="harga"><?php echo rupiah($t['harga']); ?></p>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="seksi seksi-gelap">
            <div class="wrap">
                <span class="badge">Cara pesan</span>
                <h2>Tiga langkah, tanaman sampai</h2>
                <ol class="langkah">
                    <li><strong>Pilih tanaman</strong><span>Lihat koleksi, cek stok dan harga.</span></li>
                    <li><strong>Hubungi kami</strong><span>Kirim pesan lewat WhatsApp atau tautan Shopee.</span></li>
                    <li><strong>Terima di rumah</strong><span>Kami kemas dan kirim dengan aman.</span></li>
                </ol>
            </div>
        </section>
<?php include __DIR__ . '/includes/footer.php'; ?>
