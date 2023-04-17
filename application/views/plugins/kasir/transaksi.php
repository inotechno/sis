<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
	$('.hide-before-tag').hide();
	$(document).ready(function() {

		$('#form-search-santri').submit(function() {
			var tag = $('[name="tag_search"]').val();

			$.ajax({
				type: "GET",
				url: "<?= site_url('Santri/GetSantriByTag/') ?>" + tag,
				dataType: "JSON",
				success: function(data) {

					if (data != null) {
						// $('#img-santri')
						$('#name-santri').html(data.name);
						$('#nis-santri').html(data.nis);
						$('#saldo-santri').html(data.saldo).simpleMoneyFormat();
						$('[name="santri_id"]').val(data.id_santri);
						$('[name="saldo_santri"]').val(data.saldo);

						$('.hide-before-tag').show();
						$('[name="barcode_search"]').focus();
					} else {
						$('[name="tag_search"]').val("");
						$('[name="tag_search"]').focus();

						notification('error', 'Tidak ada data santri, silahkan cek kembali tag yang dimasukan');
					}
				}
			});

			return false;
		});

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

		$('#form-search-produk').submit(function() {
			var barcode = $('[name="barcode_search"]').val();
			$.ajax({
				type: "GET",
				url: "<?= site_url('product/GetByBarcode/') ?>" + barcode,
				dataType: "JSON",
				success: function(data) {
					console.log(data);
					if (data) {
						if (data.category_id == 7) {
							data.stok = 1000;
						}

						if (data.stok < 1) {
							notification('error', 'Stok produk ini tidak tersedia !');
						} else {
							var count = $('.check-product').length + 1;
							// console.log(data);
							var html = '<li class="d-flex mt-3 align-items-center check-product" data-id="' + count + '">' +
								'<div class="user-img img-fluid"><img src="<?= base_url('assets') ?>/images/user/01.jpg" alt="story-img" class="rounded-circle avatar-40"></div>' +
								'<div class="media-support-info ml-3">' +
								'<h6>' + data.title + '</h6>' +
								'<p class="mb-0">' + data.price + '</p>' +
								'</div>' +

								'<div class="d-flex justify-content-center btn-increment mt-3">' +
								'<button type="button" data-max="' + data.stok + '" class="btn-less" disabled><i class="ri-subtract-fill"></i></button>' +
								'<input type="text" value="1" name="total_item[]" class="" readonly style="width: 40px; text-align:center">' +
								'<button type="button" data-max="' + data.stok + '" class="btn-plus"><i class="ri-add-fill"></i></button>' +
								'<button type="button" data-id="' + count + '" class="btn-delete text-danger"><i class="ri-close-line"></i></button>' +
								'<input type="hidden" name="product_id[]" value="' + data.id + '">' +
								'<input type="hidden" name="price[]" class="price" value="' + data.price + '">' +
								'<input type="hidden" name="stok[]" value="' + data.stok + '">' +
								'</div>' +
								'</li>';

							$('.list-product').append(html);

							$('#form-search-produk')[0].reset();
							total();
						}
					} else {
						notification('error', 'Produk tidak ada');
					}
				}
			});

			return false;
		});

		function total() {
			var _total = $('#total-invoice');

			var sum = 0;

			$('.price').each(function() {
				var jumlah = $(this).parent().find('input:text').val();
				sum += +$(this).val() * jumlah;
			});

			_total.html(sum).simpleMoneyFormat();
			$('[name="amount"]').val(sum);
		}

		$('#form-checkout').submit(function() {
			var amount = $('[name="amount"]').val();
			var saldo = $('[name="saldo_santri"]').val();

			if ($('.check-product').length == 0) {
				notification('error', 'Tidak ada produk yang dipilih silahkan scan barcode yang ada di produk');
			} else if (parseInt(saldo) < parseInt(amount)) {
				notification('error', 'Saldo tidak mencukupi, silahkan hapus beberapa item');
			} else {
				$.ajax({
					type: "POST",
					url: "<?= site_url('_Kasir/Transaksi/checkout_santri') ?>",
					data: $(this).serialize(),
					dataType: "JSON",
					success: function(response) {
						notification(response.type, response.message);

						if (response.type == 'success') {
							setTimeout(() => {
								location.reload();
							}, 500);
						}
					}
				});
			}

			return false;
		});


	});
</script>
