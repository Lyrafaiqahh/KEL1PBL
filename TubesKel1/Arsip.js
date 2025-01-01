// Seleksi elemen form dan elemen input
const kompenForm = document.querySelector("form[action=''][method='POST'][enctype='multipart/form-data']");
const jumlahJamInput = kompenForm.querySelector("input[name='jumlah_jam']");
const tanggalKompenInput = kompenForm.querySelector("input[name='tanggal_kompen']");
const softfileKompenInput = kompenForm.querySelector("input[name='softfile_kompen']");
const submitKompenButton = kompenForm.querySelector("button[name='upload_kompen']");

// Flag untuk mendeteksi perubahan pada form
let isFormDirty = false;

// Event listener untuk mendeteksi perubahan pada form
if (kompenForm) {
    kompenForm.addEventListener("input", () => {
        isFormDirty = true; // Tandai bahwa form sedang diisi
    });
}

// Peringatan sebelum meninggalkan halaman jika form belum selesai diisi
window.addEventListener("beforeunload", (event) => {
    if (isFormDirty) {
        event.preventDefault();
        event.returnValue = "Perubahan Anda belum disimpan. Apakah Anda yakin ingin meninggalkan halaman ini?";
    }
});

// Event listener untuk form submit
if (kompenForm) {
    kompenForm.addEventListener("submit", function (e) {
        // Validasi input
        const jumlahJam = jumlahJamInput.value;
        const tanggalKompen = tanggalKompenInput.value;
        const softfileKompen = softfileKompenInput.files[0];

        if (!jumlahJam || jumlahJam <= 0) {
            alert("Jumlah jam kompen harus diisi dengan benar!");
            e.preventDefault();
            return;
        }

        if (!tanggalKompen) {
            alert("Tanggal penyelesaian kompen harus diisi!");
            e.preventDefault();
            return;
        }

        if (!softfileKompen) {
            alert("Softfile kompen harus diunggah!");
            e.preventDefault();
            return;
        }

        // Reset flag karena form sudah selesai diisi
        isFormDirty = false;

        // Form dikirim jika validasi lolos
    });
}

// Validasi tambahan pada input "jumlah jam"
if (jumlahJamInput) {
    jumlahJamInput.addEventListener("input", function () {
        if (jumlahJamInput.value <= 0) {
            jumlahJamInput.setCustomValidity("Jumlah jam harus lebih besar dari 0.");
        } else {
            jumlahJamInput.setCustomValidity("");
        }
    });
}

// Validasi tambahan pada input "tanggal kompen"
if (tanggalKompenInput) {
    tanggalKompenInput.addEventListener("change", function () {
        const selectedDate = new Date(tanggalKompenInput.value);
        const currentDate = new Date();
        if (selectedDate < currentDate.setHours(0, 0, 0, 0)) {
            alert("Tanggal penyelesaian harus di masa mendatang atau hari ini!");
        }
    });
}
