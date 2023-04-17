<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('TransaksiModel');
	}

	public function index()
	{
		$this->session->set_userdata(['menu_active' => 'transaksi-k', 'sub_menu_active' => '']);
		$menu = $this->MenusModel->getMenu();

		$data = [
			'content' => 'components/kasir/transaksi',
			'plugin' => 'plugins/kasir/transaksi',
			'css' => 'css/transaksi',
			'menus' => fetch_menu($menu)
		];

		$this->load->view('layouts/app', $data);
	}

	public function checkout_santri()
	{
		$bill['santri_id'] = str_replace("'", "", htmlspecialchars($this->input->post('santri_id'), ENT_QUOTES));
		$bill['order_id'] = date('dmYHis');
		$bill['gross_amount'] = str_replace("'", "", htmlspecialchars($this->input->post('amount'), ENT_QUOTES));

		$items = $this->input->post('product_id', true);

		$check_tagihan = $this->TransaksiModel->GetTransactionBySantri($bill['santri_id']);

		if ($check_tagihan->num_rows() > 0) {
			$response = array(
				'type' => 'warning',
				'title' => 'Gagal !!!',
				'message' => 'Santri masih memiliki tagihan yang belum dibayar !'
			);
		} else {

			$act = $this->TransaksiModel->create_bill_santri($bill, $items);

			if ($act) {
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Data Transaksi berhasil ditambah.'
				);
			} else {
				$response = array(
					'type' => 'warning',
					'title' => 'Gagal !!!',
					'message' => 'Data Transaksi gagal ditambah !'
				);
			}
		}

		echo json_encode($response);
	}
}
