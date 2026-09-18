document.addEventListener("DOMContentLoaded", function () {
  var tbody = document.querySelector("#tabel-mobil tbody");
  if (tbody) {
    muatDaftarMobil(tbody);
  }

  if (document.getElementById("total-mobil")) {
    muatRingkasanMobil();
  }
});

var URL_MOBIL = getBasePath() + "data/mobil.json";

async function ambilDataMobil() {
  var response = await fetch(URL_MOBIL);
  if (!response.ok) {
    throw new Error("Gagal mengambil data mobil (status " + response.status + ")");
  }
  return response.json();
}

async function muatDaftarMobil(tbody) {
  tampilkanLoading(true);
  try {
    var hasil = await Promise.all([ambilDataMobil(), tunggu(600)]);
    var data = hasil[0];

    tbody.innerHTML = "";
    data.forEach(function (mobil) {
      tbody.appendChild(buatBarisMobil(mobil));
    });

    if (data.length === 0) {
      tampilkanBarisKosong(tbody, 6, "Belum ada mobil terdaftar.");
    }
  } catch (error) {
    tampilkanBarisError(tbody, 6, error.message);
  } finally {
    tampilkanLoading(false);
  }
}

function buatBarisMobil(mobil) {
  var tr = document.createElement("tr");

  var badgeClass = {
    Tersedia: "badge-tersedia",
    Disewa: "badge-disewa",
    Maintenance: "badge-maintenance",
  }[mobil.status] || "bg-secondary";

  tr.innerHTML =
    "<td>" + escapeHtml(mobil.kode_mobil) + "</td>" +
    "<td>" + escapeHtml(mobil.merek_model) + "</td>" +
    "<td>" + mobil.kapasitas + " kursi</td>" +
    "<td>Rp" + Number(mobil.harga_per_hari).toLocaleString("id-ID") + "</td>" +
    "<td><span class='badge " + badgeClass + "'>" + escapeHtml(mobil.status) + "</span></td>" +
    "<td>" +
    "<button type='button' class='btn btn-warning btn-sm text-white'>Edit</button> " +
    "<button type='button' class='btn btn-danger btn-sm btn-hapus' data-label='" +
    escapeHtml(mobil.kode_mobil) + "'>Hapus</button>" +
    "</td>";

  return tr;
}

async function muatRingkasanMobil() {
  try {
    var data = await ambilDataMobil();
    setStat("total-mobil", data.length);
    setStat("mobil-tersedia", data.filter(function (m) { return m.status === "Tersedia"; }).length);
    setStat("mobil-disewa", data.filter(function (m) { return m.status === "Disewa"; }).length);
  } catch (error) {
    console.error("Gagal memuat ringkasan mobil:", error.message);
  }
}
