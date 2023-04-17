<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {

        table = $('#table-mapel').DataTable({
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
                "url": "<?= base_url('mapel/all') ?>",
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

        $('#table-mapel').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('mapel/GetmapelById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    $('#form-update-mapel [name="id"]').val(response.id);
                    $('#form-update-mapel [name="nama_mapel"]').val(response.nama_mapel);
                    $('#form-update-mapel [name="nilai_kkm"]').val(response.nilai_kkm);
                    $('#form-update-mapel [name="tingkat"]').val(response.tingkat);

                    $('#modal-update-mapel').modal('show');
                    // console.log(response);
                }
            });
        });

        $('#table-mapel').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#form-delete-mapel [name="id"]').val(id);
            $('#modal-delete-mapel').modal('show');
        });

        $('#form-add-mapel').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('mapel/add') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-add-mapel').modal('hide');
                        $('#form-add-mapel')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-update-mapel').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('mapel/update') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-update-mapel').modal('hide');
                        $('#form-update-mapel')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-delete-mapel').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('mapel/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-delete-mapel').modal('hide');
                        $('#form-delete-mapel')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

    });
</script>