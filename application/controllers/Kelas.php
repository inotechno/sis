<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KelasModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'master-data', 'sub_menu_active' => 'kelas']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/kelas',
            'plugin' => 'plugins/kelas',
            'css' => 'css/kelas',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $list = $this->KelasModel->getKelas();

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ls) {
            $row = array();
            $row[] = $ls->nama_kelas;
            $row[] = $ls->tingkat;
            $row[] = $ls->tahun_ajaran;
            $row[] = $ls->wali_kelas;
            $row[] = ' <div class="flex align-items-center list-kelas-action">
                        <a data-id="' . $ls->id . '" class="iq-bg-warning btn-update" href="#" title="Edit"><i class="ri-pencil-line"></i></a>
                        <a data-id="' . $ls->id . '" class="iq-bg-danger btn-delete" href="#" title="Delete"><i class="ri-delete-bin-line"></i></a>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->KelasModel->count_all(),
            "recordsFiltered" => $this->KelasModel->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function all()
    {
        $data = $this->KelasModel->all()->result();
        echo json_encode($data);
    }

    public function GetKelasById($id)
    {
        $data = $this->KelasModel->GetKelasById(str_replace("'", "", htmlspecialchars($id, ENT_QUOTES)))->row();
        echo json_encode($data);
    }

    public function add()
    {
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('tingkat', 'Tingkat', 'required|numeric');
        $this->form_validation->set_rules('tahun_ajaran_id', 'Tahun Ajaran', 'required');
        $this->form_validation->set_rules('wali_kelas_id', 'Wali Kelas', 'required');

        if ($this->form_validation->run() == true) {
            $data['nama_kelas'] = str_replace("'", "", htmlspecialchars($this->input->post('nama_kelas'), ENT_QUOTES));
            $data['tingkat'] = str_replace("'", "", htmlspecialchars($this->input->post('tingkat'), ENT_QUOTES));
            $data['tahun_ajaran_id'] = str_replace("'", "", htmlspecialchars($this->input->post('tahun_ajaran_id'), ENT_QUOTES));
            $data['wali_kelas_id'] = str_replace("'", "", htmlspecialchars($this->input->post('wali_kelas_id'), ENT_QUOTES));

            $data['slug'] = implode("-", explode(" ", trim(strtolower($this->input->post('nama_kelas')))));

            $kelas = $this->KelasModel->add($data);

            if ($kelas) {
                log_activity('insert', 'tambah kelas', 'tambah data kelas pada halaman kelas');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data kelas berhasil ditambah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data kelas gagal ditambah !'
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
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('tingkat', 'Tingkat', 'required|numeric');
        $this->form_validation->set_rules('tahun_ajaran_id', 'Tahun Ajaran', 'required');
        $this->form_validation->set_rules('wali_kelas_id', 'Wali Kelas', 'required');

        if ($this->form_validation->run() == true) {
            $id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
            $data['nama_kelas'] = str_replace("'", "", htmlspecialchars($this->input->post('nama_kelas'), ENT_QUOTES));
            $data['tingkat'] = str_replace("'", "", htmlspecialchars($this->input->post('tingkat'), ENT_QUOTES));
            $data['tahun_ajaran_id'] = str_replace("'", "", htmlspecialchars($this->input->post('tahun_ajaran_id'), ENT_QUOTES));
            $data['wali_kelas_id'] = str_replace("'", "", htmlspecialchars($this->input->post('wali_kelas_id'), ENT_QUOTES));

            $data['slug'] = implode("-", explode(" ", trim(strtolower($this->input->post('nama_kelas')))));

            $kelas = $this->KelasModel->update($id, $data);

            if ($kelas) {
                log_activity('update', 'update kelas', 'update data kelas pada halaman kelas');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data kelas berhasil diubah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data kelas gagal ditambah !'
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

        $delete = $this->KelasModel->delete($id);
        if ($delete) {
            log_activity('delete', 'delete kelas', 'delete data kelas pada halaman kelas');
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data kelas berhasil diubah.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data kelas gagal diubah !'
            );
        }

        echo json_encode($response);
    }
}
