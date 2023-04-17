<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {

        GetMapel();
        GetKelas();
        GetUstadz();

        table = $('#table-jadwal').DataTable({
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
                "url": "<?= base_url('jadwal/all') ?>",
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

        $('#table-jadwal').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('jadwal/GetjadwalById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    $('#form-update-jadwal [name="id"]').val(response.id);
                    $('#form-update-jadwal [name="kelas_id"]').val(response.id_kelas).trigger('change');
                    $('#form-update-jadwal [name="mapel_id"]').val(response.id_mapel).trigger('change');
                    $('#form-update-jadwal [name="ustadz_id"]').val(response.id_ustadz).trigger('change');
                    $('#form-update-jadwal [name="hari"]').val(response.hari);
                    $('#form-update-jadwal [name="waktu_mulai"]').val(response.waktu_mulai);

                    $('#modal-update-jadwal').modal('show');
                    // console.log(response);
                }
            });
        });

        $('#table-jadwal').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#form-delete-jadwal [name="id"]').val(id);
            $('#modal-delete-jadwal').modal('show');
        });

        $('#form-add-jadwal').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('jadwal/add') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-add-jadwal').modal('hide');
                        $('#form-add-jadwal')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-update-jadwal').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('jadwal/update') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-update-jadwal').modal('hide');
                        $('#form-update-jadwal')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-delete-jadwal').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('jadwal/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-delete-jadwal').modal('hide');
                        $('#form-delete-jadwal')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

    });
</script>