<!-- Page Content  -->
<div id="content-page" class="content-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Upload Raport</h4>
						</div>
					</div>
					<div class="iq-card-body">
						<div class="row">
							<div class="col-md-6">
								<form action="<?= site_url('_Ustadz/Raport/template') ?>" method="POST">
									<div class="form-group">
										<select name="kelas_id" id="" class="form-control select-kelas" required></select>
									</div>

									<button type="submit" class="btn btn-success">Download Template</button>
								</form>
							</div>

							<div class="col-md-6 mt-2">
								<form method="POST" id="form-import" enctype="multipart/form-data">
									<div class="form-group">
										<div class="custom-file">
											<input type="file" name="template" class="custom-file-input" id="template-raport">
											<label class="custom-file-label" for="template-raport">Pilih Template</label>
										</div>
									</div>
									<button class="btn btn-primary btn-upload" id="btn-upload" type="submit">Upload</button>
								</form>


							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md">
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Daftar Raport</h4>
						</div>
					</div>
					<div class="iq-card-body">
						<table id="table-raport" class="table">
							<thead>
								<td>NIS</td>
								<td>Nama</td>
								<td>Kelas</td>
								<td>Action</td>
							</thead>
							<tbody id="table-body-raport"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
