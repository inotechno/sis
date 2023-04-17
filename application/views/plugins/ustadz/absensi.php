<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
	$(document).ready(function() {
		$('.card-hide').hide();

		GetJadwalWaktuIni();
		GetSantriByJadwal();
		// GetMapel();
		// GetKelas();
		// GetUstadz();

		table = $('#table-kehadiran').DataTable({
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
				"url": "<?= base_url('absensi-us/jadwal') ?>",
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

		$('#modal-add-absensi').on('shown.bs.modal', function() {
			$('[name="tag_id"]').focus();
		});

		function GetJadwalWaktuIni() {
			$.ajax({
				type: "GET",
				url: "<?= site_url('absensi-us/jadwal-sekarang') ?>",
				dataType: "JSON",
				success: function(data) {
					if (data.status != 'error') {
						$('.nama-mapel').html(data.jadwal.nama_mapel);
						$('.waktu-mulai').html(data.jadwal.waktu_mulai);
						$('.jumlah-santri').html(parseInt(data.jumlah_santri));
						$('[name="jadwal_id"]').val(data.jadwal.id);
						$('.card-hide').show();
					} else {
						$('.nama-mapel').html(data.message);
						$('.card-hide').hide();
					}

					console.log(data);
				}
			});
		}

		function GetSantriByJadwal() {
			$.ajax({
				type: "GET",
				url: "<?= site_url('rombel/get-santri-rombel') ?>",
				dataType: "JSON",
				success: function(response) {
					var html = '<option value="" disabled>Pilih Santri</option>';
					$.each(response, function(i, val) {
						html += '<option value="' + val.tag_id + '">' + val.nis + ' | ' + val.nama_santri + '</option>';
					});

					$('.select-santri').html(html).trigger('change');
					// console.log(response);
				}
			});
		}

		$('#form-add-absen').submit(function() {
			var data = $(this).serialize();

			$.ajax({
				type: "POST",
				url: "<?= site_url('kehadiran/add') ?>",
				data: data,
				dataType: "JSON",
				success: function(response) {

					if (response.type != 'success') {
						notification(response.type, response.message);
					} else {
						notification(response.type, response.message);

						$('#modal-add-absen').modal('hide');
						$('#form-add-absen')[0].reset();

						reload_table();
					}

				}
			});

			return false;

		});

		$('#form-add-absensi').submit(function() {
			$.ajax({
				type: "POST",
				url: "<?= site_url('kehadiran/add') ?>",
				data: $(this).serialize(),
				dataType: "JSON",
				success: function(response) {

					notification(response.type, response.message);
					$('[name="tag_id"]').val("");
					$('[name="tag_id"]').focus();
					reload_table();
					GetJadwalWaktuIni();
				}
			});

			return false;
		});

	});
</script>
