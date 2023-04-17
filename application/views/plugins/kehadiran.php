<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {

        GetMapel();
        GetKelas();
        GetUstadz();

        table = $('#table-kehadiran').DataTable({
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
                "url": "<?= base_url('kehadiran/all') ?>",
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

        function GetMapel() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('mapel/getAll') ?>",
                dataType: "JSON",
                success: function(data) {

                    var html = '<option value="" disabled>Pilih Mapel</option>';

                    $.each(data, function(i, val) {
                        html += '<option value="' + val.id + '">' + val.nama_mapel + ' | ' + val.tingkat + '</option>';
                    });

                    $('.select-mapel').html(html);
                }
            });
        }

        function GetUstadz() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('ustadz/getAll') ?>",
                dataType: "JSON",
                success: function(data) {

                    var html = '<option value="" disabled>Pilih Ustadz</option>';

                    $.each(data, function(i, val) {
                        html += '<option value="' + val.id_ustadz + '">' + val.name + '</option>';
                    });

                    $('.select-ustadz').html(html);
                }
            });
        }

        function GetKelas() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('kelas/getAll') ?>",
                dataType: "JSON",
                success: function(data) {

                    var html = '<option value="" disabled>Pilih Kelas</option>';

                    $.each(data, function(i, val) {
                        html += '<option value="' + val.id + '">' + val.nama_kelas + '</option>';
                    });

                    $('.select-kelas').html(html);
                }
            });
        }

        $('#table-kehadiran').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('kehadiran/GetkehadiranById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    $('#form-update-kehadiran [name="id"]').val(response.id);
                    $('#form-update-kehadiran [name="kelas_id"]').val(response.id_kelas).trigger('change');
                    $('#form-update-kehadiran [name="mapel_id"]').val(response.id_mapel).trigger('change');
                    $('#form-update-kehadiran [name="ustadz_id"]').val(response.id_ustadz).trigger('change');
                    $('#form-update-kehadiran [name="hari"]').val(response.hari);
                    $('#form-update-kehadiran [name="waktu_mulai"]').val(response.waktu_mulai);

                    $('#modal-update-kehadiran').modal('show');
                    // console.log(response);
                }
            });
        });

        $('#table-kehadiran').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#form-delete-kehadiran [name="id"]').val(id);
            $('#modal-delete-kehadiran').modal('show');
        });

        $('#form-add-kehadiran').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('kehadiran/add') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-add-kehadiran').modal('hide');
                        $('#form-add-kehadiran')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-update-kehadiran').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('kehadiran/update') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-update-kehadiran').modal('hide');
                        $('#form-update-kehadiran')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-delete-kehadiran').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('kehadiran/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-delete-kehadiran').modal('hide');
                        $('#form-delete-kehadiran')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

    });
</script>