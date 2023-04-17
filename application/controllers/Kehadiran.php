<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kehadiran extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('KehadiranModel');
		$this->load->model('SantriModel');
	}

	public function index()
	{
		$this->session->set_userdata(['menu_active' => 'kehadiran', 'sub_menu_active' => '']);
		$menu = $this->MenusModel->getMenu();

		$data = [
			'content' => 'components/kehadiran',
			'plugin' => 'plugins/kehadiran',
			'css' => 'css/kehadiran',
			'menus' => fetch_menu($menu)
		];

		$this->load->view('layouts/app', $data);
	}

	public function show()
	{
		$list = $this->KehadiranModel->getKehadiran();

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $ls) {
			$row = array();
			$row[] = $ls->nama_santri;
			$row[] = $ls->nama_kelas;
			$row[] = $ls->nama_mapel;
			$row[] = ucfirst($ls->hari) . ', ' . $ls->waktu_mulai;
			$row[] = date('d-m-Y H:i:s', strtotime($ls->created_at));

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->KehadiranModel->count_all(),
			"recordsFiltered" => $this->KehadiranModel->count_filtered(),
			"data" => $data
		);

		echo json_encode($output);
	}

	public function all()
	{
		$data = $this->KehadiranModel->all()->result();
		echo json_encode($data);
	}

	public function GetKehadiranById($id)
	{
		$data = $this->KehadiranModel->GetKehadiranById(str_replace("'", "", htmlspecialchars($id, ENT_QUOTES)))->row();
		echo json_encode($data);
	}

	public function add()
	{
		$tag_id = str_replace("'", "", htmlspecialchars($this->input->post('tag_id'), ENT_QUOTES));
		$att['jadwal_id'] = str_replace("'", "", htmlspecialchars($this->input->post('jadwal_id'), ENT_QUOTES));
		$att['status'] = str_replace("'", "", htmlspecialchars($this->input->post('status'), ENT_QUOTES));

		$santri = $this->SantriModel->GetSantriByTag(str_replace("'", "", htmlspecialchars($tag_id, ENT_QUOTES)));

		if ($santri->num_rows() > 0) {
			$data = $santri->row();
			$att['santri_id']	= $data->id_santri;
			$insert = $this->KehadiranModel->add($att);
			if ($insert) {
				log_activity('insert', 'tambah daftar kehadiran', 'tambah daftar kehadiran pada halaman kehadiran');
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Data kehadiran berhasil di tambah.'
				);
			} else {
				$response = array(
					'type' => 'error',
					'title' => 'Gagal !!!',
					'message' => 'Data kehadiran gagal di tambah.'
				);
			}
		} else {
			$response = array(
				'type' => 'error',
				'title' => 'Gagal !!!',
				'message' => 'Tag tidak ditemukan.'
			);
		}
		echo json_encode($response);
	}

	public function update()
	{
		$this->form_validation->set_rules('kelas_id', 'Kelas', 'required');
		$this->form_validation->set_rules('ustadz_id', 'Ustadz', 'required');
		$this->form_validation->set_rules('hari', 'Hari', 'required');
		$this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'required');
		$this->form_validation->set_rules('waktu_mulai', 'Waktu Mulai', 'required');

		if ($this->form_validation->run() == true) {
			$id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
			$data['mapel_id'] = str_replace("'", "", htmlspecialchars($this->input->post('mapel_id'), ENT_QUOTES));
			$data['ustadz_id'] = str_replace("'", "", htmlspecialchars($this->input->post('ustadz_id'), ENT_QUOTES));
			$data['kelas_id'] = str_replace("'", "", htmlspecialchars($this->input->post('kelas_id'), ENT_QUOTES));
			$data['hari'] = str_replace("'", "", htmlspecialchars($this->input->post('hari'), ENT_QUOTES));
			$data['waktu_mulai'] = str_replace("'", "", htmlspecialchars($this->input->post('waktu_mulai'), ENT_QUOTES));

			$kehadiran = $this->KehadiranModel->update($id, $data);

			if ($kehadiran) {
				log_activity('update', 'update kehadiran', 'update daftar kehadiran pada halaman kehadiran');
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Data kehadiran berhasil di ubah.'
				);
			} else {
				$response = array(
					'type' => 'warning',
					'title' => 'Gagal !!!',
					'message' => 'Data kehadiran gagal di ubah !'
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

		$delete = $this->KehadiranModel->delete($id);
		if ($delete) {
			log_activity('delete', 'delete kehadiran', 'delete daftar kehadiran pada halaman kehadiran');
			$response = array(
				'type' => 'success',
				'title' => 'Berhasil !!!',
				'message' => 'Data kehadiran berhasil di hapus.'
			);
		} else {
			$response = array(
				'type' => 'warning',
				'title' => 'Gagal !!!',
				'message' => 'Data kehadiran gagal di hapus !'
			);
		}

		echo json_encode($response);
	}
}
