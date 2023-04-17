<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        GetWaliSantri();

        table = $('#table-santri').DataTable({
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
                "url": "<?= base_url('santri-ws/all') ?>",
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

        function GetWaliSantri() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('walisantri/getAll') ?>",
                dataType: "JSON",
                success: function(data) {

                    var html = '<option value="">Pilih Wali</option>';

                    $.each(data, function(i, val) {
                        html += '<option value="' + val.id_wali_santri + '">' + val.name + ' | ' + val.nik + '</option>';
                    });

                    $('.select-wali-santri').html(html);
                }
            });
        }

        $('#table-santri').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('Santri/GetUserById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    $('#form-update-santri [name="id"]').val(response.id);
                    $('#form-update-santri [name="name"]').val(response.name);
                    $('#form-update-santri [name="email"]').val(response.email);
                    $('#form-update-santri [name="jenis_kelamin"]').val(response.jenis_kelamin).trigger('change');
                    $('#form-update-santri [name="nis"]').val(response.nis);
                    $('#form-update-santri [name="tempat_lahir"]').val(response.tempat_lahir);
                    $('#form-update-santri [name="tanggal_lahir"]').val(response.tanggal_lahir);

                    $('#modal-update-santri').modal('show');
                    // console.log(response);
                }
            });
        });

        $('#table-santri').on('click', '.btn-add-tag', function() {
            var id = $(this).attr('data-id');

            $('#form-add-tag [name="id"]').val(id);
            $('#modal-add-tag').modal('show');
            $('#modal-add-tag').on('shown.bs.modal', function() {
                setInterval(() => {
                    if ($('[name="tag_id"]').val() == '') {
                        GetTag();
                    } else {
                        $('#form-add-tag').submit();
                    }
                }, 2000);
            });

        });

        function GetTag() {
            var tag_input = $('[name="tag_id"]');

            $.ajax({
                type: "GET",
                url: "<?= site_url('Santri/GetTagLastTime') ?>",
                dataType: "JSON",
                success: function(data) {
                    if (data) {
                        tag_input.val(data.tag_id);
                    }
                }
            });

        }

        $('#form-add-tag').submit(function() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('Santri/addTag') ?>",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                        location.reload();
                    } else {
                        notification(response.type, response.message);
                        $('#modal-add-tag').modal('hide');
                        $('#form-add-tag')[0].reset();

                        location.reload();
                    }
                }
            });

            return false;
        });

        $('#table-santri').on('click', '.btn-wali-santri', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('Santri/GetUserById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    $('#form-update-wali-santri [name="id"]').val(response.id);
                    $('#form-update-wali-santri [name="wali_id"]').val(response.wali_id).trigger('change');

                    $('#modal-update-wali-santri').modal('show');
                    // console.log(response);
                }
            });
        });

        $('#table-santri').on('click', '.btn-add-balance', function() {
            var id = $(this).attr('data-id');
            $('#form-add-balance [name="id"]').val(id);

            $('#modal-add-balance').modal('show');
            // $('#form-add-balance [name="saldo"]').simpleMoneyFormat();
        });

        $('#table-santri').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#form-delete-santri [name="id"]').val(id);
            $('#modal-delete-santri').modal('show');
        });

        $('#form-add-santri').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('santri/add') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-add-santri').modal('hide');
                        $('#form-add-santri')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-update-santri').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('santri/update') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-update-santri').modal('hide');
                        $('#form-update-santri')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-update-wali-santri').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('santri/update_walisantri') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-update-wali-santri').modal('hide');
                        $('#form-update-wali-santri')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-delete-santri').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('santri/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-delete-santri').modal('hide');
                        $('#form-delete-santri')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-add-balance').submit(function() {
            $('.money2-mask').unmask();
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?= site_url('santri/addBalance') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-add-balance').modal('hide');
                        $('#form-add-balance')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });
    });
</script>