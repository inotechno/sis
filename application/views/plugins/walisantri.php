<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        table = $('#table-walisantri').DataTable({
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
                "url": "<?= base_url('walisantri/all') ?>",
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

        $('#table-walisantri').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('WaliSantri/GetUserById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    $('#form-update-walisantri [name="id"]').val(response.id);
                    $('#form-update-walisantri [name="name"]').val(response.name);
                    $('#form-update-walisantri [name="email"]').val(response.email);
                    $('#form-update-walisantri [name="jenis_kelamin"]').val(response.jenis_kelamin).trigger('change');
                    $('#form-update-walisantri [name="nik"]').val(response.nik);
                    $('#form-update-walisantri [name="phone"]').val(response.phone);
                    $('#form-update-walisantri [name="tempat_lahir"]').val(response.tempat_lahir);
                    $('#form-update-walisantri [name="tanggal_lahir"]').val(response.tanggal_lahir);

                    $('#modal-update-walisantri').modal('show');
                    // console.log(response);
                }
            });
        });

        $('#table-walisantri').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#form-delete-walisantri [name="id"]').val(id);
            $('#modal-delete-walisantri').modal('show');
        });

        $('#form-add-walisantri').submit(function() {
            $('.nik-mask').unmask();
            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: "<?= site_url('WaliSantri/add') ?>",
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

                        $('#modal-add-walisantri').modal('hide');
                        $('#form-add-walisantri')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-update-walisantri').submit(function() {
            $('.nik-mask').unmask();
            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: "<?= site_url('WaliSantri/update') ?>",
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

                        $('#modal-update-walisantri').modal('hide');
                        $('#form-update-walisantri')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-delete-walisantri').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('WaliSantri/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-delete-walisantri').modal('hide');
                        $('#form-delete-walisantri')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

    });
</script>