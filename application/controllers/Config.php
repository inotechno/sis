<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Config extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ConfigModel');
        $this->load->helper('upload');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'config', 'sub_menu_active' => '']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/config',
            'plugin' => 'plugins/config',
            'css' => 'css/config',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function update()
    {
        $this->form_validation->set_rules('APP_NAME', 'APP Name', 'required');
        $this->form_validation->set_rules('SHORT_APP_NAME', 'SHORT APP NAME', 'required');
        $this->form_validation->set_rules('NAMA_PESANTREN', 'Nama Pesantren', 'required');
        $this->form_validation->set_rules('PHONE', 'Phone', 'required');
        $this->form_validation->set_rules('ALAMAT', 'Alamat', 'required|min_length[10]');
        $this->form_validation->set_rules('VISI', 'Visi', 'required|min_length[10]');
        $this->form_validation->set_rules('MISI', 'Misi', 'required|min_length[10]');
        $this->form_validation->set_rules('NAMA_PENDIRI', 'Nama Pendiri', 'required');
        $this->form_validation->set_rules('NOMOR_SK', 'Nomor SK', 'required');
        $this->form_validation->set_rules('NPWP', 'NPWP', 'required');
        $this->form_validation->set_rules('EMAIL', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == true) {
            $data['APP_NAME'] = str_replace("'", "", htmlspecialchars($this->input->post('APP_NAME'), ENT_QUOTES));
            $data['SHORT_APP_NAME'] = str_replace("'", "", htmlspecialchars($this->input->post('SHORT_APP_NAME'), ENT_QUOTES));
            $data['NAMA_PESANTREN'] = str_replace("'", "", htmlspecialchars($this->input->post('NAMA_PESANTREN'), ENT_QUOTES));
            $data['PHONE'] = str_replace("'", "", htmlspecialchars($this->input->post('PHONE'), ENT_QUOTES));
            $data['ALAMAT'] = str_replace("'", "", htmlspecialchars($this->input->post('ALAMAT'), ENT_QUOTES));
            $data['VISI'] = str_replace("'", "", htmlspecialchars($this->input->post('VISI'), ENT_QUOTES));
            $data['MISI'] = str_replace("'", "", htmlspecialchars($this->input->post('MISI'), ENT_QUOTES));
            $data['NAMA_PENDIRI'] = str_replace("'", "", htmlspecialchars($this->input->post('NAMA_PENDIRI'), ENT_QUOTES));
            $data['NOMOR_SK'] = str_replace("'", "", htmlspecialchars($this->input->post('NOMOR_SK'), ENT_QUOTES));
            $data['NPWP'] = str_replace("'", "", htmlspecialchars($this->input->post('NPWP'), ENT_QUOTES));
            $data['EMAIL'] = str_replace("'", "", htmlspecialchars($this->input->post('EMAIL'), ENT_QUOTES));
            $data['XENDIT_KEY'] = str_replace("'", "", htmlspecialchars($this->input->post('XENDIT_KEY'), ENT_QUOTES));
            $data['XENDIT_PUBLIC_KEY'] = str_replace("'", "", htmlspecialchars($this->input->post('XENDIT_PUBLIC_KEY'), ENT_QUOTES));
            $data['XENDIT_CALLBACK_TOKEN'] = str_replace("'", "", htmlspecialchars($this->input->post('XENDIT_CALLBACK_TOKEN'), ENT_QUOTES));

            if (!empty($_FILES['LOGO_FULL']['name'])) {
                $logo_full = h_upload('logo-full', 'assets/images', 'gif|jpg|png|jpeg', '1024', 'LOGO_FULL');

                if (!empty($logo_full['success'])) {
                    $data['LOGO_FULL'] = $logo_full['success']['file_name'];
                } else {
                    $response = array(
                        'type' => 'warning',
                        'title' => 'Gagal !!!',
                        'message' => 'File gagal di upload, silahkan coba lagi !'
                    );
                }
            }

            if (!empty($_FILES['LOGO_MINI']['name'])) {
                $logo_mini = h_upload('logo-mini', 'assets/images', 'gif|jpg|png|jpeg', '1024', 'LOGO_MINI');

                if (!empty($logo_mini['success'])) {
                    $data['LOGO_MINI'] = $logo_mini['success']['file_name'];
                } else {
                    $response = array(
                        'type' => 'warning',
                        'title' => 'Gagal !!!',
                        'message' => 'File gagal di upload, silahkan coba lagi !'
                    );
                }
            }

            $konfigurasi = $this->ConfigModel->update($data);
            // $logo_full = h_upload('logo-full', 'assets/images/', 'gif|jpg|png|jpeg', '1024', 'LOGO_FULL');

            // var_dump($logo_full);
            // die;

            if ($konfigurasi) {
                log_activity('update', 'update konfigurasi', 'update data konfigurasi pada halaman konfigurasi');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data konfigurasi berhasil di ubah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data konfigurasi gagal di ubah !'
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
