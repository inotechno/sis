<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        table = $('#table-user').DataTable({
            "processing": true,
            "serverSide": true,
            // "scrollX": true,
            // "fixedColumns": {
            // 	 "leftColumns": 1,
            // 	 "rightColumns": 1
            // },
            "responsive": true,
            "lengthChange": false,
            "order": [],
            "bInfo": false,
            "autoWidth": true,
            "ajax": {
                "url": "<?= base_url('user/all') ?>",
                "type": "POST"
            },

            "language": {
                "paginate": {
                    "previous": '<i class="ri-arrow-left-line"></i>',
                    "next": '<i class="ri-arrow-right-line"></i>'
                },
                "aria": {
                    "paginate": {
                        "previous": 'Previous',
                        "next": 'Next'
                    }
                }
            },

            "columnDefs": [{
                className: "text-center align-middle",
                targets: "_all"
            }, {
                "targets": [0],
                "orderable": false,
                "className": "text-center"
            }, ],
        });

        function reload_table() {
            table.ajax.reload();
        }

        $('#table-user').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('user/GetUserById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    $('#form-update-user [name="id"]').val(response.id);
                    $('#form-update-user [name="name"]').val(response.name);
                    $('#form-update-user [name="email"]').val(response.email);
                    $('#form-update-user [name="jenis_kelamin"]').val(response.jenis_kelamin).trigger('change');
                    $('#form-update-user [name="nik"]').val(response.nik);
                    $('#form-update-user [name="tempat_lahir"]').val(response.tempat_lahir);
                    $('#form-update-user [name="tanggal_lahir"]').val(response.tanggal_lahir);
                    $('#form-update-user [name="role_id"]').val(response.role_id);

                    $('#modal-update-user').modal('show');
                    // console.log(response);
                }
            });
        });

        $('#table-user').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#form-delete-user [name="id"]').val(id);
            $('#modal-delete-user').modal('show');
        });

        $('#form-add-user').submit(function() {
            $('.nik-mask').unmask();
            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: "<?= site_url('user/add') ?>",
                data: data,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-add-user').modal('hide');
                        $('#form-add-user')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-update-user').submit(function() {
            $('.nik-mask').unmask();
            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: "<?= site_url('user/update') ?>",
                data: data,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-update-user').modal('hide');
                        $('#form-update-user')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-delete-user').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('user/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-delete-user').modal('hide');
                        $('#form-delete-user')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#table-user').on('click', '.update-status-user', function() {
            // var id = $(this).attr('data-id');
            if (confirm('Apakah anda yakin ingin mengganti status user ?')) {
                $.ajax({
                    url: '<?= site_url('User/updateStatus') ?>',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        id: $(this).val()
                    },
                    success: function(response) {
                        if (response.type != 'success') {
                            notification(response.type, response.message);
                        } else {
                            notification(response.type, response.message);
                            reload_table();
                        }

                        // console.log(response);
                    }
                });
            }
        })
    });
</script>