<script>
    $('#field-product').hide();

    $(document).ready(function() {
        getAll();
        getCategory();

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function getAll(limit, category_id) {
            $.ajax({
                type: "GET",
                url: "<?= site_url('product/all') ?>",
                data: {
                    limit: limit,
                    category_id: category_id
                },
                dataType: "JSON",
                success: function(response) {
                    // console.log(response);
                    var html = '';
                    var image = '';
                    $.each(response, function(i, val) {

                        if (val.images == '') {
                            image = base_url + 'assets/images/products/default.png';
                        } else {
                            image = base_url + 'assets/images/products/' + val.images[0].file_name;
                        }

                        if (val.description == null) {
                            val.description = 'Belum ada deskripsi';
                        }

                        if (val.category_title == null) {
                            val.category_title = 'Belum Ada Kategori';
                            color = 'badge-danger';
                        } else {
                            if (val.category_title == 'Makanan') {
                                color = 'badge-primary';
                            } else if (val.category_title == 'Minuman') {
                                color = 'badge-info';
                            } else {
                                color = 'badge-danger';
                            }
                        }

                        let num = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(val.price);
                        html += '<li class="ais-Hits-item iq-product-item card">' +
                            '    <div class="text-center">' +
                            '        <a href="">' +
                            '            <div class="h-56 d-flex align-items-center justify-content-center bg-white iq-border-radius-15">' +
                            '                <img src="' + image + '" align="left" alt="" width="60%" height="60%">' +
                            '            </div>' +
                            '        </a>' +
                            '        <div class="card-body">' +
                            '            <div class="text-justify">' +
                            '                <a href="javascript:void(0)">' + val.title + '</a>' +
                            '                <p class="font-size-12 mb-0">' + val.description.substring(0, 50) + '</p>' +
                            '                <span class="badge ' + color + '">' + val.category_title + '</span>' +
                            '            </div>' +
                            '            <div class="iq-product-action my-2">' +
                            '                <button type="button" class="btn btn-warning iq-waves-effect text-uppercase btn-sm btn-update" data-id="' + val.id + '">' +
                            '                    <i class="ri-edit-2-fill mr-0"></i>' +
                            '                </button>' +
                            '                <button type="button" class="btn btn-danger iq-waves-effect text-uppercase btn-sm btn-delete" data-id="' + val.id + '">' +
                            '                    <i class="ri-delete-bin-2-fill mr-0"></i>' +
                            '                </button>' +
                            '                <span class="font-size-16 font-weight-bold float-right product-price">' + num + '</span>' +
                            '            </div>' +
                            '            <div class="text-justify">' +
                            '               <span class="badge badge-primary">Stok : ' + val.stok + '</span>' +
                            '               <a href="#" title="Tambah Stok" data-id="' + val.id + '" class="btn-add-stok"><i class="ri-add-box-line"></i></a>' +
                            '            </div>' +
                            '        </div>' +
                            '    </div>' +
                            '</li>';
                    });

                    $('#product-list').html(html);
                }
            });

        }

        function getCategory() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('category/all') ?>",
                dataType: "JSON",
                success: function(response) {
                    var select = '';
                    // console.log(response);
                    var html = '<li class="mb-2 mr-0">' +
                        '    <div class="d-flex justify-content-between">' +
                        '       <div class="custom-control custom-radio custom-control-inline">' +
                        '           <input type="radio" id="customRadioAll" name="category" class="custom-control-input" checked="" value="">' +
                        '           <label class="custom-control-label" for="customRadioAll">All</label>' +
                        '       </div>' +
                        '       <span class="badge iq-bg-primary"></span>' +
                        '    </div>' +
                        '</li>';

                    $.each(response, function(i, val) {
                        select += '<option value="' + val.id + '">' + val.title + '</option>';
                        html += '<li class="mb-2 mr-0">' +
                            '    <div class="d-flex justify-content-between">' +
                            '       <div class="custom-control custom-radio custom-control-inline">' +
                            '           <input type="radio" id="customRadio' + val.id + '" name="category" class="custom-control-input" value="' + val.id + '">' +
                            '           <label class="custom-control-label" for="customRadio' + val.id + '">' + val.title + '</label>' +
                            '       </div>' +
                            '       <span class="badge iq-bg-primary">' + val.total_product + '</span>' +
                            '    </div>' +
                            '</li>';
                    });

                    // console.log(option);
                    $('.select-category').html(select);
                    $('#category-list').html(html);
                    // <li class="mb-2 mr-0">
                    //        <div class="d-flex justify-content-between">
                    //           <div class="custom-control custom-checkbox">
                    //              <input type="checkbox" class="custom-control-input brand-checkbox"
                    //                 id="customCheck1Insignia™" data-value="Insignia™" value="">
                    //              <label class="custom-control-label" for="customCheck1Insignia™">Insignia™</label>
                    //           </div>
                    //           <span class="badge iq-bg-primary">(746)</span>
                    //        </div>
                    //     </li>
                }
            });
        }

        $('#limit').change(function(e) {
            e.preventDefault();

            var val = $(this).val();

            let url = new URL(window.location.href);
            var search_params = url.searchParams;

            search_params.set('limit', val);
            search_params.delete('per_page');

            url.search = search_params.toString();
            var new_url = url.toString();

            getAll(val)
        });

        $('#btn-load-more').click(function(e) {
            e.preventDefault();
            var limit_now = $('.iq-product-item').get().length;
            var limit_x = parseInt(limit_now) + 2;
            // console.log(limit_x);
            getAll(limit_x);
        });

        $('#btn-add-product').click(function() {
            setTimeout(() => {
                $('#form-add-product [name="barcode"]').focus();
            }, 1000);
        });

        $('#category-list').on('change', '[name="category"]', function() {

            var val = $(this).val();
            getAll(0, val);

            // console.log(val);   
        })

        $('#product-list').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');
            $('.removeImage').remove();
            $('.image-upload image').attr('src', 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png');

            $.ajax({
                type: "GET",
                url: "<?= site_url('product/getById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    console.log(response);

                    if (response.images != '') {
                        const d = new Date();
                        let time = d.getTime();

                        $.each(response.images, function(i, val) {
                            no = i + 1;
                            $('#imageUpdate' + no).parent().find('img').attr({
                                'src': base_url + 'assets/images/products/' + val.file_name + '?time=' + time,
                                'class': 'preview' + val.id
                            });
                            $('#imageUpdate' + no).parent().append('<a href="#" class="removeImage" data-id="' + val.id + '">Remove</a>');
                            $('#imageUpdate' + no).prop('disabled', true);
                            no++;
                        });
                    }

                    $('#form-update-product [name="id"]').val(response.id);
                    $('#form-update-product [name="title"]').val(response.title);
                    $('#form-update-product [name="barcode"]').val(response.barcode);
                    $('#form-update-product [name="category_id"]').val(response.category_id).trigger('change');
                    $('#form-update-product [name="satuan"]').val(response.satuan).trigger('change');
                    $('#form-update-product [name="price"]').val(response.price);
                    $('#form-update-product [name="description"]').val(response.description);

                    $('#modal-update-product').modal('show');
                    // console.log(response);
                }
            });
        });

        $('.image-upload').on('click', '.removeImage', function() {
            var tag = this;
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: "<?= site_url('Product/removeImage/') ?>",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.type == 'success') {
                        notification(response.type, response.message);
                        $('.preview' + id).attr('src', 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png');
                        $(tag).parent().find('input').prop('disabled', false);
                        $(tag).remove();
                        // console.log(this);
                    } else {
                        notification(response.type, response.message);
                    }
                }
            });
        });

        $('#product-list').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#form-delete-product [name="id"]').val(id);
            $('#modal-delete-product').modal('show');
        });

        $('#product-list').on('click', '.btn-add-stok', function() {
            var id = $(this).attr('data-id');
            $('#form-add-stok [name="id"]').val(id);
            $('#modal-add-stok').modal('show');
        });

        $('#form-add-product').submit(function() {
            if ($('#form-add-product [name="title"]').val() != "") {
                var data = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "<?= site_url('product/add') ?>",
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

                            $('#modal-add-product').modal('hide');
                            $('#form-add-product')[0].reset();
                            getAll();
                            getCategory();
                        }

                    }
                });
            }

            return false;

        });

        $('#form-update-product').submit(function() {
            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: "<?= site_url('product/update') ?>",
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

                        $('#modal-update-product').modal('hide');
                        $('#form-update-product')[0].reset();
                        getAll();
                        getCategory();
                    }

                }
            });

            return false;

        });

        $('#form-delete-product').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('product/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-delete-product').modal('hide');
                        $('#form-delete-product')[0].reset();
                        getAll();
                        getCategory();
                    }

                }
            });

            return false;

        });

        $('#form-add-stok').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('product/add_stok') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-add-stok').modal('hide');
                        $('#form-add-stok')[0].reset();
                        getAll();
                        getCategory();
                    }

                }
            });

            return false;

        });

        $('[name="barcode"]').change(function() {
            if ($(this).val() != '') {
                $("#field-product").show();
            } else {
                $('#field-product').hide();
            }
        });

    });
</script>