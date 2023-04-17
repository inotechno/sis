<!-- Page Content  -->
<div id="content-page" class="content-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<div class="iq-card">

					<div class="iq-card-body">
						<h4 class="card-title">Cari Santri</h4>
						<form method="get" id="form-search-santri">
							<input type="text" name="tag_search" class="form-control" autofocus>
						</form>
						<p class="card-text">
							<small class="text-muted">* Scan Tag untuk mencari santri</small>
						</p>

					</div>
				</div>

				<div class="iq-card hide-before-tag">
					<div class="iq-card-body p-0">
						<div class="user-post-data p-3">
							<div class="d-flex flex-wrap">
								<div class="media-support-user-img mr-3">
									<img class="rounded-circle img-fluid" id="img-santri" src="<?= base_url('assets') ?>/images/user/02.jpg" alt="">
								</div>
								<div class="media-support-info mt-2">
									<h5 class="mb-0"><a href="#" class="" id="name-santri"></a></h5>
									<p class="mb-0 text-primary" id="nis-santri"></p>
								</div>
								<div class="iq-card-header-toolbar d-flex align-items-center">
									Saldo Rp. &nbsp;<span class="text-secondary" id="saldo-santri"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md hide-before-tag">
				<div class="iq-card">

					<div class="iq-card-body">
						<div class="row">
							<div class="col-md">
								<form method="get" id="form-search-produk">
									<input type="text" name="barcode_search" class="form-control">
								</form>
								<p class="card-text">
									<small class="text-muted">* Scan barcode produk disini</small>
								</p>
							</div>

							<div class="col-md text-right align-middle">
								<h2 class="font-weight-bold">Rp. <span id="total-invoice">0</span></h2>
							</div>
						</div>
					</div>
				</div>

				<form id="form-checkout" method="POST">
					<input type="hidden" name="santri_id">
					<input type="hidden" name="amount">
					<input type="hidden" name="saldo_santri">

					<div class="iq-card">
						<div class="iq-card-body">
							<h4 class="card-title">Checkout</h4>

							<ul class="suggestions-lists m-0 p-0 list-product">

							</ul>
						</div>
					</div>
				</form>

				<button class="btn btn-warning btn-rounded float-right" type="submit" form="form-checkout"><span class="ri-shopping-cart-fill"></span> &nbsp;Checkout</button>
			</div>

		</div>
	</div>
</div>
