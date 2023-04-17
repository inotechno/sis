<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tabungan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('WaliSantriModel');
        $this->load->model('RombelModel');
        $this->load->model('TabunganModel');
        $this->load->helper('pdf');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'keuangan-ws', 'sub_menu_active' => 'tabungan-ws']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/walisantri/tabungan',
            'plugin' => 'plugins/walisantri/tabungan',
            'css' => 'css/tabungan',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $id = $this->session->userdata('id');

        $where['wali_id'] = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');
        $list = $this->RombelModel->getSantriRombel($where);

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ls) {

            $row = array();
            $row[] = $ls->nis;
            $row[] = $ls->nama_santri;
            $row[] = $ls->nama_kelas;
            $row[] = ' <div class="flex align-items-center list-user-action">
                        <a data-id="' . $ls->id_santri . '" data-nama="' . $ls->nama_santri . '" data-nis="' . $ls->nis . '" class="btn-view-tabungan" href="#"><span class="badge badge-rounded badge-primary">Lihat Tabungan</span></a>
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

    public function GetTabunganBySantri($id)
    {
        $santri = $this->TabunganModel->GetTabunganBySantri($id)->result();
        echo json_encode($santri);
        // $html_ = $this->load->view('berkas/tabungan', '', true);
        // pdf_generator($html_);
        // '<pre>' . var_dump($santri) . '</pre>';
        // die;
    }

    public function CetakTabungan($id)
    {
        $tabungan = $this->TabunganModel->GetTabunganById($id)->row();
        // echo json_encode($tabungan);
        $html_ = $this->load->view('berkas/tabungan', '', true);
        pdf_generator($html_, 'Tabungan' . $tabungan->nama_santri);
        // '<pre>' . var_dump($santri) . '</pre>';
        // die;
    }
}
