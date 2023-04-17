<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title><?= _SHORT_APP_NAME . ' | ' . _NAMA_PESANTREN ?></title>
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?= base_url('assets/images/' . _LOGO_MINI . '?time=' . time()) ?>" />
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/bootstrap.min.css" />
	<!-- Typography CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/typography.css" />
	<!-- Style CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/style.css" />
	<!-- Responsive CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/responsive.css" />
	<!-- Full calendar -->
	<link href="<?= base_url('assets/') ?>fullcalendar/core/main.css" rel="stylesheet" />
	<link href="<?= base_url('assets/') ?>fullcalendar/daygrid/main.css" rel="stylesheet" />
	<link href="<?= base_url('assets/') ?>fullcalendar/timegrid/main.css" rel="stylesheet" />
	<link href="<?= base_url('assets/') ?>fullcalendar/list/main.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />


	<?php
	if (!empty($css)) {
		$this->load->view($css);
	}
	?>

	<script>
		var base_url = '<?= site_url(); ?>';
	</script>
</head>