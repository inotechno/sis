<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        table = $('#table-visitor').DataTable({
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
                "url": "<?= base_url('visitor/all') ?>",
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

        $('#btn-in').click(function() {
            $('#modal-check-in').modal('show');
            $('#modal-check-in').on('shown.bs.modal', function() {
                setInterval(() => {
                    get_tag_check_in();
                }, 2000);
            });
        });

        $('#btn-out').click(function() {
            $('#modal-check-out').modal('show');
            $('#modal-check-out').on('shown.bs.modal', function() {
                setInterval(() => {
                    get_tag_check_out();
                }, 2000);
            });
        });

        // get_tag_id();

        function get_tag_check_in() {
            var tag_input = $('#form-check-in [name="tag_id"]');

            $.ajax({
                type: "GET",
                url: "<?= site_url('Visitor/GetTagCheckIn') ?>",
                dataType: "JSON",
                success: function(data) {
                    if (data) {
                        tag_input.val(data.tag_id);
                    }
                }
            });

            return false;
        }

        function get_tag_check_out() {
            var tag_input = $('#form-check-out [name="tag_id"]');

            $.ajax({
                type: "GET",
                url: "<?= site_url('Visitor/GetTagCheckOut') ?>",
                dataType: "JSON",
                success: function(data) {
                    if (data) {
                        tag_input.val(data.tag_id);
                    }
                }
            });

            return false;
        }

        $('#form-check-in').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('Visitor/add') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-check-in').modal('hide');
                        $('#form-check-in')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-check-out').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('Visitor/update') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-check-out').modal('hide');
                        $('#form-check-out')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

    });
</script>