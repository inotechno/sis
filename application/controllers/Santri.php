<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Santri extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('SantriModel');
		$this->load->model('WaliSantriModel');
		$this->load->model('UserModel');
		$this->load->model('TagModel');
		$this->load->helper('upload');
		$this->load->library('pagination');
	}

	public function index()
	{
		$this->session->set_userdata(['menu_active' => 'master-data', 'sub_menu_active' => 'santri']);
		$menu = $this->MenusModel->getMenu();

		$data = [
			'content' => 'components/santri',
			'plugin' => 'plugins/santri',
			'css' => 'css/santri',
			'menus' => fetch_menu($menu)
		];

		$this->load->view('layouts/app', $data);
	}

	public function show()
	{
		$list = $this->SantriModel->getSantri();

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $ls) {
			if ($ls->jenis_kelamin == 'L') {
				$jk = 'Laki-laki';
			} else {
				$jk = 'Perempuan';
			}

			if ($ls->tag_id == NULL) {
				$tag = '<div class="flex align-items-center list-user-action">
                        <span class="badge badge-danger">Not Found </span><a data-id="' . $ls->id . '" href="#" class="btn-add-tag ri-add-box-fill"></a>
                        </div>';
			} else {
				$tag = '<span class="badge iq-primary">' . $ls->tag_id . '</span>';
			}

			if (!empty($ls->images)) {
				$images = $ls->images;
			} else {
				$images = 'default.png';
			}

			$row = array();
			$row[] = '<img class="rounded-circle img-fluid avatar-40" src="' . base_url('assets/images/user/' . $images) . '" alt="profile">';
			$row[] = $tag;
			$row[] = $ls->nis;
			$row[] = $ls->name;
			$row[] = $ls->tempat_lahir . ', ' . date_indo(date('Y-m-d', strtotime($ls->tanggal_lahir)));
			$row[] = $jk;
			$row[] = 'Rp. ' . number_format($ls->saldo) . ' <a href="#" class="btn-add-balance" data-id="' . $ls->id_santri . '"><i class="ri-add-box-fill"></i></a>';
			$row[] = ' <div class="flex align-items-center list-user-action">
                        <a data-id="' . $ls->id . '" class="iq-bg-primary btn-wali-santri" href="#" title="Orang Tua"><i class="ri-parent-line"></i></a>
                        <a data-id="' . $ls->id . '" class="iq-bg-warning btn-update" href="#" title="Edit"><i class="ri-pencil-line"></i></a>
                        <a data-id="' . $ls->id . '" class="iq-bg-danger btn-delete" href="#" title="Delete"><i class="ri-delete-bin-line"></i></a>
                    </div>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->SantriModel->count_all(),
			"recordsFiltered" => $this->SantriModel->count_filtered(),
			"data" => $data
		);

		echo json_encode($output);
	}

	public function GetUserById($id)
	{
		$data = $this->SantriModel->GetUserById(str_replace("'", "", htmlspecialchars($id, ENT_QUOTES)))->row();
		echo json_encode($data);
	}

	public function GetSantriByNIS($nis)
	{
		$data = $this->SantriModel->GetSantriByNIS(str_replace("'", "", htmlspecialchars($nis, ENT_QUOTES)))->row();
		echo json_encode($data);
	}

	public function GetSantriByTag($tag_id)
	{
		$data = $this->SantriModel->GetSantriByTag(str_replace("'", "", htmlspecialchars($tag_id, ENT_QUOTES)))->row();
		echo json_encode($data);
	}

	public function GetTagLastTime()
	{
		$data = $this->TagModel->GetTagLastTime()->row();
		echo json_encode($data);
	}

	public function add()
	{
		$this->form_validation->set_rules('name', 'name', 'required|min_length[1]|max_length[255]');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[255]|is_unique[users.email]');
		$this->form_validation->set_rules('nis', 'nis', 'required|numeric');
		$this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');

		if ($this->form_validation->run() == true) {
			$user['name'] = str_replace("'", "", htmlspecialchars($this->input->post('name'), ENT_QUOTES));
			$user['email'] = str_replace("'", "", htmlspecialchars($this->input->post('email'), ENT_QUOTES));
			$user['password'] = password_hash(str_replace("'", "", htmlspecialchars($this->input->post('nis'), ENT_QUOTES)), PASSWORD_DEFAULT);
			$user['role_id'] = 3;
			$user['status'] = 0;

			if (!empty($_FILES['images']['name'])) {
				$images = h_upload(md5($user['email']), 'assets/images/user', 'gif|jpg|png|jpeg', '2048', 'images');

				if (!empty($images['success'])) {
					$user['images'] = $images['success']['file_name'];
				}
			}

			$user = $this->UserModel->add($user);
			$last_id = $this->db->insert_id();

			if ($user) {
				log_activity('insert', 'tambah santri', 'tambah data santri pada halaman santri');
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Data user berhasil ditambah.'
				);

				$data['user_id'] = $last_id;
				$data['nis'] = str_replace("'", "", htmlspecialchars($this->input->post('nis'), ENT_QUOTES));
				$data['jenis_kelamin'] = str_replace("'", "", htmlspecialchars($this->input->post('jenis_kelamin'), ENT_QUOTES));
				$data['tempat_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tempat_lahir'), ENT_QUOTES));
				$data['tanggal_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tanggal_lahir'), ENT_QUOTES));

				$santri = $this->SantriModel->add($data);

				if ($santri) {
					$response = array(
						'type' => 'success',
						'title' => 'Berhasil !!!',
						'message' => 'Data santri berhasil ditambah.'
					);
				} else {
					$response = array(
						'type' => 'warning',
						'title' => 'Gagal !!!',
						'message' => 'Data santri gagal ditambah !'
					);
				}
			} else {
				$response = array(
					'type' => 'warning',
					'title' => 'Gagal !!!',
					'message' => 'Data user gagal ditambah !'
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

	public function addTag()
	{
		$id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
		$data['tag_id'] = str_replace("'", "", htmlspecialchars($this->input->post('tag_id'), ENT_QUOTES));

		// echo '<pre>' . print_r($this->TagModel->check_duplicate($data['tag_id'])->num_rows(), 1) . '</pre>';
		// die;

		if ($this->SantriModel->check_duplicate_tag($data['tag_id'])->num_rows() > 0) {
			$response = array(
				'type' => 'error',
				'title' => 'Gagal !!!',
				'message' => 'Tag gagal ditambahkan, Duplicate Tag !'
			);
		} else {
			// $tags = $this->TagModel->update($data['tag_id'], $tag);
			$santri = $this->SantriModel->update($id, $data);

			if ($santri) {
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Tag berhasil ditambahkan.'
				);
			} else {
				$response = array(
					'type' => 'warning',
					'title' => 'Gagal !!!',
					'message' => 'Tag gagal ditambahkan, silahkan coba kembali !'
				);
			}
		}

		echo json_encode($response);
	}

	public function update()
	{
		$this->form_validation->set_rules('name', 'name', 'required|min_length[1]|max_length[255]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[1]|max_length[255]');
		$this->form_validation->set_rules('nis', 'nis', 'required|numeric');
		$this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');

		if ($this->form_validation->run() == true) {
			$id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
			$user['name'] = str_replace("'", "", htmlspecialchars($this->input->post('name'), ENT_QUOTES));
			$user['email'] = str_replace("'", "", htmlspecialchars($this->input->post('email'), ENT_QUOTES));

			if (!empty($_FILES['images']['name'])) {
				$images = h_upload(md5($user['email']), 'assets/images/user', 'gif|jpg|png|jpeg', '2048', 'images');

				if (!empty($images['success'])) {
					$user['images'] = $images['success']['file_name'];
				}
			}

			$user = $this->UserModel->update($id, $user);

			if ($user) {
				log_activity('update', 'update santri', 'update data santri pada halaman santri');
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Data user berhasil diubah.'
				);

				$data['nis'] = str_replace("'", "", htmlspecialchars($this->input->post('nis'), ENT_QUOTES));
				$data['jenis_kelamin'] = str_replace("'", "", htmlspecialchars($this->input->post('jenis_kelamin'), ENT_QUOTES));
				$data['tempat_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tempat_lahir'), ENT_QUOTES));
				$data['tanggal_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tanggal_lahir'), ENT_QUOTES));

				$santri = $this->SantriModel->update($id, $data);

				if ($santri) {
					$response = array(
						'type' => 'success',
						'title' => 'Berhasil !!!',
						'message' => 'Data santri berhasil diubah.'
					);
				} else {
					$response = array(
						'type' => 'warning',
						'title' => 'Gagal !!!',
						'message' => 'Data santri gagal diubah !'
					);
				}
			} else {
				$response = array(
					'type' => 'warning',
					'title' => 'Gagal !!!',
					'message' => 'Data user gagal ditambah !'
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

	public function addBalance()
	{
		$this->form_validation->set_rules('saldo', 'saldo', 'required|numeric');

		if ($this->form_validation->run() == true) {
			$id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));

			$saldo_awal = $this->SantriModel->GetUserById($id)->row('saldo');

			$data['saldo'] = $saldo_awal + str_replace("'", "", htmlspecialchars($this->input->post('saldo'), ENT_QUOTES));


			$santri = $this->SantriModel->update($id, $data);

			if ($santri) {
				$response = array(
					'type' => 'success',
					'title' => 'Berhasil !!!',
					'message' => 'Saldo berhasil ditambah !'
				);
			} else {
				$response = array(
					'type' => 'warning',
					'title' => 'Gagal !!!',
					'message' => 'Gagal menambahkan saldo, silahkan coba kembali !'
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

	public function update_walisantri()
	{
		$id = str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
		$data['wali_id'] = str_replace("'", "", htmlspecialchars($this->input->post('wali_id'), ENT_QUOTES));

		$santri = $this->SantriModel->update($id, $data);

		if ($santri) {
			$response = array(
				'type' => 'success',
				'title' => 'Berhasil !!!',
				'message' => 'Data wali santri berhasil disimpan !.'
			);
		} else {
			$response = array(
				'type' => 'warning',
				'title' => 'Gagal !!!',
				'message' => 'Data wali santri berhasil disimpan ! !'
			);
		}

		echo json_encode($response);
	}

	public function delete()
	{
		$id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));

		$delete = $this->UserModel->delete($id);
		if ($delete) {
			log_activity('delete', 'delete santri', 'delete data santri pada halaman santri');
			$response = array(
				'type' => 'success',
				'title' => 'Berhasil !!!',
				'message' => 'Data santri berhasil diubah.'
			);
		} else {
			$response = array(
				'type' => 'warning',
				'title' => 'Gagal !!!',
				'message' => 'Data santri gagal diubah !'
			);
		}

		echo json_encode($response);
	}
}
