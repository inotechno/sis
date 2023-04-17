<!-- Page Content  -->
<div id="content-page" class="content-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Daftar Hadir</h4>
						</div>
					</div>
					<div class="iq-card-body">
						<div class="row">
							<div class="col-md">
								<div class="form-group">
									<label for="select-santri">Pilih Santri</label>
									<select name="santri_id" id="select-santri" class="form-control select2 select-santri filter"></select>
								</div>
							</div>

							<div class="col-md">
								<div class="form-group">
									<label for="select-mapel">Pilih Jadwal</label>
									<select name="jadwal_id" id="select-mapel" class="form-control select2 select-mapel filter"></select>
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table id="table-kehadiran" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
								<thead>
									<tr>
										<th>NIS</th>
										<th>Nama</th>
										<th>Mata Pelajaran</th>
										<th>Waktu Absen</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody id="table-body-kehadiran">

								</tbody>
							</table>
						</div>

						<div class="row">
							<div class="col-md d-flex">
								<h4 class="m-1"><span class="badge badge-primary">Hadir : <span class="jumlah-hadir"></span></span></h4>
								<h4 class="m-1"><span class="badge badge-success">Izin : <span class="jumlah-izin"></span></span></h4>
								<h4 class="m-1"><span class="badge badge-warning">Sakit : <span class="jumlah-sakit"></span></span></h4>
								<h4 class="m-1"><span class="badge badge-danger">Tidak Masuk : <span class="jumlah-tidak-hadir"></span></span></h4>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
