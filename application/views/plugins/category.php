<script>
    $(document).ready(function() {
        getAll();

        function getAll() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('category/all') ?>",
                dataType: "JSON",
                success: function(response) {
                    var html = '';
                    // console.log(response.length);

                    if (response.length != 0) {
                        $.each(response, function(i, val) {
                            if (!val.images) {
                                val.images = 'data:image/png;base64,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';
                            }

                            html += '<div class="col-md-6">' +
                                '<div class="iq-card">' +
                                '<div class="iq-card-body">' +
                                ' <li class="d-flex align-items-center p-2">' +
                                '<div class="user-img img-fluid">' +
                                '<img src="' + val.images + '" alt="story-img" class="rounded-circle avatar-50">' +
                                '</div>' +
                                '<div class="media-support-info ml-3">' +
                                '<h4 class="d-inline-block">' + val.title + '</h4>' +
                                '</div>' +

                                '<div class="iq-card-header-toolbar d-flex align-items-center">' +
                                ' <button data-id="' + val.id + '" class="btn btn-outline-danger rounded-pill btn-sm mr-2 btn-delete">' +
                                ' <i class="ri-delete-bin-3-line"></i> <small>Delete</small>' +
                                '</button>' +
                                '<button data-id="' + val.id + '" class="btn btn-outline-warning rounded-pill btn-sm mr-2 btn-update">' +
                                '<i class="ri-edit-2-fill"></i> <small>Ubah</small>' +
                                '</button>' +
                                '<button data-id="' + val.id + '" class="btn btn-outline-info rounded-pill btn-sm">' +
                                '<i class="ri-eye-line"></i> <small>Lihat Produk</small>' +
                                '</button>' +
                                ' </div>' +
                                '</li>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    } else {
                        html += '<div class="col-md-12">' +
                            '<div class="iq-card">' +
                            '<div class="iq-card-body">' +
                            '<li class="d-flex align-items-center p-2">' +

                            '<div class="media-support-info ml-3 text-center">' +
                            '<h4 class="d-inline-block">BELUM ADA KATEGORI</h4>' +
                            '</div>' +

                            '</li>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }


                    $('#category-list').html(html);
                }
            });
        }

        $('#btn-add').click(function() {
            $('#modal-add').modal('show');
        });

        $('#category-list').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');

            if (id == 7) {
                notification('error', 'Kategori ini tidak bisa di hapus');
            } else {
                $('#form-delete [name="id"]').val(id);
                $('#modal-delete').modal('show');
            }
        });

        $('#category-list').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');

            $.ajax({
                type: "GET",
                url: "<?= site_url('category/getById/') ?>" + id,
                dataType: "JSON",
                success: function(data) {
                    $('#form-update [name="id"]').val(data.id);
                    $('#form-update [name="title"]').val(data.title);

                    // $('[name="title"]').val(data.title);
                    $('#modal-update').modal('show');
                }
            });

        });

        $('#form-update').submit(function() {
            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url: "<?= site_url('category/update') ?>",
                dataType: "JSON",
                success: function(response) {
                    $('#form-update')[0].reset();
                    $('#modal-update').modal('hide');

                    getAll();
                    notification(response.type, response.message);
                }
            });

            return false;
        });

        $('#form-add').submit(function() {
            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url: "<?= site_url('category/add') ?>",
                dataType: "JSON",
                success: function(response) {
                    $('#form-add')[0].reset();
                    $('#modal-add').modal('hide');

                    getAll();
                    notification(response.type, response.message);
                }
            });

            return false;
        });

        $('#form-delete').submit(function() {
            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url: "<?= site_url('category/delete') ?>",
                dataType: "JSON",
                success: function(response) {
                    $('#form-delete')[0].reset();
                    $('#modal-delete').modal('hide');

                    getAll();
                    notification(response.type, response.message);
                }
            });

            return false;
        });

    });
</script>