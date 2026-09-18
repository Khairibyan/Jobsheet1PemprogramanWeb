document.addEventListener("DOMContentLoaded", function () {
  var tbody = document.querySelector("#tabel-penyewa tbody");
  if (tbody) {
    muatDaftarPenyewa(tbody);
  }

  if (document.getElementById("total-penyewa")) {
    muatRingkasanPenyewa();
  }
});

var URL_PENYEWA = getBasePath() + "data/penyewa.json";

async function ambilDataPenyewa() {
  var response = await fetch(URL_PENYEWA);
  if (!response.ok) {
    throw new Error("Gagal mengambil data penyewa (status " + response.status + ")");
  }
  return response.json();
}

async function muatDaftarPenyewa(tbody) {
  tampilkanLoading(true);
  try {
    var hasil = await Promise.all([ambilDataPenyewa(), tunggu(600)]);
    var data = hasil[0];

    tbody.innerHTML = "";
    data.forEach(function (penyewa) {
      tbody.appendChild(buatBarisPenyewa(penyewa));
    });

    if (data.length === 0) {
      tampilkanBarisKosong(tbody, 5, "Belum ada penyewa terdaftar.");
    }
  } catch (error) {
    tampilkanBarisError(tbody, 5, error.message);
  } finally {
    tampilkanLoading(false);
  }
}

function buatBarisPenyewa(penyewa) {
  var tr = document.createElement("tr");
  tr.innerHTML =
    "<td>" + escapeHtml(penyewa.kode) + "</td>" +
    "<td>" + escapeHtml(penyewa.nama) + "</td>" +
    "<td>" + escapeHtml(penyewa.no_hp) + "</td>" +
    "<td>" + escapeHtml(penyewa.alamat) + "</td>" +
    "<td>" +
    "<button type='button' class='btn btn-warning btn-sm text-white'>Edit</button> " +
    "<button type='button' class='btn btn-danger btn-sm btn-hapus' data-label='" +
    escapeHtml(penyewa.nama) + "'>Hapus</button>" +
    "</td>";
  return tr;
}

async function muatRingkasanPenyewa() {
  try {
    var data = await ambilDataPenyewa();
    setStat("total-penyewa", data.length);
  } catch (error) {
    console.error("Gagal memuat ringkasan penyewa:", error.message);
  }
}
