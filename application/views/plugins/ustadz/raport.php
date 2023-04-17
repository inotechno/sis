<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
	$(document).ready(function() {
		GetKelas();
		GetRaport();

		function GetRaport() {
			$.ajax({
				type: "POST",
				url: "<?= site_url('_Ustadz/Raport/show') ?>",
				dataType: "HTML",
				success: function(response) {
					$('#table-body-raport').html(response);
				}
			});
		}

		function GetKelas() {
			$.ajax({
				type: "GET",
				url: "<?= site_url('_Ustadz/Raport/GetKelas') ?>",
				dataType: "JSON",
				success: function(data) {

					var html = '<option value="">Pilih Kelas</option>';

					$.each(data, function(i, val) {
						html += '<option value="' + val.id + '">' + val.nama_kelas + '</option>';
					});

					$('.select-kelas').html(html);
				}
			});
		}

		$('#form-import').submit(function() {
			var data = new FormData(this);
			data.append('kelas_id', $('[name="kelas_id"]').val());
			if ($('[name="kelas_id"]').val() == '') {
				notification('error', 'Kelas belum di pilih !');
			} else {
				$.ajax({
					type: 'POST',
					url: "<?php echo base_url('_Ustadz/Raport/import') ?>",
					data: data,
					dataType: 'json',
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						// $(".btn-upload").prop('disabled', true);
					},
					success: function(result) {
						console.log(result);
						// $(".btn-upload").prop('disabled', false);
						// if ($.isEmptyObject(result.error_message)) {
						//     $(".result").html(result.success_message);
						// } else {
						//     $(".sub-result").html(result.error_message);
						// }
					}
				});
			}

			return false;
		});

	});
</script>
