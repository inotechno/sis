<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        GetWaliKelas();
        GetTahunAjaran();
        table = $('#table-kelas').DataTable({
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
                "url": "<?= base_url('kelas/all') ?>",
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

        function GetWaliKelas() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('ustadz/getAll') ?>",
                dataType: "JSON",
                success: function(data) {

                    var html = '<option value="" disabled>Pilih Wali Kelas</option>';

                    $.each(data, function(i, val) {
                        html += '<option value="' + val.id_ustadz + '">' + val.name + ' | ' + val.nik + '</option>';
                    });

                    $('.select-wali-kelas').html(html);
                }
            });
        }

        function GetTahunAjaran() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('tahun_ajaran/getAll') ?>",
                dataType: "JSON",
                success: function(data) {

                    var html = '<option value="" disabled>Pilih Tahun Ajaran</option>';

                    $.each(data, function(i, val) {
                        html += '<option value="' + val.id + '">' + val.tahun_ajaran + '</option>';
                    });

                    $('.select-tahun-ajaran').html(html);
                }
            });
        }

        $('#table-kelas').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('kelas/GetKelasById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    $('#form-update-kelas [name="id"]').val(response.id);
                    $('#form-update-kelas [name="nama_kelas"]').val(response.nama_kelas);
                    $('#form-update-kelas [name="tingkat"]').val(response.tingkat);
                    $('#form-update-kelas [name="tahun_ajaran_id"]').val(response.tahun_ajaran_id).trigger('change');
                    $('#form-update-kelas [name="wali_kelas_id"]').val(response.wali_kelas_id).trigger('change');

                    $('#modal-update-kelas').modal('show');
                    // console.log(response);
                }
            });
        });

        $('#table-kelas').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#form-delete-kelas [name="id"]').val(id);
            $('#modal-delete-kelas').modal('show');
        });

        $('#form-add-kelas').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('kelas/add') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-add-kelas').modal('hide');
                        $('#form-add-kelas')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-update-kelas').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('kelas/update') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-update-kelas').modal('hide');
                        $('#form-update-kelas')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-delete-kelas').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('kelas/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-delete-kelas').modal('hide');
                        $('#form-delete-kelas')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

    });
</script>