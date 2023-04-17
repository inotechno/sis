<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SPP extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('RombelModel');
        $this->load->model('SPPModel');
        $this->load->helper('pdf');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'keuangan', 'sub_menu_active' => 'spp']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/spp',
            'plugin' => 'plugins/spp',
            'css' => 'css/spp',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function history_spp()
    {
        $this->session->set_userdata(['menu_active' => 'keuangan', 'sub_menu_active' => 'history-spp']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/history-spp',
            'plugin' => 'plugins/history-spp',
            'css' => 'css/spp',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $list = $this->RombelModel->getSantriRombel();

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ls) {

            $row = array();
            $row[] = $ls->nis;
            $row[] = $ls->nama_santri;
            $row[] = $ls->nama_kelas;
            $row[] = ' <div class="flex align-items-center list-user-action">
                        <a data-id="' . $ls->id_santri . '" data-nama="' . $ls->nama_santri . '" data-nis="' . $ls->nis . '" class="btn-view-spp" href="#"><span class="badge badge-rounded badge-primary">Lihat SPP</span></a>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->RombelModel->count_all(),
            "recordsFiltered" => $this->RombelModel->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function GetSPPBySantri($id)
    {
        $santri = $this->SPPModel->GetSPPBySantri($id)->result();
        echo json_encode($santri);
        // '<pre>' . var_dump($santri) . '</pre>';
        // die;
    }

    public function add()
    {
        $this->load->model('TahunAjaranModel');
        $this->form_validation->set_rules('santri_id', 'Santri', 'required|numeric');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required');

        if ($this->form_validation->run() == true) {
            $data['santri_id'] = str_replace("'", "", htmlspecialchars($this->input->post('santri_id'), ENT_QUOTES));
            $data['nominal'] = str_replace("'", "", htmlspecialchars($this->input->post('nominal'), ENT_QUOTES));
            $data['bulan'] = str_replace("'", "", htmlspecialchars($this->input->post('bulan'), ENT_QUOTES));
            $data['tahun_ajaran_id'] = $this->TahunAjaranModel->getAktif()->row('id');
            $data['user_id'] = $this->session->userdata('id');


            $validasi_duplicate = $this->SPPModel->validasi($data);

            if ($validasi_duplicate->num_rows() > 0) {
                $response = array(
                    'type' => 'error',
                    'title' => 'Gagal !!!',
                    'message' => 'Pembayaran gagal, sudah ada pembayaran dalam waktu yang sama.'
                );
            } else {
                $pembayaran = $this->SPPModel->add($data);

                if ($pembayaran) {
                    $response = array(
                        'type' => 'success',
                        'title' => 'Berhasil !!!',
                        'message' => 'Pembayaran berhasil, silahkan print bukti pembayaran.'
                    );
                } else {
                    $response = array(
                        'type' => 'warning',
                        'title' => 'Gagal !!!',
                        'message' => 'Pembayaran gagal, silahkan coba lagi !'
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
        log_activity('insert', 'tambah spp', 'tambah data spp pada halaman spp');
        echo json_encode($response);
    }

    public function CetakSPP($id)
    {
        $data = $this->SPPModel->GetSPPById($id)->row();
        // echo json_encode($data);
        // var_dump($data);
        // die;

        $html_ = $this->load->view('berkas/spp', $data, true);
        pdf_generator($html_, 'SPP ' . $data->nis);
    }

    public function get_history_spp()
    {
        $list = $this->SPPModel->getOrder();
        // var_dump($list);
        // echo $this->db->last_query($list);
        // die;

        $data = array();
        $no = $_POST['start'];

        $action = '';
        $status = '';

        foreach ($list as $ls) {

            if ($ls->status_paid == 203) {
                $status = '<span class="badge iq-bg-danger">Belum dibayar</span>';
            } else if ($ls->status_paid == 201) {
                $status = '<span class="badge iq-bg-warning">Diproses</span>';
            } else if ($ls->status_paid == 200) {
                $action = '<div class="flex align-items-center list-user-action">
                                <a data-id="' . $ls->id . '" class="iq-bg-success btn-validasi" href="#" title="Validasi"><i class="ri-checkbox-circle-fill"></i></a>
                            </div>';
                $status = '<span class="badge iq-bg-primary">Selesai</span>';

                if ($ls->status_code != 203) {
                    $action = '<div class="flex align-items-center list-user-action">
                                <span data-id="' . $ls->id . '" class="iq-bg-success" title="Tervalidasi"><i class="ri-checkbox-circle-fill"></i> Tervalidasi</span>
                            </div>';
                }
            }

            $row = array();
            $row[] = $ls->order_id;
            $row[] = $ls->nis;
            $row[] = $ls->name;
            $row[] = $ls->nominal;
            $row[] = $status;
            $row[] = date('d-m-Y H:i:s', strtotime($ls->created_at));
            $row[] = $action;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->SPPModel->count_all(),
            "recordsFiltered" => $this->SPPModel->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function validation()
    {
        $id = str_replace("'", "", htmlspecialchars($this->input->POST('id'), ENT_QUOTES));

        $spp['user_id'] = $this->session->userdata('id');
        $spp['status_code'] = 200;

        $act = $this->SPPModel->update($spp, $id);

        if ($act) {
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

        echo json_encode($response);
    }
}
