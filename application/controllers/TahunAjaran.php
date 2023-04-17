<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TahunAjaran extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TahunAjaranModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'master-data', 'sub_menu_active' => 'tahun_ajaran']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/tahun_ajaran',
            'plugin' => 'plugins/tahun_ajaran',
            'css' => 'css/tahun_ajaran',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $list = $this->TahunAjaranModel->getTahunAjaran();

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ls) {
            if ($ls->status == 1) {
                $checked = 'checked=""';
            } else {
                $checked = '';
            }

            $row = array();
            $row[] = $ls->tahun_ajaran;
            $row[] = ucfirst($ls->semester);
            $row[] = '<div class="custom-control custom-switch custom-switch-text custom-control-inline">
                            <div class="custom-switch-inner">
                                <input type="checkbox" value="' . $ls->id . '" class="custom-control-input update-status-ta" ' . $checked . ' id="tahun_ajaran' . $ls->id . '">
                                <label class="custom-control-label" data-on-label="On" data-off-label="Off" for="tahun_ajaran' . $ls->id . '">
                                </label>
                            </div>
                        </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->TahunAjaranModel->count_all(),
            "recordsFiltered" => $this->TahunAjaranModel->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function all()
    {
        $data = $this->TahunAjaranModel->getAll()->result();
        echo json_encode($data);
    }

    public function updateStatus()
    {
        $id = str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
        $non_aktif = $this->TahunAjaranModel->NonAktif();

        if ($non_aktif) {
            $data['status'] = 1;
            $act = $this->TahunAjaranModel->update($id, $data);
            if ($act) {
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data tahun ajaran berhasil aktif.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data tahun ajaran gagal aktif !'
                );
            }
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data tahun ajaran gagal aktif !'
            );
        }

        echo json_encode($response);
    }

    public function add()
    {
        $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('semester', 'Semester', 'required');

        if ($this->form_validation->run() == true) {
            $data['tahun_ajaran'] = str_replace("'", "", htmlspecialchars($this->input->post('tahun_ajaran'), ENT_QUOTES));
            $data['semester'] = str_replace("'", "", htmlspecialchars($this->input->post('semester'), ENT_QUOTES));

            $tahun_ajaran = $this->TahunAjaranModel->add($data);

            if ($tahun_ajaran) {
                log_activity('insert', 'tambah tahun ajaran', 'tambah data tahun ajaran pada halaman tahun ajaran');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data tahun ajaran berhasil ditambah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data tahun ajaran gagal ditambah !'
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

            $kelas = $this->TahunAjaranModel->update($id, $data);

            if ($kelas) {
                log_activity('update', 'update tahun ajaran', 'update data tahun ajaran pada halaman tahun ajaran');
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

        $delete = $this->TahunAjaranModel->delete($id);
        if ($delete) {
            log_activity('delete', 'delete tahun ajaran', 'delete data tahun ajaran pada halaman tahun ajaran');
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
