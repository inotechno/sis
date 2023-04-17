<!-- Page Content  -->
<div id="content-page" class="content-page">
	<div class="container-fluid">

		<div class="row">
			<div class="col-sm-12">
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Daftar Tamu</h4>
						</div>
						<div class="iq-card-header-toolbar d-flex align-items-center">
							<button class="float-right btn btn-sm btn-primary" id="btn-in">IN</button>
							<button class="float-right btn btn-sm btn-danger ml-2" id="btn-out">OUT</button>
						</div>
					</div>
					<div class="iq-card-body">
						<div class="table-responsive">
							<table id="table-visitor" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
								<thead>
									<tr>
										<th>Tag ID</th>
										<th>Nama Lengkap</th>
										<th>Keterangan</th>
										<th>Waktu Datang</th>
										<th>Waktu Keluar</th>
										<th>Penerima</th>
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


<div class="modal fade" id="modal-check-in" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-white">Modal Check In</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form method="POST" id="form-check-in">
					<div class="col-md">
						<div class="form-group">
							<label for="tag_id">Tag ID</label>
							<input type="text" name="tag_id" class="form-control">
						</div>

						<small class="text-muted">* Silahkan tempelkan kartu RFID yang baru, form akan terisi otomatis !</small>

					</div>

					<div class="col-md-12 hidden">
						<div class="form-group">
							<label for="nama_lengkap">Nama Lengkap</label>
							<input type="text" name="nama_lengkap" class="form-control">
						</div>
					</div>

					<div class="col-md-12 hidden">
						<label for="keterangan">Keterangan</label>
						<textarea name="keterangan" cols="30" rows="2" class="form-control"></textarea>
					</div>

				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-warning" form="form-check-in">Check In</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-check-out" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-white">Modal Check Out</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form method="POST" id="form-check-out">
					<div class="form-group">
						<label for="tag_id">Tag ID</label>
						<input type="text" name="tag_id" class="form-control">
					</div>

					<small class="text-muted">* Silahkan tempelkan kartu RFID yang baru, form akan terisi otomatis !</small>

				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-warning" form="form-check-out">Check Out</button>
			</div>
		</div>
	</div>
</div>