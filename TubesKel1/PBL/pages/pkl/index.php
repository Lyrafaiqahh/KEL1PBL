<?php include "connection.php";
global $conn;



?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container">

    <!-- Main Content -->
    <div class="main-content">
        <div class="card mt-5">
            <div class="card-body">

                <table id="table" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Berkas PKL</th>
                            <th>Berkas Nilai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "script.php"; ?>