<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('DashboardModel');
	}

	public function index()
	{
		$this->session->set_userdata(['menu_active' => 'dashboard', 'sub_menu_active' => '']);
		$menu = $this->MenusModel->getMenu();

		$data = [
			'content' => 'components/dashboard',
			'plugin' => 'plugins/dashboard',
			'menus' => fetch_menu($menu)
		];

		$this->load->view('layouts/app', $data);
	}

	public function GetTotal()
	{
		$data['santri'] = $this->DashboardModel->count_santri();
		$data['ustadz'] = $this->DashboardModel->count_ustadz();
		$data['wali_santri'] = $this->DashboardModel->count_wali_santri();
		$data['produk'] = $this->DashboardModel->count_produk();
		$data['invoice'] = $this->DashboardModel->count_invoice();

		echo json_encode($data);
	}
}
