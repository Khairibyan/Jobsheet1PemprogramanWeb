<?php
$page_title = 'Tambah Pelanggan';
$aktif = 'pelanggan';
include __DIR__ . '/../includes/header.php';

$flash = ambilFlash();
$lama = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>
        <section class="band">
            <div class="wrap">
                <h1>Tambah Pelanggan</h1>
                <p>Simpan kontak pembeli agar mudah dihubungi kembali.</p>
            </div>
        </section>

        <section class="seksi">
            <div class="wrap wrap-sempit">
                <?php if ($flash): ?>
                <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
                <?php endif; ?>

                <form id="form-pelanggan" class="form" method="post" action="proses_tambah.php" novalidate>
                    <div class="field">
                        <label for="nama">Nama lengkap</label>
                        <input type="text" id="nama" name="nama" value="<?php echo e($lama['nama'] ?? ''); ?>">
                    </div>
                    <div class="baris-2">
                        <div class="field">
                            <label for="whatsapp">Nomor WhatsApp</label>
                            <input type="tel" id="whatsapp" name="whatsapp" value="<?php echo e($lama['whatsapp'] ?? ''); ?>" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="field">
                            <label for="kota">Kota</label>
                            <input type="text" id="kota" name="kota" value="<?php echo e($lama['kota'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label for="email">Email (opsional)</label>
                        <input type="email" id="email" name="email" value="<?php echo e($lama['email'] ?? ''); ?>">
                    </div>
                    <p id="pesan-error" class="flash flash-error" hidden></p>
                    <div class="form-aksi">
                        <button type="submit" class="btn btn-gelap">Simpan Pelanggan</button>
                        <a class="btn btn-garis-gelap" href="list.php">Batal</a>
                    </div>
                </form>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
