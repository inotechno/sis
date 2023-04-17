<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ustadz extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UstadzModel');
        $this->load->model('UserModel');
        $this->load->library('pagination');
        $this->load->helper('upload');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'master-data', 'sub_menu_active' => 'ustadz']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/ustadz',
            'plugin' => 'plugins/ustadz',
            'css' => 'css/ustadz',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $list = $this->UstadzModel->getUstadz();

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ls) {
            if ($ls->jenis_kelamin == 'L') {
                $jk = 'Laki-laki';
            } else {
                $jk = 'Perempuan';
            }

            if ($ls->phone == NULL) {
                $phone = '<span class="badge badge-secondary">Tidak ada</span>';
            } else {
                $phone = '<span class="badge badge-primary">' . $ls->phone . '</span>';
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
            $row[] = $ls->name;
            $row[] = $ls->nik;
            $row[] = $ls->email;
            $row[] = $phone;
            $row[] = $ls->tempat_lahir . ', ' . date_indo(date('Y-m-d', strtotime($ls->tanggal_lahir)));
            $row[] = $jk;
            $row[] = ' <div class="flex align-items-center list-user-action">
                        <a data-id="' . $ls->id . '" class="iq-bg-warning btn-update" href="#" title="Edit"><i class="ri-pencil-line"></i></a>
                        <a data-id="' . $ls->id . '" class="iq-bg-danger btn-delete" href="#" title="Delete"><i class="ri-delete-bin-line"></i></a>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->UstadzModel->count_all(),
            "recordsFiltered" => $this->UstadzModel->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function all()
    {
        $data = $this->UstadzModel->all()->result();
        echo json_encode($data);
    }

    public function GetUserById($id)
    {
        $data = $this->UstadzModel->GetUserById(str_replace("'", "", htmlspecialchars($id, ENT_QUOTES)))->row();
        echo json_encode($data);
    }

    public function GetTagLastTime()
    {
        $this->load->model('TagModel');
        $data = $this->TagModel->GetTagLastTime()->row();
        echo json_encode($data);
    }


    public function addTag()
    {
        $this->load->model('TagModel');
        $id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
        $data['tag_id'] = str_replace("'", "", htmlspecialchars($this->input->post('tag_id'), ENT_QUOTES));

        $tag['in_use'] = 1;
        $tags = $this->TagModel->update($data['tag_id'], $tag);

        $santri = $this->UstadzModel->update($id, $data);

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

        echo json_encode($response);
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'name', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[255]|is_unique[users.email]');
        $this->form_validation->set_rules('nik', 'nik', 'required|numeric');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|numeric');

        if ($this->form_validation->run() == true) {
            $user['name'] = str_replace("'", "", htmlspecialchars($this->input->post('name'), ENT_QUOTES));
            $user['email'] = str_replace("'", "", htmlspecialchars($this->input->post('email'), ENT_QUOTES));
            $user['password'] = password_hash(str_replace("'", "", htmlspecialchars($this->input->post('nik'), ENT_QUOTES)), PASSWORD_DEFAULT);
            $user['role_id'] = 5;
            $user['status'] = 1;

            if (!empty($_FILES['images']['name'])) {
                $images = h_upload(md5($user['email']), 'assets/images/user', 'gif|jpg|png|jpeg', '1024', 'images');

                if (!empty($images['success'])) {
                    $user['images'] = $images['success']['file_name'];
                }
            }

            $user = $this->UserModel->add($user);
            $last_id = $this->db->insert_id();

            if ($user) {
                log_activity('insert', 'tambah ustadz', 'tambah data ustadz pada halaman ustadz');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data user berhasil ditambah.'
                );

                $data['user_id'] = $last_id;
                $data['phone'] = str_replace("'", "", htmlspecialchars($this->input->post('phone'), ENT_QUOTES));
                $data['nik'] = str_replace("'", "", htmlspecialchars($this->input->post('nik'), ENT_QUOTES));
                $data['nip'] = str_replace("'", "", htmlspecialchars($this->input->post('nip'), ENT_QUOTES));
                $data['jenis_kelamin'] = str_replace("'", "", htmlspecialchars($this->input->post('jenis_kelamin'), ENT_QUOTES));
                $data['tempat_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tempat_lahir'), ENT_QUOTES));
                $data['tanggal_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tanggal_lahir'), ENT_QUOTES));

                $ustadz = $this->UstadzModel->add($data);

                if ($ustadz) {
                    $response = array(
                        'type' => 'success',
                        'title' => 'Berhasil !!!',
                        'message' => 'Data ustadz berhasil ditambah.'
                    );
                } else {
                    $response = array(
                        'type' => 'warning',
                        'title' => 'Gagal !!!',
                        'message' => 'Data ustadz gagal ditambah !'
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
        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|numeric');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|numeric');

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
                log_activity('update', 'update ustadz', 'update data ustadz pada halaman ustadz');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data user berhasil diubah.'
                );

                $data['nik'] = str_replace("'", "", htmlspecialchars($this->input->post('nik'), ENT_QUOTES));
                $data['phone'] = str_replace("'", "", htmlspecialchars($this->input->post('phone'), ENT_QUOTES));
                $data['nip'] = str_replace("'", "", htmlspecialchars($this->input->post('nip'), ENT_QUOTES));
                $data['jenis_kelamin'] = str_replace("'", "", htmlspecialchars($this->input->post('jenis_kelamin'), ENT_QUOTES));
                $data['tempat_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tempat_lahir'), ENT_QUOTES));
                $data['tanggal_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tanggal_lahir'), ENT_QUOTES));

                $ustadz = $this->UstadzModel->update($id, $data);

                if ($ustadz) {
                    $response = array(
                        'type' => 'success',
                        'title' => 'Berhasil !!!',
                        'message' => 'Data ustadz berhasil diubah.'
                    );
                } else {
                    $response = array(
                        'type' => 'warning',
                        'title' => 'Gagal !!!',
                        'message' => 'Data ustadz gagal diubah !'
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
            log_activity('delete', 'delete ustadz', 'delete data ustadz pada halaman ustadz');
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data ustadz berhasil diubah.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data ustadz gagal diubah !'
            );
        }

        echo json_encode($response);
    }
}
