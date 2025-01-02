<?php
// Include koneksi database
include "connection.php"; // Pastikan connection.php sudah benar
global $conn;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-light text-dark">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">FAQ</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_form">
                Tambah Pertanyaan
            </button>
        </div>

        <!-- Kontainer FAQ -->
        <div id="faq-container">
            <!-- Pertanyaan dan jawaban akan dimuat di sini -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script custom -->
    <script>
        // Load FAQ data menggunakan fetch dari script.php
        fetch('pages/faq/script.php')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('faq-container');
                data.forEach(item => {
                    const faqItem = document.createElement('div');
                    faqItem.classList.add('border', 'rounded', 'p-3', 'mb-3');

                    faqItem.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center cursor-pointer toggle">
                            <h3 class="h5 fw-bold mb-0">${item.pertanyaan}</h3>
                            <i class="fas fa-plus"></i>
                        </div>
                        <p class="mt-2 d-none">${item.jawaban}</p>
                    `;

                    container.appendChild(faqItem);

                    // Tambahkan event listener untuk toggle jawaban
                    faqItem.querySelector('.toggle').addEventListener('click', function() {
                        const answer = faqItem.querySelector('p');
                        answer.classList.toggle('d-none');
                        const icon = this.querySelector('i');
                        icon.classList.toggle('fa-plus');
                        icon.classList.toggle('fa-minus');
                    });
                });
            })
            .catch(error => {
                console.error('Error fetching FAQ data:', error);
                const container = document.getElementById('faq-container');
                container.innerHTML = '<p class="text-muted">Tidak ada FAQ.</p>';
            });


        // Fungsi untuk menyimpan pertanyaan dan jawaban baru
        function save() {
            const pertanyaan = document.getElementById('pertanyaan').value;
            const jawaban = document.getElementById('jawaban').value;
            const id = document.getElementById('id').value;

            // Validasi input
            if (!pertanyaan || !jawaban) {
                alert("Pertanyaan dan jawaban tidak boleh kosong.");
                return;
            }

            const method = id ? 'PUT' : 'POST';
            const url = id ? `pages/faq/script.php?id=${id}` : 'pages/faq/script.php';

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        pertanyaan,
                        jawaban,
                        id
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal menyimpan data.');
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    location.reload(); // Reload halaman untuk memuat FAQ terbaru
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data.');
                });
        }
    </script>
</body>

</html>
<?php include "form.php"; ?>