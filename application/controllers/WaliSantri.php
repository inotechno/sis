<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WaliSantri extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('WaliSantriModel');
        $this->load->model('UserModel');
        $this->load->helper('upload');
        $this->load->library('pagination');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'master-data', 'sub_menu_active' => 'walisantri']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/walisantri',
            'plugin' => 'plugins/walisantri',
            'css' => 'css/walisantri',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $list = $this->WaliSantriModel->getOrangtua();

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ls) {
            if ($ls->jenis_kelamin == 'L') {
                $jk = 'Laki-laki';
            } else {
                $jk = 'Perempuan';
            }

            if (!empty($ls->images)) {
                $images = $ls->images;
            } else {
                $images = 'default.png';
            }

            if ($ls->phone == NULL) {
                $phone = '<span class="badge badge-secondary">Tidak ada</span>';
            } else {
                $phone = '<span class="badge badge-primary">' . $ls->phone . '</span>';
            }

            $row = array();
            $row[] = '<img class="rounded-circle img-fluid avatar-40" src="' . base_url('assets/images/user/' . $images) . '" alt="profile">';
            $row[] = $ls->name;
            $row[] = $ls->nik;
            $row[] = $ls->email;
            $row[] = $phone;
            $row[] = $ls->tempat_lahir;
            $row[] = date_indo(date('Y-m-d', strtotime($ls->tanggal_lahir)));
            $row[] = $jk;
            $row[] = ' <div class="flex align-items-center list-user-action">
                        <a data-id="' . $ls->id . '" class="iq-bg-warning btn-update" href="#" title="Edit"><i class="ri-pencil-line"></i></a>
                        <a data-id="' . $ls->id . '" class="iq-bg-danger btn-delete" href="#" title="Delete"><i class="ri-delete-bin-line"></i></a>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->WaliSantriModel->count_all(),
            "recordsFiltered" => $this->WaliSantriModel->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function all()
    {
        $data = $this->WaliSantriModel->all()->result();
        echo json_encode($data);
    }

    public function GetUserById($id)
    {
        $data = $this->WaliSantriModel->GetUserById(str_replace("'", "", htmlspecialchars($id, ENT_QUOTES)))->row();
        echo json_encode($data);
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'name', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[255]|is_unique[users.email]');
        $this->form_validation->set_rules('nik', 'nik', 'required|numeric');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');

        if ($this->form_validation->run() == true) {
            $user['name'] = str_replace("'", "", htmlspecialchars($this->input->post('name'), ENT_QUOTES));
            $user['email'] = str_replace("'", "", htmlspecialchars($this->input->post('email'), ENT_QUOTES));
            $user['password'] = password_hash(str_replace("'", "", htmlspecialchars($this->input->post('nik'), ENT_QUOTES)), PASSWORD_DEFAULT);
            $user['role_id'] = 4;
            $user['status'] = 1;

            if (!empty($_FILES['images']['name'])) {
                $images = h_upload(md5($user['email']), 'assets/images/user', 'gif|jpg|png|jpeg', '2048', 'images');

                if (!empty($images['success'])) {
                    $user['images'] = $images['success']['file_name'];
                }
            }

            $user = $this->UserModel->add($user);
            $last_id = $this->db->insert_id();

            if ($user) {
                log_activity('insert', 'tambah wali santri', 'tambah data wali santri pada halaman wali santri');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data user berhasil ditambah.'
                );

                $data['user_id'] = $last_id;
                $data['nik'] = str_replace("'", "", htmlspecialchars($this->input->post('nik'), ENT_QUOTES));
                $data['phone'] = str_replace("'", "", htmlspecialchars($this->input->post('phone'), ENT_QUOTES));
                $data['jenis_kelamin'] = str_replace("'", "", htmlspecialchars($this->input->post('jenis_kelamin'), ENT_QUOTES));
                $data['tempat_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tempat_lahir'), ENT_QUOTES));
                $data['tanggal_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tanggal_lahir'), ENT_QUOTES));

                $orangtua = $this->WaliSantriModel->add($data);

                if ($orangtua) {
                    $response = array(
                        'type' => 'success',
                        'title' => 'Berhasil !!!',
                        'message' => 'Data orang tua berhasil ditambah.'
                    );
                } else {
                    $response = array(
                        'type' => 'warning',
                        'title' => 'Gagal !!!',
                        'message' => 'Data orang tua gagal ditambah !'
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

    public function update()
    {
        $this->form_validation->set_rules('name', 'name', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('nik', 'nik', 'required|numeric');
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
                log_activity('update', 'update wali santri', 'update data wali santri pada halaman wali santri');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data user berhasil diubah.'
                );

                $data['nik'] = str_replace("'", "", htmlspecialchars($this->input->post('nik'), ENT_QUOTES));
                $data['jenis_kelamin'] = str_replace("'", "", htmlspecialchars($this->input->post('jenis_kelamin'), ENT_QUOTES));
                $data['phone'] = str_replace("'", "", htmlspecialchars($this->input->post('phone'), ENT_QUOTES));
                $data['tempat_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tempat_lahir'), ENT_QUOTES));
                $data['tanggal_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tanggal_lahir'), ENT_QUOTES));

                $orangtua = $this->WaliSantriModel->update($id, $data);

                if ($orangtua) {
                    $response = array(
                        'type' => 'success',
                        'title' => 'Berhasil !!!',
                        'message' => 'Data orang tua berhasil diubah.'
                    );
                } else {
                    $response = array(
                        'type' => 'warning',
                        'title' => 'Gagal !!!',
                        'message' => 'Data orang tua gagal diubah !'
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

    public function delete()
    {
        $id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));

        $delete = $this->UserModel->delete($id);
        if ($delete) {
            log_activity('delete', 'delete wali santri', 'delete data wali santri pada halaman wali santri');
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data orang tua berhasil diubah.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data orang tua gagal diubah !'
            );
        }

        echo json_encode($response);
    }
}
