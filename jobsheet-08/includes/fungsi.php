<?php
const KATEGORI = ['Kaktus', 'Sukulen', 'Lainnya'];
const WA_NOMOR = '6281234567890';
const FOTO_DEFAULT = [
    'Kaktus' => 'assets/img/mammillaria.svg',
    'Sukulen' => 'assets/img/echeveria.svg',
    'Lainnya' => 'assets/img/aloe.svg',
];

function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

function rupiah($angka)
{
    return 'Rp' . number_format((int) $angka, 0, ',', '.');
}

function setFlash($tipe, $pesan)
{
    $_SESSION['flash'] = ['type' => $tipe, 'pesan' => $pesan];
}

function ambilFlash()
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function linkWa($nomor, $pesan = '')
{
    $bersih = preg_replace('/\D/', '', $nomor);
    if (strpos($bersih, '0') === 0) {
        $bersih = '62' . substr($bersih, 1);
    }
    return 'https://wa.me/' . $bersih . ($pesan !== '' ? '?text=' . rawurlencode($pesan) : '');
}

function validasiTanaman($data)
{
    $errors = [];
    if ($data['nama'] === '') {
        $errors[] = 'Nama tanaman wajib diisi.';
    }
    if (!in_array($data['kategori'], KATEGORI, true)) {
        $errors[] = 'Kategori tidak valid.';
    }
    if (!ctype_digit($data['harga']) || (int) $data['harga'] < 1000) {
        $errors[] = 'Harga minimal Rp1.000.';
    }
    if (!ctype_digit($data['stok'])) {
        $errors[] = 'Stok harus berupa angka 0 atau lebih.';
    }
    if ($data['shopee'] !== '' && !filter_var($data['shopee'], FILTER_VALIDATE_URL)) {
        $errors[] = 'Link Shopee tidak valid.';
    }
    return $errors;
}

function validasiPelanggan($data)
{
    $errors = [];
    if ($data['nama'] === '') {
        $errors[] = 'Nama wajib diisi.';
    }
    if (!preg_match('/^(\+62|62|0)8[0-9]{8,12}$/', $data['whatsapp'])) {
        $errors[] = 'Nomor WhatsApp tidak valid.';
    }
    if ($data['kota'] === '') {
        $errors[] = 'Kota wajib diisi.';
    }
    if ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }
    return $errors;
}

function periksaFoto($berkas)
{
    if (!$berkas || $berkas['error'] === UPLOAD_ERR_NO_FILE) {
        return [null, null];
    }
    if ($berkas['error'] !== UPLOAD_ERR_OK) {
        return ['Foto gagal diunggah.', null];
    }
    if ($berkas['size'] > 2 * 1024 * 1024) {
        return ['Ukuran foto maksimal 2 MB.', null];
    }
    $tipe = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
    $info = @getimagesize($berkas['tmp_name']);
    if (!$info || !isset($tipe[$info[2]])) {
        return ['Format foto harus JPG, PNG, atau WEBP.', null];
    }
    return [null, $tipe[$info[2]]];
}

function simpanFoto($berkas, $ekstensi)
{
    $folder = __DIR__ . '/../uploads';
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
    $namaFile = uniqid('tanaman_', true) . '.' . $ekstensi;
    if (move_uploaded_file($berkas['tmp_name'], $folder . '/' . $namaFile)) {
        return 'uploads/' . $namaFile;
    }
    return null;
}

function hapusFoto($path)
{
    if (strpos($path, 'uploads/') === 0) {
        $lengkap = __DIR__ . '/../' . $path;
        if (is_file($lengkap)) {
            unlink($lengkap);
        }
    }
}
