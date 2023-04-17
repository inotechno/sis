<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('JadwalModel');
	}

	public function index()
	{
		$this->session->set_userdata(['menu_active' => 'jadwal-us', 'sub_menu_active' => '']);
		$menu = $this->MenusModel->getMenu();

		$data = [
			'content' => 'components/ustadz/jadwal',
			'plugin' => 'plugins/ustadz/jadwal',
			'css' => 'css/jadwal',
			'menus' => fetch_menu($menu)
		];

		$this->load->view('layouts/app', $data);
	}

	public function show()
	{
		$this->load->model('UstadzModel');
		$ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
		$where['ustadz_id'] = $ustadz->id_ustadz;

		$list = $this->JadwalModel->getJadwal($where);

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $ls) {
			$row = array();
			$row[] = $ls->nama_kelas;
			$row[] = $ls->nama_mapel;
			$row[] = ucfirst($ls->hari) . ', ' . $ls->waktu_mulai;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->JadwalModel->count_all(),
			"recordsFiltered" => $this->JadwalModel->count_filtered(),
			"data" => $data
		);

		echo json_encode($output);
	}

	public function all()
	{
		$data = $this->JadwalModel->all()->result();
		echo json_encode($data);
	}

	public function GetjadwalById($id)
	{
		$data = $this->JadwalModel->GetJadwalById(str_replace("'", "", htmlspecialchars($id, ENT_QUOTES)))->row();
		echo json_encode($data);
	}

	public function GetJadwalByKelas($id_kelas)
	{
		$data = $this->JadwalModel->GetJadwalByKelas(str_replace("'", "", htmlspecialchars($id_kelas, ENT_QUOTES)))->result();
		echo json_encode($data);
	}
}
