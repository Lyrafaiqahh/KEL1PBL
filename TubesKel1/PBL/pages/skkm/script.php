<script>
    $(() => {
        if ($('#table').length) { // Check if the table exists in the DOM
        index();
    } else {
        console.error('Table element not found!');
    }
    });

    index = () => {
        if ($.fn.DataTable.isDataTable('#table')) {
            $('#table').DataTable().clear().destroy();
        }

        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,

            lengthMenu: [5, 10, 25, 50, 100],
            language: {
                lengthMenu: "Show _MENU_ items per page"
            },
            ajax: {
                url: 'system/skkm.php',
                
                type: 'POST',
                data: function(d) {
                    d.action = 'index';
                }, error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
            },
            columnDefs: [{
                    targets: 0,
                    data: 'nim',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        console.log(data);
                        return meta.row + 1;
                    }
                },
                {
                    targets: 1,
                    data: 'nim',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 2,
                    data: 'nama',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },

                {
                    targets: 3,
                    data: 'nama_jurusan',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 4,
                    data: 'file_sertifikat',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 5,
                    data: 'status',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {

                        let html = ``;
                        if (row.status == 1) {

                            html += `
                                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip"  title="Disetujui">
                                    <i class="fa fa-check" ></i>
                                </button>
                            `;
                        } else if(row.status == 2) {
                            html += `
                                 <button class="btn btn-danger btn-sm " type="button" title="Ditolak">
                                    <i class="fa fa-times" ></i>
                                </button>
                            `;
                        
                        } 

                        return html;
                    }
                },
                {
                    targets: 6,
                    data: 'no_sertifikat',
                    searchable: true,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        var html = `
                            <div class="dropleft">
                                <button class="btn btn-light btn-sm" type="button" id="dropdownMenuButton-${data}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-${data}">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="verifikasi(${data},1)"><i class="fa fa-check"></i> Verifikasi</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"  onclick="verifikasi(${data},2)" data-id="${data}"><i class="fa fa-times"></i> Tolak</a>
                                    </li>
                                </ul>
                            </div>
                        `;
                        return html;
                    }
                }
            ],
        });
    };

    verifikasi = (id, status) => {
        $.ajax({
            url: '/PBL/system/skkm.php',
            data: {
                action: 'verifikasi',
                id: id,
                status: status
            },
            type: 'POST',
            success: (data) => {
                if (data == 1) {
                    index();
                } 
                index();

            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
            }
        });
    }
</script>