document.addEventListener("DOMContentLoaded", function () {
  var tbody = document.querySelector("#tabel-unit-ps tbody");
  if (tbody) {
    muatDaftarUnitPs(tbody);
  }

  if (document.getElementById("total-ps4")) {
    muatRingkasanUnitPs();
  }
});

var URL_UNIT_PS = getBasePath() + "data/unit-ps.json";

async function ambilDataUnitPs() {
  var response = await fetch(URL_UNIT_PS);
  if (!response.ok) {
    throw new Error("Gagal mengambil data unit PS (status " + response.status + ")");
  }
  return response.json();
}

async function muatDaftarUnitPs(tbody) {
  tampilkanLoading(true);
  try {
    var hasil = await Promise.all([ambilDataUnitPs(), tunggu(600)]);
    var data = hasil[0];

    tbody.innerHTML = "";
    data.forEach(function (unit) {
      tbody.appendChild(buatBarisUnitPs(unit));
    });

    if (data.length === 0) {
      tampilkanBarisKosong(tbody, 6, "Belum ada unit PS terdaftar.");
    }
  } catch (error) {
    tampilkanBarisError(tbody, 6, error.message);
  } finally {
    tampilkanLoading(false);
  }
}

function buatBarisUnitPs(unit) {
  var tr = document.createElement("tr");

  var badgeClass = {
    Tersedia: "badge-tersedia",
    Disewa: "badge-disewa",
    Maintenance: "badge-maintenance",
  }[unit.status] || "bg-secondary";

  tr.innerHTML =
    "<td>" + escapeHtml(unit.kode_unit) + "</td>" +
    "<td>" + escapeHtml(unit.jenis_konsol) + "</td>" +
    "<td>" + unit.jumlah_stik + "</td>" +
    "<td>Rp" + Number(unit.harga_per_jam).toLocaleString("id-ID") + "</td>" +
    "<td><span class='badge " + badgeClass + "'>" + escapeHtml(unit.status) + "</span></td>" +
    "<td>" +
    "<button type='button' class='btn btn-warning btn-sm text-white'>Edit</button> " +
    "<button type='button' class='btn btn-danger btn-sm btn-hapus' data-label='" +
    escapeHtml(unit.kode_unit) + "'>Hapus</button>" +
    "</td>";

  return tr;
}

async function muatRingkasanUnitPs() {
  try {
    var data = await ambilDataUnitPs();
    setStat("total-ps4", data.filter(function (u) { return u.jenis_konsol === "PS4"; }).length);
    setStat("total-ps5", data.filter(function (u) { return u.jenis_konsol === "PS5"; }).length);
    setStat("unit-tersedia", data.filter(function (u) { return u.status === "Tersedia"; }).length);
  } catch (error) {
    console.error("Gagal memuat ringkasan unit PS:", error.message);
  }
}
