document.addEventListener('DOMContentLoaded', function () {
    var tombolMenu = document.getElementById('nav-toggle-btn');
    var menu = document.getElementById('menu-utama');
    if (tombolMenu && menu) {
        tombolMenu.addEventListener('click', function () {
            menu.classList.toggle('terbuka');
        });
    }

    var cari = document.getElementById('cari');
    var filter = document.getElementById('filter-kategori');
    var jumlah = document.getElementById('jumlah-tampil');
    var barisKosong = document.getElementById('baris-kosong');
    var baris = document.querySelectorAll('tbody tr[data-cari]');

    function terapkanFilter() {
        var kata = cari ? cari.value.trim().toLowerCase() : '';
        var kategori = filter ? filter.value : '';
        var tampil = 0;
        baris.forEach(function (tr) {
            var cocokKata = tr.dataset.cari.indexOf(kata) !== -1;
            var cocokKategori = !kategori || tr.dataset.kategori === kategori;
            var terlihat = cocokKata && cocokKategori;
            tr.hidden = !terlihat;
            if (terlihat) {
                tampil++;
            }
        });
        if (jumlah) {
            jumlah.textContent = tampil;
        }
        if (barisKosong && baris.length > 0) {
            barisKosong.hidden = tampil > 0;
        }
    }

    if (cari) {
        cari.addEventListener('input', terapkanFilter);
    }
    if (filter) {
        filter.addEventListener('change', terapkanFilter);
    }

    document.querySelectorAll('.form-hapus').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!confirm('Hapus "' + form.dataset.nama + '"?')) {
                event.preventDefault();
            }
        });
    });

    var foto = document.getElementById('foto');
    var pratinjau = document.getElementById('pratinjau');
    if (foto && pratinjau) {
        foto.addEventListener('change', function () {
            var berkas = foto.files[0];
            if (!berkas) {
                pratinjau.hidden = true;
                return;
            }
            pratinjau.src = URL.createObjectURL(berkas);
            pratinjau.hidden = false;
        });
    }

    var aturan = {
        'form-tanaman': function (f) {
            var pesan = [];
            if (f.nama.value.trim() === '') {
                pesan.push('Nama tanaman wajib diisi.');
            }
            if (f.harga.value === '' || Number(f.harga.value) < 1000) {
                pesan.push('Harga minimal Rp1.000.');
            }
            if (f.stok.value === '' || Number(f.stok.value) < 0) {
                pesan.push('Stok tidak boleh kosong atau negatif.');
            }
            if (f.foto.files[0] && f.foto.files[0].size > 2 * 1024 * 1024) {
                pesan.push('Ukuran foto maksimal 2 MB.');
            }
            return pesan;
        },
        'form-pelanggan': function (f) {
            var pesan = [];
            if (f.nama.value.trim() === '') {
                pesan.push('Nama wajib diisi.');
            }
            if (!/^(\+62|62|0)8[0-9]{8,12}$/.test(f.whatsapp.value.trim())) {
                pesan.push('Nomor WhatsApp tidak valid.');
            }
            if (f.kota.value.trim() === '') {
                pesan.push('Kota wajib diisi.');
            }
            return pesan;
        }
    };

    Object.keys(aturan).forEach(function (id) {
        var form = document.getElementById(id);
        var kotak = document.getElementById('pesan-error');
        if (!form || !kotak) {
            return;
        }
        form.addEventListener('submit', function (event) {
            var pesan = aturan[id](form);
            if (pesan.length > 0) {
                event.preventDefault();
                kotak.textContent = pesan.join(' ');
                kotak.hidden = false;
                kotak.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
});
