<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('partials/head');
?>

<body>
	<!-- loader Start -->
	<div id="loading">
		<div id="loading-center"></div>
	</div>
	<!-- loader END -->

	<!-- Wrapper Start -->
	<div class="wrapper">
		<?php
		$this->load->view('partials/sidebar');
		$this->load->view('partials/topbar');

		if (!empty($content)) {
			$this->load->view($content);
		} else {
			$this->load->view('partials/main');
		}

		?>
	</div>
	<!-- Wrapper END -->

	<div class="toast fade text-white border-0 notif" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" data-autohide="true" style="position: absolute; z-index:10000; top: 20px; right: 20px;">
		<div class="toast-header text-white">
			<svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
				<rect width="100%" height="100%" fill="#fff"></rect>
			</svg>
			<strong class="mr-auto text-white toast-title"></strong>
			<small>11 mins ago</small>
			<button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="toast-body">

		</div>
	</div>

	<?php
	$this->load->view('partials/footer');
	$this->load->view('partials/plugins');
	?>

</body>
<html>
