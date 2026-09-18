/**
  - initNavbarAutoClose : menu navbar mobile otomatis tertutup setelah
    salah satu link diklik (di contoh dasar dosen navbar dibiarkan terbuka).
  - initTableFilter     : pencarian real-time pada tabel Daftar Unit PS /
    Daftar Penyewa, plus baris "data tidak ditemukan" kalau hasil kosong.
  - initDeleteConfirm   : tombol Hapus pakai confirm() bawaan browser,
    lalu baris dihapus dari tampilan (masih front-end saja, belum ke server).
    Sudah pakai event delegation dari awal supaya di Jobsheet 6 nanti
    (saat baris dirender otomatis lewat fetch) tombolnya tetap berfungsi
    tanpa perlu diubah lagi.
  - initFormValidation  : validasi client-side untuk form Tambah Unit PS
    dan Tambah Penyewa, pesan error disisipkan lewat insertAdjacentElement.
*/

document.addEventListener("DOMContentLoaded", function () {
  initNavbarAutoClose();
  initTableFilter("#filter-unit-ps", "#tabel-unit-ps tbody");
  initTableFilter("#filter-penyewa", "#tabel-penyewa tbody");
  initDeleteConfirm();
  initFormValidation("#form-unit-ps", unitPsValidationRules);
  initFormValidation("#form-penyewa", penyewaValidationRules);
});

function getBasePath() {
  return location.pathname.indexOf("/unit-ps/") !== -1 ||
    location.pathname.indexOf("/penyewa/") !== -1
    ? "../"
    : "";
}

function tunggu(ms) {
  return new Promise(function (resolve) {
    setTimeout(resolve, ms);
  });
}

function tampilkanLoading(tampil) {
  var el = document.getElementById("loading-indicator");
  if (!el) return;
  el.classList.toggle("show", tampil);
}

function tampilkanBarisKosong(tbody, kolom, pesan) {
  tbody.innerHTML =
    "<tr class='table-empty-row'><td colspan='" + kolom + "'>" + pesan + "</td></tr>";
}

function tampilkanBarisError(tbody, kolom, pesan) {
  tbody.innerHTML =
    "<tr><td colspan='" + kolom + "'>" +
    "<div class='alert alert-danger alert-fetch-error mb-0'>" +
    "Gagal memuat data: " + escapeHtml(pesan) +
    "</div></td></tr>";
}

function setStat(id, nilai) {
  var el = document.getElementById(id);
  if (el) el.textContent = nilai;
}

function escapeHtml(teks) {
  var div = document.createElement("div");
  div.textContent = teks == null ? "" : String(teks);
  return div.innerHTML;
}

function initNavbarAutoClose() {
  var navMenu = document.getElementById("navMenu");
  if (!navMenu) return;

  var links = navMenu.querySelectorAll(".nav-link");
  links.forEach(function (link) {
    link.addEventListener("click", function () {
      if (navMenu.classList.contains("show")) {
        var bsCollapse = bootstrap.Collapse.getOrCreateInstance(navMenu);
        bsCollapse.hide();
      }
    });
  });
}

function initTableFilter(inputSelector, tbodySelector) {
  var input = document.querySelector(inputSelector);
  var tbody = document.querySelector(tbodySelector);
  if (!input || !tbody) return;

  input.addEventListener("keyup", function () {
    var keyword = input.value.trim().toLowerCase();
    var rows = tbody.querySelectorAll("tr:not(.table-empty-row)");
    var jumlahTampil = 0;

    rows.forEach(function (row) {
      var teksBaris = row.textContent.toLowerCase();
      var cocok = teksBaris.indexOf(keyword) !== -1;
      row.classList.toggle("d-none-filter", !cocok);
      if (cocok) jumlahTampil++;
    });

    toggleEmptyRow(tbody, jumlahTampil === 0);
  });
}

function toggleEmptyRow(tbody, tampilkan) {
  var emptyRow = tbody.querySelector(".table-empty-row");
  if (tampilkan) {
    if (!emptyRow) {
      var kolom = tbody.closest("table").querySelectorAll("thead th").length;
      emptyRow = document.createElement("tr");
      emptyRow.className = "table-empty-row";
      emptyRow.innerHTML =
        '<td colspan="' + kolom + '">Data tidak ditemukan.</td>';
      tbody.appendChild(emptyRow);
    }
  } else if (emptyRow) {
    emptyRow.remove();
  }
}

function initDeleteConfirm() {
  document.addEventListener("click", function (e) {
    var tombol = e.target.closest(".btn-hapus");
    if (!tombol) return;

    var baris = tombol.closest("tr");
    var label = tombol.getAttribute("data-label") || "data ini";

    var yakin = confirm('Yakin ingin menghapus "' + label + '"?');
    if (yakin && baris) {
      var tbody = baris.parentElement;
      baris.remove();
      var sisaBaris = tbody.querySelectorAll("tr:not(.table-empty-row)").length;
      toggleEmptyRow(tbody, sisaBaris === 0);
    }
  });
}

var unitPsValidationRules = {
  kode_unit: { required: true, label: "Kode Unit" },
  jenis_konsol: { required: true, label: "Jenis Konsol" },
  jumlah_stik: { required: true, min: 1, max: 4, label: "Jumlah Stik" },
  harga_per_jam: { required: true, min: 1000, label: "Harga per Jam" },
  status: { required: true, label: "Status" },
};

var penyewaValidationRules = {
  nama: { required: true, minLength: 3, label: "Nama" },
  no_hp: { required: true, pattern: /^[0-9]{10,13}$/, label: "No. HP" },
  alamat: { required: true, label: "Alamat" },
};

function initFormValidation(formSelector, rules) {
  var form = document.querySelector(formSelector);
  if (!form) return;

  form.addEventListener("submit", function (e) {
    var valid = true;

    Object.keys(rules).forEach(function (nama) {
      var field = form.querySelector('[name="' + nama + '"]');
      if (!field) return;
      var pesan = validasiField(field, rules[nama]);
      tampilkanPesanError(field, pesan);
      if (pesan) valid = false;
    });

    if (!valid) {
      e.preventDefault();
    }
  });

  Object.keys(rules).forEach(function (nama) {
    var field = form.querySelector('[name="' + nama + '"]');
    if (!field) return;
    field.addEventListener("input", function () {
      tampilkanPesanError(field, null);
    });
  });
}

function validasiField(field, rule) {
  var nilai = field.value.trim();

  if (rule.required && nilai === "") {
    return rule.label + " wajib diisi.";
  }
  if (rule.minLength && nilai.length < rule.minLength) {
    return rule.label + " minimal " + rule.minLength + " karakter.";
  }
  if (rule.pattern && nilai !== "" && !rule.pattern.test(nilai)) {
    return rule.label + " tidak valid (contoh: 08123456789).";
  }
  if (rule.min !== undefined && nilai !== "" && Number(nilai) < rule.min) {
    return rule.label + " minimal " + rule.min + ".";
  }
  if (rule.max !== undefined && nilai !== "" && Number(nilai) > rule.max) {
    return rule.label + " maksimal " + rule.max + ".";
  }
  return null;
}

function tampilkanPesanError(field, pesan) {
  var existing = field.parentElement.querySelector(".invalid-feedback");

  if (!pesan) {
    field.classList.remove("is-invalid");
    if (existing) existing.remove();
    return;
  }

  field.classList.add("is-invalid");
  if (existing) {
    existing.textContent = pesan;
  } else {
    var div = document.createElement("div");
    div.className = "invalid-feedback";
    div.textContent = pesan;
    field.insertAdjacentElement("afterend", div);
  }
}
