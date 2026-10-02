<?php
$page_title = 'Tambah Tanaman';
$aktif = 'tanaman';
include __DIR__ . '/../includes/header.php';

$flash = ambilFlash();
$lama = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>
        <section class="band">
            <div class="wrap">
                <h1>Tambah Tanaman</h1>
                <p>Isi data tanaman baru lengkap dengan foto.</p>
            </div>
        </section>

        <section class="seksi">
            <div class="wrap wrap-sempit">
                <?php if ($flash): ?>
                <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
                <?php endif; ?>

                <form id="form-tanaman" class="form" method="post" action="proses_tambah.php" enctype="multipart/form-data" novalidate>
                    <div class="field">
                        <label for="nama">Nama tanaman</label>
                        <input type="text" id="nama" name="nama" value="<?php echo e($lama['nama'] ?? ''); ?>" placeholder="Contoh: Gymnocalycium Mihanovichii">
                    </div>
                    <div class="baris-2">
                        <div class="field">
                            <label for="kategori">Kategori</label>
                            <select id="kategori" name="kategori">
                                <?php foreach (KATEGORI as $k): ?>
                                <option value="<?php echo e($k); ?>"<?php echo ($lama['kategori'] ?? '') === $k ? ' selected' : ''; ?>><?php echo e($k); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="field">
                            <label for="stok">Stok</label>
                            <input type="number" id="stok" name="stok" min="0" value="<?php echo e($lama['stok'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" min="1000" step="500" value="<?php echo e($lama['harga'] ?? ''); ?>">
                    </div>
                    <div class="field">
                        <label for="deskripsi">Deskripsi singkat</label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"><?php echo e($lama['deskripsi'] ?? ''); ?></textarea>
                    </div>
                    <div class="field">
                        <label for="shopee">Link Shopee (opsional)</label>
                        <input type="url" id="shopee" name="shopee" value="<?php echo e($lama['shopee'] ?? ''); ?>" placeholder="https://shopee.co.id/...">
                    </div>
                    <div class="field">
                        <label for="foto">Foto tanaman (opsional, JPG/PNG/WEBP maks 2 MB)</label>
                        <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp">
                        <img id="pratinjau" class="pratinjau" alt="" hidden>
                    </div>
                    <p id="pesan-error" class="flash flash-error" hidden></p>
                    <div class="form-aksi">
                        <button type="submit" class="btn btn-gelap">Simpan Tanaman</button>
                        <a class="btn btn-garis-gelap" href="list.php">Batal</a>
                    </div>
                </form>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
