<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        let status;
        table = $('#table-pesanan').DataTable({
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
                "url": "<?= base_url('saldo/show') ?>",
                "type": "POST",
                "data": function(data) {
                    // Append to data
                    data.status = status;
                }
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

        function draw_table() {
            table.draw();
        }

        $('#tab-status').on('click', '.nav-link', function() {
            status = $(this).attr('data-status');
            // console.log(status);
            draw_table();
        });

        $('#table-pesanan').on('click', '.btn-validasi', function() {
            var id = $(this).attr('data-id');
            $('[name="id"]').val(id);
            $('#modal-validation-topup').modal('show');
        });

        $('#form-validation-topup').submit(function() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('Saldo/validation') ?>",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(response) {
                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-validation-topup').modal('hide');
                        $('#form-validation-topup')[0].reset();

                        reload_table();
                    }
                }
            });

            return false
        });
    });
</script>