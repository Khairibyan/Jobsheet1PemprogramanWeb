# Jobsheet 5 — JavaScript DOM & Event (RentalPS-Mini)

Sub-CPMK: Menerapkan manipulasi DOM & event JavaScript.

## Konsep proyek
Mulai jobsheet ini, konsep proyek diubah dari "sistem perpustakaan" menjadi
**RentalPS-Mini**, aplikasi sederhana untuk mengelola:
- **Unit PS** — data unit PS4/PS5 yang disewakan (kode unit, jenis konsol,
  jumlah stik, harga per jam, status).
- **Penyewa** — data pelanggan yang menyewa unit.

Perubahan konsep ini murni pilihan pribadi (dosen membebaskan modifikasi),
supaya tidak identik dengan proyek teman satu kelas yang lain.

## Perubahan dari Jobsheet 4
- Tambah `assets/js/app.js`.
- **Navbar mobile**: setelah tombol hamburger Bootstrap dibuka lalu salah satu
  link diklik, menu otomatis tertutup lagi (`initNavbarAutoClose`) — bukan
  cuma mengandalkan perilaku bawaan Bootstrap.
- **Validasi form** (`initFormValidation`) pada Tambah Unit PS & Tambah
  Penyewa: field wajib, rentang angka (jumlah stik, harga), format No. HP.
  Pesan error disisipkan lewat `insertAdjacentElement` dan hilang otomatis
  saat user mengetik ulang.
- **Filter tabel real-time** (`initTableFilter`) pada Daftar Unit PS &
  Daftar Penyewa, termasuk baris "Data tidak ditemukan" saat hasil kosong.
- **Tombol Hapus** (`.btn-hapus`): pakai `confirm()` bawaan browser, lalu
  baris dihapus dari tampilan (front-end saja, belum ke server). Listener
  sudah pakai *event delegation* dari awal supaya siap dipakai lagi di
  Jobsheet 6 saat baris dirender otomatis lewat `fetch`.

## Cara menjalankan
Buka `index.html` di browser. Coba:
- Ketik di kolom cari pada tabel Unit PS / Penyewa → tabel tersaring.
- Klik "Simpan" di form Tambah tanpa mengisi apa pun → muncul pesan error.
- Klik "Hapus" pada salah satu baris → muncul konfirmasi, baris hilang jika disetujui.
- Perkecil lebar browser, buka menu hamburger, klik salah satu link → menu otomatis tertutup.

## Catatan
- Validasi di sini murni client-side dan bisa dilewati (nonaktifkan JS).
  Validasi server-side ditambahkan di Jobsheet 7 sebagai lapisan kedua yang wajib.
- Hapus baris di jobsheet ini hanya menghilangkan dari tampilan (belum
  persisten) — akan diganti proses hapus sungguhan ke database mulai Jobsheet 9.
- Data unit PS & penyewa masih ditulis manual di HTML; mulai Jobsheet 6
  data dipindah ke file JSON dan dirender dinamis lewat `fetch`.
