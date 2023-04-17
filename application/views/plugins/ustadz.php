<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        table = $('#table-ustadz').DataTable({
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
                "url": "<?= base_url('ustadz/all') ?>",
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

        $('#table-ustadz').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('ustadz/GetUserById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    $('#form-update-ustadz [name="id"]').val(response.id);
                    $('#form-update-ustadz [name="name"]').val(response.name);
                    $('#form-update-ustadz [name="email"]').val(response.email);
                    $('#form-update-ustadz [name="jenis_kelamin"]').val(response.jenis_kelamin).trigger('change');
                    $('#form-update-ustadz [name="nik"]').val(response.nik);
                    $('#form-update-ustadz [name="nip"]').val(response.nip);
                    $('#form-update-ustadz [name="phone"]').val(response.phone);
                    $('#form-update-ustadz [name="tempat_lahir"]').val(response.tempat_lahir);
                    $('#form-update-ustadz [name="tanggal_lahir"]').val(response.tanggal_lahir);

                    $('#modal-update-ustadz').modal('show');
                    // console.log(response);
                }
            });
        });

        $('#table-ustadz').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#form-delete-ustadz [name="id"]').val(id);
            $('#modal-delete-ustadz').modal('show');
        });

        $('#form-add-ustadz').submit(function() {
            $('.nik-mask').unmask();
            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: "<?= site_url('ustadz/add') ?>",
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

                        $('#modal-add-ustadz').modal('hide');
                        $('#form-add-ustadz')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-update-ustadz').submit(function() {
            $('.nik-mask').unmask();
            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: "<?= site_url('ustadz/update') ?>",
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

                        $('#modal-update-ustadz').modal('hide');
                        $('#form-update-ustadz')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-delete-ustadz').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('ustadz/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-delete-ustadz').modal('hide');
                        $('#form-delete-ustadz')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#table-ustadz').on('click', '.btn-add-tag', function() {
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
                url: "<?= site_url('Ustadz/addTag') ?>",
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

    });
</script>