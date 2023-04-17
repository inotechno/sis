<script>
    $('#field-product').hide();

    $(document).ready(function() {
        getAll();
        getCategory();

        function getAll(limit, category_id) {
            $.ajax({
                type: "GET",
                url: "<?= site_url('product-ws/all') ?>",
                data: {
                    limit: limit,
                    category_id: category_id
                },
                dataType: "JSON",
                success: function(response) {
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

                        html += '<li class="ais-Hits-item iq-product-item iq-card">' +
                            '    <div class="text-center">' +
                            '        <a href="">' +
                            '            <div class="h-56 d-flex align-items-center justify-content-center bg-white iq-border-radius-15">' +
                            '                <img src="' + image + '" align="left" alt="" width="60%" height="60%">' +
                            '            </div>' +
                            '        </a>' +
                            '        <div class="card-body">' +
                            '            <div class="text-justify">' +
                            '                <a href="javascript:void(0)">' + val.title + '</a>' +
                            '                <p class="font-size-12 mb-0">' + val.description + '</p>' +
                            '                <span class="badge ' + color + '">' + val.category_title + '</span>' +
                            '            </div>' +
                            '            <div class="iq-product-action my-2">' +
                            '                <button type="button" class="btn btn-warning iq-waves-effect text-uppercase btn-sm btn-cart-in" data-id="' + val.id + '">' +
                            '                    <i class="ri-shopping-cart-fill mr-0"></i>' +
                            '                </button>' +
                            '                <span class="font-size-16 font-weight-bold float-right product-price">' + num + '</span>' +
                            '            </div>' +
                            '            <div class="text-justify">' +
                            '               <span class="badge badge-primary">Stok : ' + val.stok + '</span>' +
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

        $('#category-list').on('change', '[name="category"]', function() {

            var val = $(this).val();
            getAll(0, val);

            // console.log(val);   
        })

        $('#product-list').on('click', '.btn-cart-in', function() {
            var product_id = $(this).attr('data-id');

            $.ajax({
                type: "POST",
                url: "<?= site_url('_WaliSantri/Order/add_cart') ?>",
                data: {
                    product_id: product_id
                },
                dataType: "JSON",
                success: function(response) {
                    notification(response.type, response.message);
                }
            });
        });

        $('[name="barcode"]').change(function() {
            if ($(this).val() != '') {
                $("#field-product").show();
            } else {
                $('#field-product').hide();
            }
        })

    });
</script>