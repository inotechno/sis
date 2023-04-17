<!-- Page Content  -->
<div id="content-page" class="content-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6 col-md-6 col-lg-6">
				<li class="d-flex mb-3 align-items-center p-3 bg-white rounded">
					<div class="icon iq-icon-box rounded-circle bg-success">
						<i class="ri-book-read-fill" aria-hidden="true"></i>
					</div>
					<div class="media-support-info ml-3">
						<h6>Mata Pelajaran Sekarang</h6>
						<p class="mb-0 font-size-12"><span class="nama-mapel"></span></p>
					</div>
					<div class="iq-card-header-toolbar">
						<h6 class="text-dark">Waktu</h6>
						<div class="badge badge-pill badge-success"><span class="waktu-mulai"></span></div>
					</div>
				</li>
			</div>

			<div class="col-sm-6 col-md-6 col-lg-6 card-hide">
				<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
					<div class="iq-card-body">
						<div class="d-flex align-items-center justify-content-between text-right">
							<div class="icon iq-icon-box rounded-circle bg-primary">
								<i class="ri-folder-user-fill" aria-hidden="true"></i>
							</div>
							<div>
								<h5 class="mb-0">Total Absen</h5>
								<span class="h4 text-primary mb-0 d-inline-block w-100"><span class="jumlah-santri"></span></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row card-hide">
			<div class="col-md-12">
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Daftar Hadir</h4>
						</div>
						<div class="iq-card-header-toolbar d-flex align-items-center">
							<button class="float-right btn btn-sm btn-primary mr-2" id="btn-scan" data-toggle="modal" data-target="#modal-add-absensi">Scan Absen</button>
							<button class="float-right btn btn-sm btn-primary" id="btn-tambah" data-toggle="modal" data-target="#modal-add-absen">Tambah</button>
						</div>
					</div>
					<div class="iq-card-body">
						<div class="table-responsive">
							<table id="table-kehadiran" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
								<thead>
									<tr>
										<th>NIS</th>
										<th>Nama</th>
										<th>Waktu Absen</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-add-absen" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-white">Modal Daftar Hadir</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="form-add-absen" method="POST">
					<input type="hidden" name="jadwal_id">
					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label for="select-santri">Pilih Santri</label>
								<select name="tag_id" class="form-control select2 select-santri" id="select-santri" style="width: 100%;"></select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="">Status</label>
								<select name="status" id="status" class="form-control select2" style="width: 100%;">
									<option value="hadir">Hadir</option>
									<option value="tidak hadir">Tidak Hadir</option>
									<option value="izin">Izin</option>
									<option value="sakit">Sakit</option>
								</select>
							</div>
						</div>

					</div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" form="form-add-absen">Save</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal-add-absensi" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-body">

				<form id="form-add-absensi" class="text-center mb-2" method="POST">
					<input type="text" class="form-control" name="tag_id">
					<input type="hidden" name="jadwal_id">
					<input type="hidden" name="status" value="hadir">
				</form>

				<div class="col-md-12  text-center">
					<img src="<?= base_url('assets/images/progress.gif') ?>" alt="">
				</div>
				<br>
				<small class="text-danger">Klik <strong>ESC</strong> untuk exit</small>
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div> -->
		</div>
	</div>
</div>
