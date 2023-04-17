<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {

        $('#btn-delete').on('click', function() {
            var id = $(this).attr('data-id');
            $('[name="id"]').val(id);
            $('#modal-delete-order').modal('show');
        });

        $('#form-delete-order').submit(function() {
            $.ajax({
                type: "POST",
                url: base_url + 'Order/delete',
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(response) {
                    notification(response.type, response.message);
                    setTimeout(() => {
                        location.href = base_url + "order-ws";
                    }, 400);
                }
            });

            return false;
        });

    });
</script>