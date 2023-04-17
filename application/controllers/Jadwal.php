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
        $this->session->set_userdata(['menu_active' => 'jadwal', 'sub_menu_active' => '']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/jadwal',
            'plugin' => 'plugins/jadwal',
            'css' => 'css/jadwal',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $list = $this->JadwalModel->getJadwal();

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ls) {
            $row = array();
            $row[] = $ls->nama_kelas;
            $row[] = $ls->nama_mapel;
            $row[] = $ls->nama_ustadz;
            $row[] = ucfirst($ls->hari) . ', ' . $ls->waktu_mulai;
            $row[] = ' <div class="flex align-items-center list-jadwal-action">
                        <a data-id="' . $ls->id . '" class="iq-bg-warning btn-update" href="#" title="Edit"><i class="ri-pencil-line"></i></a>
                        <a data-id="' . $ls->id . '" class="iq-bg-danger btn-delete" href="#" title="Delete"><i class="ri-delete-bin-line"></i></a>
                    </div>';

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

    public function add()
    {
        $this->form_validation->set_rules('kelas_id', 'Kelas', 'required');
        $this->form_validation->set_rules('ustadz_id', 'Ustadz', 'required');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'required');
        $this->form_validation->set_rules('waktu_mulai', 'Waktu Mulai', 'required');

        if ($this->form_validation->run() == true) {
            $data['mapel_id'] = str_replace("'", "", htmlspecialchars($this->input->post('mapel_id'), ENT_QUOTES));
            $data['ustadz_id'] = str_replace("'", "", htmlspecialchars($this->input->post('ustadz_id'), ENT_QUOTES));
            $data['kelas_id'] = str_replace("'", "", htmlspecialchars($this->input->post('kelas_id'), ENT_QUOTES));
            $data['hari'] = str_replace("'", "", htmlspecialchars($this->input->post('hari'), ENT_QUOTES));
            $data['waktu_mulai'] = str_replace("'", "", htmlspecialchars($this->input->post('waktu_mulai'), ENT_QUOTES));

            $validasi = $this->JadwalModel->validasi_duplicate($data);
            // echo $this->db->last_query($validasi);
            // var_dump($validasi);
            // // echo $validasi;
            // die;
            if (strtotime($validasi->row('waktu_selesai')) > strtotime($data['waktu_mulai'])) {
                $response = array(
                    'type' => 'error',
                    'title' => 'Gagal !!!',
                    'message' => 'Data jadwal sudah tersedia.'
                );
            } else {
                $jadwal = $this->JadwalModel->add($data);

                if ($jadwal) {
                    log_activity('insert', 'tambah jadwal', 'tambah data jadwal pada halaman jadwal');
                    $response = array(
                        'type' => 'success',
                        'title' => 'Berhasil !!!',
                        'message' => 'Data jadwal berhasil di tambah.'
                    );
                } else {
                    $response = array(
                        'type' => 'warning',
                        'title' => 'Gagal !!!',
                        'message' => 'Data jadwal gagal di tambah !'
                    );
                }
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

            $jadwal = $this->JadwalModel->update($id, $data);

            if ($jadwal) {
                log_activity('update', 'update jadwal', 'update data jadwal pada halaman jadwal');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data jadwal berhasil di ubah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data jadwal gagal di ubah !'
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

        $delete = $this->JadwalModel->delete($id);
        if ($delete) {
            log_activity('delete', 'delete jadwal', 'delete data jadwal pada halaman jadwal');
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data jadwal berhasil di hapus.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data jadwal gagal di hapus !'
            );
        }

        echo json_encode($response);
    }
}
