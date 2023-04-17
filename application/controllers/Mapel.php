<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapel extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MapelModel');
	}

	public function index()
	{
		$this->session->set_userdata(['menu_active' => 'master-data', 'sub_menu_active' => 'mapel']);
		$menu = $this->MenusModel->getMenu();

		$data = [
			'content' => 'components/mapel',
			'plugin' => 'plugins/mapel',
			'css' => 'css/mapel',
			'menus' => fetch_menu($menu)
		];

		$this->load->view('layouts/app', $data);
	}

	public function show()
	{
		$list = $this->MapelModel->getMapel();

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $ls) {
			$row = array();
			$row[] = $ls->nama_mapel;
			$row[] = $ls->tingkat;
			$row[] = $ls->nilai_kkm;
			$row[] = date('d-m-Y H:i:s', strtotime($ls->created_at));
			$row[] = ' <div class="flex align-items-center list-mapel-action">
                        <a data-id="' . $ls->id . '" class="iq-bg-warning btn-update" href="#" title="Edit"><i class="ri-pencil-line"></i></a>
                        <a data-id="' . $ls->id . '" class="iq-bg-danger btn-delete" href="#" title="Delete"><i class="ri-delete-bin-line"></i></a>
                    </div>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->MapelModel->count_all(),
			"recordsFiltered" => $this->MapelModel->count_filtered(),
			"data" => $data
		);

		echo json_encode($output);
	}

	public function all()
	{
		$data = $this->MapelModel->all()->result();
		echo json_encode($data);
	}

	public function GetmapelById($id)
	{
		$data = $this->MapelModel->GetmapelById(str_replace("'", "", htmlspecialchars($id, ENT_QUOTES)))->row();
		echo json_encode($data);
	}

	public function GetMapelByWaliKelas()
	{
		$this->load->model('UstadzModel');
		$this->load->model('KelasModel');
		$this->load->model('JadwalModel');
		$ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
		$where['wali_kelas_id'] = $ustadz->id_ustadz;
		$kelas = $this->KelasModel->all($where)->result();

		// echo '<pre>' . print_r($kelas, 1) . '</pre>';
		// die;

		$data = array();
		foreach ($kelas as $k) {
			$data['mapel'] = $this->JadwalModel->GetMapelByWaliKelas($k->wali_kelas_id)->result();
		}
		echo json_encode($data);
	}

	public function add()
	{
		$this->form_validation->set_rules('nama_mapel', 'Nama mapel', 'required|min_length[1]|max_length[255]');
		$this->form_validation->set_rules('tingkat', 'Tingkat', 'required|numeric');

		if ($this->form_validation->run() == true) {
			$data['nama_mapel'] = str_replace("'", "", htmlspecialchars($this->input->post('nama_mapel'), ENT_QUOTES));
			$data['tingkat'] = str_replace("'", "", htmlspecialchars($this->input->post('tingkat'), ENT_QUOTES));
			$data['nilai_kkm'] = str_replace("'", "", htmlspecialchars($this->input->post('nilai_kkm'), ENT_QUOTES));

			$data['slug_mapel'] = implode("-", explode(" ", trim(strtolower($this->input->post('nama_mapel')))));

			$mapel = $this->MapelModel->add($data);

			if ($mapel) {
				log_activity('insert', 'tambah mata pelajaran', 'tambah data mata pelajaran pada halaman mapel');
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Data mapel berhasil ditambah.'
				);
			} else {
				$response = array(
					'type' => 'warning',
					'title' => 'Gagal !!!',
					'message' => 'Data mapel gagal ditambah !'
				);
			}
		} else {
			$response = array(
				'type' => 'error',
				'title' => 'Gagal !!!',
				'message' => validation_errors(),
			);
		}

		echo json_encode($response);
	}

	public function update()
	{
		$this->form_validation->set_rules('nama_mapel', 'Nama mapel', 'required|min_length[1]|max_length[255]');
		$this->form_validation->set_rules('tingkat', 'Tingkat', 'required|numeric');

		if ($this->form_validation->run() == true) {
			$id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
			$data['nama_mapel'] = str_replace("'", "", htmlspecialchars($this->input->post('nama_mapel'), ENT_QUOTES));
			$data['tingkat'] = str_replace("'", "", htmlspecialchars($this->input->post('tingkat'), ENT_QUOTES));

			$data['slug_mapel'] = implode("-", explode(" ", trim(strtolower($this->input->post('nama_mapel')))));

			$mapel = $this->MapelModel->update($id, $data);

			if ($mapel) {
				log_activity('update', 'update mata pelajaran', 'update data mata pelajaran pada halaman mapel');
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Data mapel berhasil diubah.'
				);
			} else {
				$response = array(
					'type' => 'warning',
					'title' => 'Gagal !!!',
					'message' => 'Data mapel gagal ditambah !'
				);
			}
		} else {
			$response = array(
				'type' => 'error',
				'title' => 'Gagal !!!',
				'message' => validation_errors(),
			);
		}

		echo json_encode($response);
	}

	public function delete()
	{
		$id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));

		$delete = $this->MapelModel->delete($id);
		if ($delete) {
			log_activity('delete', 'delete mata pelajaran', 'delete data mata pelajaran pada halaman mapel');
			$response = array(
				'type' => 'success',
				'title' => 'Berhasil !!!',
				'message' => 'Data mapel berhasil diubah.'
			);
		} else {
			$response = array(
				'type' => 'warning',
				'title' => 'Gagal !!!',
				'message' => 'Data mapel gagal diubah !'
			);
		}

		echo json_encode($response);
	}
}
