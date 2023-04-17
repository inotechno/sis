<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('KehadiranModel');
	}

	public function index()
	{
		$this->session->set_userdata(['menu_active' => 'absensi-us', 'sub_menu_active' => '']);
		$menu = $this->MenusModel->getMenu();

		$data = [
			'content' => 'components/ustadz/absensi',
			'plugin' => 'plugins/ustadz/absensi',
			'css' => 'css/absensi',
			'menus' => fetch_menu($menu)
		];

		$this->load->view('layouts/app', $data);
	}

	public function show()
	{
		$this->load->model('JadwalModel');
		$this->load->model('UstadzModel');
		$this->load->helper('hari');

		$ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
		$jadwal = $this->JadwalModel->GetJadwalWaktuIni(strtolower(hari_ini()), $ustadz->id_ustadz);

		// echo '<pre>' . print_r($jadwal, 1) . '</pre>';
		// die;

		if ($jadwal->num_rows() > 0) {
			$jdwl = $jadwal->row();
			$list = $this->KehadiranModel->getKehadiranByJadwal($jdwl->id);

			$data = array();
			$no = $_POST['start'];

			foreach ($list as $ls) {
				$row = array();
				$row[] = $ls->nis;
				$row[] = $ls->nama_santri;
				$row[] = date('d-m-Y H:i:s', strtotime($ls->created_at));
				$row[] = ucfirst($ls->status);

				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->KehadiranModel->count_all(),
				"recordsFiltered" => $this->KehadiranModel->count_filtered(),
				"data" => $data
			);
		} else {
			$output = array();
		}

		echo json_encode($output);
	}

	public function GetJadwalWaktuIni()
	{
		$this->load->model('JadwalModel');
		$this->load->model('UstadzModel');
		$this->load->helper('hari');

		$data = array();
		$ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
		$jadwal = $this->JadwalModel->GetJadwalWaktuIni(strtolower(hari_ini()), $ustadz->id_ustadz);

		// echo $this->db->last_query($jadwal);
		// die;
		if ($jadwal->num_rows() > 0) {
			$jdwl = $jadwal->row();
			$list = $this->KehadiranModel->_getKehadiranByJadwal($jdwl->id);

			$data['status'] = 'success';
			$data['jadwal'] = $jdwl;
			$data['jumlah_santri'] = $list->num_rows();
		} else {
			$data = array('status' => 'error', 'message' => 'Tidak ada data !');
		}

		echo json_encode($data);
	}
}
