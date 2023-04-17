<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rombel extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('RombelModel');
        $this->load->model('KelasModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'rombel', 'sub_menu_active' => '']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/rombel',
            'plugin' => 'plugins/rombel',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $kelas = $this->KelasModel->all()->result();
        $data = array();
        foreach ($kelas as $k) {
            $data[$k->slug]['id'] = $k->id;
            $data[$k->slug]['nama_kelas'] = $k->nama_kelas;
            $data[$k->slug]['tingkat'] = $k->tingkat;
            $data[$k->slug]['wali_kelas'] = $k->wali_kelas;
            $data[$k->slug]['slug'] = $k->slug;
            $data[$k->slug]['anggota'] = $this->RombelModel->GetRombelByKelas($k->id)->result();
        }
        echo json_encode($data);
    }

    public function GetRombelWaliKelas()
    {
        $this->load->model('UstadzModel');
        $ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
        $where['wali_kelas_id'] = $ustadz->id_ustadz;
        $kelas = $this->KelasModel->all($where)->result();
        $data = array();
        foreach ($kelas as $k) {
            $data[$k->slug]['id'] = $k->id;
            $data[$k->slug]['nama_kelas'] = $k->nama_kelas;
            $data[$k->slug]['tingkat'] = $k->tingkat;
            $data[$k->slug]['wali_kelas'] = $k->wali_kelas;
            $data[$k->slug]['slug'] = $k->slug;
            $data[$k->slug]['anggota'] = $this->RombelModel->GetRombelByKelas($k->id)->result();
        }
        echo json_encode($data);
    }

    public function GetSantriRombelKelas()
    {
        $this->load->model('UstadzModel');
        $ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
        $where['wali_kelas_id'] = $ustadz->id_ustadz;
        $kelas = $this->KelasModel->all($where)->result();
        $data = array();
        foreach ($kelas as $k) {
            $data['anggota'] = $this->RombelModel->GetRombelByKelas($k->id)->result();
        }
        echo json_encode($data);
    }

    public function getById($id)
    {
        $where_id = str_replace("'", "", htmlspecialchars($id, ENT_QUOTES));
        $data = $this->RombelModel->getById($where_id)->row();
        echo json_encode($data);
    }

    public function GetSantriHaveNotRombel()
    {
        $data = $this->RombelModel->GetSantriHaveNotRombel()->result();
        echo json_encode($data);
    }

    public function GetSantriRombel()
    {
        $this->load->helper('hari');
        $this->load->model('JadwalModel');
        $this->load->model('UstadzModel');

        $ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
        $jadwal = $this->JadwalModel->GetJadwalWaktuIni(strtolower(hari_ini()), $ustadz->id_ustadz);

        $data = array();
        if ($jadwal->num_rows() > 0) {
            $jdwl = $jadwal->row();
            $data = $this->RombelModel->GetRombelByKelas($jdwl->id_kelas)->result();
            // var_dump($data);
            // die;
        }

        echo json_encode($data);
    }

    public function addAnggota()
    {
        $kelas = str_replace("'", "", htmlspecialchars($this->input->post('kelas_id'), ENT_QUOTES));

        $santri = $this->input->post('santri_id', true);

        $act = $this->RombelModel->addAnggota($kelas, $santri);

        if ($act) {
            log_activity('insert', 'tambah rombel', 'tambah data rombel pada halaman rombel');
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data Produk berhasil di tambah.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data Produk gagal di tambah !'
            );
        }

        echo json_encode($response);
    }

    public function transferAnggota()
    {
        $this->form_validation->set_rules('santri_id', 'santri_id', 'required');

        if ($this->form_validation->run() == true) {
            $data['santri_id'] = str_replace("'", "", htmlspecialchars($this->input->post('santri_id'), ENT_QUOTES));
            $data['kelas_id'] = str_replace("'", "", htmlspecialchars($this->input->post('kelas_id'), ENT_QUOTES));

            $act = $this->RombelModel->transferAnggota($data);
            if ($act) {
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data santri berhasil di pindahkan.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data santri gagal di pindahkan !'
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
        $id = str_replace("'", "", htmlspecialchars($this->input->post('santri_id'), ENT_QUOTES));

        $act = $this->RombelModel->delete($id);
        if ($act) {
            log_activity('delete', 'delete rombel', 'delete data rombel pada halaman rombel');
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data santri berhasil di keluarkan.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data santri gagal di keluarkan !'
            );
        }

        echo json_encode($response);
    }
}
