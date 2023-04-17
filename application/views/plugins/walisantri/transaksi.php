<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    // $('.hide-before-nis').hide();
    $(document).ready(function() {
        GetSantri();
        GetCart();
        get_payment_method();

        var ppn = 0;
        var fee = 0;

        function GetSantri() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('_WaliSantri/Santri/GetSantriByWali') ?>",
                dataType: "JSON",
                success: function(data) {
                    var html = '';
                    $.each(data, function(i, val) {
                        html += '<option value="' + val.id_santri + '">' + val.nis + ' | ' + val.name + '</option>';
                    });

                    $('.select-santri').html(html);
                }
            });
        }

        function GetCart() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('_WaliSantri/Transaksi/getCart') ?>",
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    var image = '';
                    $.each(data, function(i, val) {
                        if (val.images == '') {
                            image = base_url + 'assets/images/products/default.png';
                        } else {
                            image = base_url + 'assets/images/products/' + val.images[0].file_name;
                        }

                        if (val.category_id == 7) {
                            val.stok = 1000;
                        }

                        var count = $('.check-product').length + 1;
                        // console.log(data);
                        var html = '<li class="d-flex mt-3 align-items-center check-product" data-id="' + count + '">' +
                            '<div class="user-img img-fluid"><img src="' + image + '" alt="story-img" class="rounded-circle avatar-40"></div>' +
                            '<div class="media-support-info ml-3">' +
                            '<h6>' + val.title + '</h6>' +
                            '<p class="mb-0">' + val.price + '</p>' +
                            '</div>' +

                            '<div class="d-flex justify-content-center btn-increment mt-3">' +
                            '<button type="button" data-max="' + val.stok + '" class="btn-less" disabled><i class="ri-subtract-fill"></i></button>' +
                            '<input type="text" value="1" name="total_item[]" class="" readonly style="width: 40px; text-align:center">' +
                            '<button type="button" data-max="' + val.stok + '" class="btn-plus"><i class="ri-add-fill"></i></button>' +
                            '<button type="button" data-id="' + count + '" class="btn-delete text-danger"><i class="ri-close-line"></i></button>' +
                            '<input type="hidden" name="id_cart[]" value="' + val.id_cart + '">' +
                            '<input type="hidden" name="product_id[]" value="' + val.id + '">' +
                            '<input type="hidden" name="price[]" class="price" value="' + val.price + '">' +
                            '<input type="hidden" name="stok[]" value="' + val.stok + '">' +
                            '</div>' +
                            '</li>';

                        $('.list-product').append(html);

                        total();

                    });

                }
            });
        }

        function get_payment_method() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('Payment/get_payment_method') ?>",
                dataType: "JSON",
                success: function(data) {
                    // var html = '';
                    // console.log(data);
                    var method = '';

                    $.each(data, function(i, val) {
                        var options = '';
                        // console.log(val);
                        $.each(val.options, function(a, op) {
                            // console.log(s);
                            options += '<a href="#" class="list-group-item d-flex justify-content-between align-items-center options list-group-item-action">' +
                                '    <img class="img-fluid" src="' + op.logo + '" alt="" width="60px">' +
                                '    <div class="custom-control custom-radio custom-radio-color custom-control-inline">' +
                                '        <input type="radio" fee="' + op.fee + '" id="' + op.name_slug + '-id" name="payment_type" class="custom-control-input bg-success" value="' + op.name_slug + '">' +
                                '        <label class="custom-control-label" for="' + op.name_slug + '-id"></label>' +
                                '    </div>' +
                                '</a>';

                        });

                        method += '<a class="d-flex mb-3 align-items-center p-3 sell-list border-primary rounded" data-toggle="collapse" data-target="#' + val.type_slug + '" aria-expanded="true" aria-controls="' + val.type_slug + '">' +
                            '    <div class="media-support-info ml-3">' +
                            '        <h5 class="font-weight-bold">' + val.type + '</h5>' +
                            '    </div>' +
                            '    </a>' +
                            '    <div id="' + val.type_slug + '" class="mb-2 collapse list-group list-group-flush" data-parent="#payment-method">' + options + '</div>';
                    });

                    $('#payment-method').html(method);
                }
            });
        }

        $('.list-product').on('click', '.btn-plus', function() {
            less = $(this).parent().find('.btn-less');
            plus = $(this).parent().find('.btn-plus');
            num = $(this).parent().find('input:text');

            max = $(this).attr('data-max');

            if (parseInt(num.val()) < max) {
                num.val(parseInt(num.val()) + 1);
            }
            if (parseInt(num.val()) > 0) {
                less.prop('disabled', false);
            }
            if (parseInt(num.val()) == max) {
                plus.prop('disabled', true);
            }

            total();
            // console.log(num)
        });

        $('.list-product').on('click', '.btn-less', function() {
            less = $(this).parent().find('.btn-less');
            plus = $(this).parent().find('.btn-plus');
            num = $(this).parent().find('input:text');
            max = $(this).attr('data-max');

            if (parseInt(num.val()) > 1) {
                num.val(parseInt(num.val()) - 1);
            }
            if (parseInt(num.val()) == 1) {
                less.prop('disabled', true);
            }
            if (parseInt(num.val()) == max) {
                plus.prop('disabled', false);
            } else {
                plus.prop('disabled', false);
            }

            total();

        });

        $('.list-product').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('li[data-id=' + id + ']').remove();

            total();
        });

        $('#payment-method').on('click', '.options', function() {
            $('input[type="radio"]').prop('checked', false);
            $(this).find('input').prop('checked', true);
            fee = $(this).find('input').attr('fee');

            if ($(this).find('input').val() == 'credit_card') {
                $('#form-card').fadeIn();
            }

            total();
        });

        function total() {
            var _total = $('#gross_amount');

            var sum = 0;
            var gross = 0;

            $('.price').each(function() {
                var jumlah = $(this).parent().find('input:text').val();
                sum += $(this).val() * jumlah;
            });

            ppn = (sum + parseInt(fee)) * 11 / 100;
            gross = (sum + parseInt(fee)) + ppn;

            $('#sub-total').html(sum + parseInt(fee)).simpleMoneyFormat();
            $('#fee').html(fee).simpleMoneyFormat();
            $('#ppn').html(ppn).simpleMoneyFormat();
            $('#total-harga').html(sum).simpleMoneyFormat();
            $('[name="amount"]').val(sum);
            _total.html(gross).simpleMoneyFormat();
            $('[name="gross_amount"]').val(gross);
        }

        $('#btn-checkout').click(function() {
            if ($('[name="payment_type"]').is(':checked') == false) {
                notification('error', 'Silahkan pilih metode pembayaran terlebih dahulu');
                $('#modal-checkout').modal('hide');
            } else if ($('#credit_card-id').is(':checked')) {
                checkCard();
                return false;
            } else {
                $('#modal-checkout').modal('show');
            }
        });

        $("#check-card").click(function() {
            checkCard();
        })

        function checkCard() {
            // var username = 'xnd_public_production_Z9fy7zaF7wvwWzROXTDjfSITyC2SK3SflUWgI40AIj1qc34xFuHzDztt7LUoL6';
            // var password = '';

            var cardNumberValidate = Xendit.card.validateCardNumber($('[name="card_number"]').val()); // true
            // Xendit.card.validateCardNumber('abc'); // false

            var cardMonthYearValidate = Xendit.card.validateExpiry($('[name="month"]').val(), $('[name="year"]').val()); // true
            // Xendit.card.validateExpiry('13', '2017'); // false

            var cardCvnValidate = Xendit.card.validateCvn($('[name="cvn"]').val()); // true
            // Xendit.card.validateCvn('aaa'); // false

            if (cardNumberValidate == false || cardMonthYearValidate == false || cardCvnValidate == false) {
                alert('Kartu Tidak Valid Coba Periksa Kembali !!')
            } else {
                var cardNumberValidate = Xendit.card.createToken({
                    amount: $('[name="gross_amount"]').val(),
                    card_number: $('[name="card_number"]').val(),
                    card_exp_month: $('[name="month"]').val(),
                    card_exp_year: $('[name="year"]').val(),
                    card_cvn: $('[name="cvn"]').val(),
                    is_multiple_use: false,
                    should_authenticate: true
                }, xenditResponseHandler);

                return false;
            }

        }

        function xenditResponseHandler(err, creditCardToken) {

            var $form = $('#form-checkout');

            if (err) {
                notification('error', err.message);
                $form.find('button [type="submit"]').prop('disabled', false); // Re-enable submission

                return;
            }

            // console.log(creditCardToken);
            if (creditCardToken.status === 'VERIFIED') {
                // Get the token ID:
                var token = creditCardToken.id;
                var auth_id = creditCardToken.authentication_id;

                // Insert the token into the form so it gets submitted to the server:
                $('[name="token_id"]').val(token);
                $('[name="auth_id"]').val(auth_id);
                // $('[name="auth_id"]').val();

                // Submit the form to your server:
                var data = $('#form-checkout').serialize();
                $('#form-checkout').submit();
            } else if (creditCardToken.status === 'IN_REVIEW') {
                // $.modalLink.open(creditCardToken.payer_authentication_url);
                window.open(creditCardToken.payer_authentication_url, 'sample-inline-frame');
                $('#modal-container').modal('show');
            } else if (creditCardToken.status === 'FAILED') {
                notification('error', creditCardToken.failure_reason);
            }
        }

    });
</script>