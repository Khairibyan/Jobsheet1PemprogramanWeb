# Jobsheet 6 — Fetch API & JSON (RentalPS-Mini)

Sub-CPMK: Menerapkan komunikasi asinkron (AJAX/fetch, JSON).

## Perubahan dari Jobsheet 5
- Tambah `data/unit-ps.json` (8 objek) dan `data/penyewa.json` (5 objek)
  sebagai pengganti sementara API sungguhan.
- `unit-ps/list.html` & `penyewa/list.html`: `<tbody>` dikosongkan, baris
  kini dirender dinamis oleh `assets/js/unit-ps.js` / `assets/js/penyewa.js`
  memakai `fetch` + `async/await`.
- Loading indicator (`#loading-indicator`, spinner Bootstrap) tampil selama
  proses fetch (disimulasikan dengan delay 600ms lewat `Promise.all`).
- Penanganan error (`try/catch`): kalau fetch gagal, pesan error tampil
  di dalam tabel, bukan cuma di console.
- `index.html`: kartu ringkasan (Unit PS4, Unit PS5, Unit Tersedia, Total
  Penyewa) sekarang dihitung otomatis dari hasil fetch — sebelumnya di
  Jobsheet 5 masih angka manual.
- `app.js`: util yang dipakai bersama oleh `unit-ps.js` & `penyewa.js`
  (loading indicator, baris kosong/error, escape HTML) dipindah ke satu
  tempat supaya tidak duplikasi kode. `initDeleteConfirm` di Jobsheet 5
  sudah memakai *event delegation* sejak awal, jadi tombol Hapus pada baris
  yang baru dibuat lewat `fetch` tetap berfungsi tanpa perubahan apa pun.

## Cara menjalankan
**Penting:** `fetch()` ke file lokal akan diblokir kebijakan CORS jika dibuka
langsung dengan `file://`. Jalankan lewat server lokal, misalnya:
```bash
php -S localhost:8000
```
lalu buka `http://localhost:8000/index.html`. Bisa juga memakai ekstensi
"Live Server" di VS Code.

## Cara mendemokan ke dosen
- Buka `unit-ps/list.html` / `penyewa/list.html` → tabel sempat kosong
  sebentar (spinner "Memuat data...") lalu terisi otomatis.
- Uji error handling: ganti sementara nama file di `fetch(...)` pada
  `unit-ps.js` menjadi nama yang salah → pesan error merah muncul di tabel.
- Kolom cari & tombol Hapus (dari Jobsheet 5) tetap berfungsi di baris yang
  baru dirender ini, membuktikan event delegation bekerja.

## Catatan
- Tombol Hapus & form Tambah masih front-end saja (menghapus/menambah
  tampilan sementara), karena data sesungguhnya berasal dari file JSON
  statis, bukan database — proses simpan/hapus sungguhan menyusul mulai
  Jobsheet 9 setelah back-end PostgreSQL siap.
- Pola `fetch` + `async/await` di sini akan dipakai ulang untuk memanggil
  endpoint PHP sungguhan mulai Jobsheet 9, meskipun mulai Jobsheet 7
  rendering utama berpindah ke server-side PHP.
