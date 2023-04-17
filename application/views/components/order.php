<!-- Page Content  -->
<div id="content-page" class="content-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Daftar Transaksi</h4>
						</div>
						<div class="iq-card-header-toolbar d-flex align-items-center">
							<button class="float-right btn btn-sm btn-primary" id="btn-process-payment" data-toggle="modal" data-target="#modal-process-payment">Proses Bayar</button>
						</div>
					</div>
					<div class="iq-card-body">

						<div class="iq-card-body">
							<ul class="nav nav-tabs justify-content-center" id="tab-status" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="status-semua" data-status="semua" data-toggle="tab" href="#tab-justify" role="tab" aria-controls="semua" aria-selected="true">Semua</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="status-belum_dibayar" data-status="belum_dibayar" data-toggle="tab" href="#tab-justify" role="tab" aria-controls="belum_dibayar" aria-selected="false">Belum Dibayar</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="status-diproses" data-status="diproses" data-toggle="tab" href="#tab-justify" role="tab" aria-controls="diproses" aria-selected="false">Diproses</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="status-selesai" data-status="selesai" data-toggle="tab" href="#tab-justify" role="tab" aria-controls="selesai" aria-selected="true">Selesai</a>
								</li>
							</ul>
							<div class="tab-content" id="myTabContent-3">
								<div class="tab-pane fade active show" id="tab-justify" role="tabpanel">
									<div class="table-responsive">
										<table id="table-pesanan" class="table table-striped mt-4" role="grid" aria-describedby="user-list-page-info">
											<thead>
												<tr>
													<th>No Order</th>
													<th>NIS</th>
													<th>Name</th>
													<th>Wali Santri</th>
													<th>Total</th>
													<th>Status</th>
													<th>Jumlah Order</th>
													<th>Waktu Order</th>
													<th>Action</th>
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
		</div>
	</div>
</div>

<div class="modal fade" id="modal-delete-order" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<h5 class="modal-title text-white">Modal Delete</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="form-delete-order" method="POST">
					<input type="hidden" name="id">
				</form>

				<p>Apakah anda yakin ingin menghapus data ini ?</p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger" form="form-delete-order">Hapus</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal-process-payment" tabindex="-1" role="dialog" aria-labelledby="modal-process" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-body">

				<form id="form-process-payment" class="text-center mb-2" method="POST">
					<input type="text" class="form-control" name="tag_id">
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
