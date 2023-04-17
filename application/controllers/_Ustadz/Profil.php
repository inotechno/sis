<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->helper('upload');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'profil-us', 'sub_menu_active' => '']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/ustadz/profil',
            'plugin' => 'plugins/ustadz/profil',
            'css' => 'css/profil',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function GetProfil()
    {
        $data = $this->UserModel->GetProfil('ustadz', ['u.id' => $this->session->userdata('id')])->row();
        echo json_encode($data);
    }

    public function UpdateProfil()
    {
        $this->load->model('UstadzModel');

        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[1]|max_length[255]');

        if ($this->form_validation->run() == true) {
            $id =  $this->session->userdata('id');
            $user['name'] = str_replace("'", "", htmlspecialchars($this->input->post('name'), ENT_QUOTES));
            $user['email'] = str_replace("'", "", htmlspecialchars($this->input->post('email'), ENT_QUOTES));

            $data['jenis_kelamin'] = str_replace("'", "", htmlspecialchars($this->input->post('jenis_kelamin'), ENT_QUOTES));
            $data['tempat_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tempat_lahir'), ENT_QUOTES));
            $data['tanggal_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tanggal_lahir'), ENT_QUOTES));
            $data['phone'] = str_replace("'", "", htmlspecialchars($this->input->post('phone'), ENT_QUOTES));
            $data['nik'] = str_replace("'", "", htmlspecialchars($this->input->post('nik'), ENT_QUOTES));
            $data['nip'] = str_replace("'", "", htmlspecialchars($this->input->post('nip'), ENT_QUOTES));

            if (!empty($_FILES['images']['name'])) {
                $images = h_upload(md5($user['email']), 'assets/images/user', 'gif|jpg|png|jpeg', '1024', 'images');

                if (!empty($images['success'])) {
                    $user['images'] = $images['success']['file_name'];
                }
            }

            $user = $this->UserModel->update($id, $user);
            $user = $this->UstadzModel->update($id, $data);

            if ($user) {
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data profil berhasil di ubah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data profil gagal di ubah !'
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
}
