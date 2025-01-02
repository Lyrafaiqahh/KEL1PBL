<?php include "connection.php";
global $conn;



?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container">

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Selamat datang, Admin!</h1>
        </div>

        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm d-flex align-items-center p-3">
                    <div class="bg-danger text-white rounded-circle p-3 d-flex align-items-center justify-content-center">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <div class="ms-3">
                        <h2 class="h5 mb-1 count-mahasiswa">1 Mahasiswa</h2>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm d-flex align-items-center p-3">
                    <div class="bg-success text-white rounded-circle p-3 d-flex align-items-center justify-content-center">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </div>
                    <div class="ms-3">
                        <h2 class="h5 mb-1">8 Dokumen</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(() => {

        getCount();
    });

    getCount = () => {
        $.ajax({
            url: "system/dashboard.php",
            method: "POST",
            data: {
                action: "getCount"
            },
            success: (data) => {
                data = JSON.parse(data);
                $(".count-mahasiswa").text(data.countMahasiswa + " Mahasiswa");
            }
        });
    }
</script>