<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sembako extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SembakoModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'sembako-k', 'sub_menu_active' => '']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/kasir/sembako',
            'plugin' => 'plugins/kasir/sembako',
            'css' => 'css/transaksi',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function GetSembako()
    {
        $this->load->model('UstadzModel');
        $data = [];
        $ustadz = $this->UstadzModel->all()->result();
        // var_dump($ustadz);
        // die;
        $status = '';

        $where['s.bulan'] = $this->input->get('bulan');
        foreach ($ustadz as $us) {
            $where['s.ustadz_id'] = $us->id_ustadz;

            $sembako = $this->SembakoModel->GetSembako($where);

            if ($sembako->num_rows() == 0) {
                $status = '<a href="#" data-id-ustadz="' . $us->id_ustadz . '" class="badge badge-pill badge-primary btn-ambil">Ambil</a>';
            } else {
                $status = '<div class="badge badge-pill badge-success">Sudah Di Ambil</div>';
            }

            $data[] = array(
                'images' => $us->images,
                'name' => $us->name,
                'nik' => $us->nik,
                'status' => $status
            );
        }

        echo json_encode($data);
    }

    public function checkout()
    {
        $this->load->model('TahunAjaranModel');
        $sembako['ustadz_id'] = str_replace("'", "", htmlspecialchars($this->input->post('ustadz_id'), ENT_QUOTES));
        $sembako['bulan'] = str_replace("'", "", htmlspecialchars($this->input->post('bulan'), ENT_QUOTES));
        $sembako['tahun_ajaran_id'] = $this->TahunAjaranModel->getAktif()->row('id');
        $sembako['user_id'] = $this->session->userdata('id');

        $items = $this->input->post('product_id', true);

        $where['s.bulan'] = $sembako['bulan'];
        $where['s.ustadz_id'] = $sembako['ustadz_id'];
        $check_tagihan = $this->SembakoModel->GetSembako($where);

        if ($check_tagihan->num_rows() > 0) {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Ustadz sudah menerima sembako pada bulan ini !'
            );
        } else {

            $act = $this->SembakoModel->create_sembako($sembako, $items);

            if ($act) {
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data penerimaan sembako berhasil ditambah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data penerimaan sembako gagal ditambah !'
                );
            }
        }

        echo json_encode($response);
    }
}
