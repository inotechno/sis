<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tabungan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('RombelModel');
        $this->load->model('TabunganModel');
        $this->load->helper('pdf');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'keuangan', 'sub_menu_active' => 'tabungan']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/tabungan',
            'plugin' => 'plugins/tabungan',
            'css' => 'css/tabungan',
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

    public function add()
    {
        $this->form_validation->set_rules('santri_id', 'Santri', 'required|numeric');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');

        if ($this->form_validation->run() == true) {
            $data['santri_id'] = str_replace("'", "", htmlspecialchars($this->input->post('santri_id'), ENT_QUOTES));
            $data['nominal'] = str_replace("'", "", htmlspecialchars($this->input->post('nominal'), ENT_QUOTES));
            $data['debit_kredit'] = str_replace("'", "", htmlspecialchars($this->input->post('debit_kredit'), ENT_QUOTES));
            $data['user_id'] = $this->session->userdata('id');

            $tabungan = $this->TabunganModel->add($data);

            if ($tabungan) {
                log_activity('insert', 'tambah tabungan', 'tambah data tabungan pada halaman tabungan');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Tabungan berhasil, silahkan print bukti tabungan.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Tabungan gagal, silahkan coba lagi !'
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

    public function CetakTabungan($id)
    {
        $tabungan = $this->TabunganModel->GetTabunganById($id)->row();
        // echo json_encode($tabungan);
        $html_ = $this->load->view('berkas/tabungan-rinci', $tabungan, true);
        pdf_generator($html_, 'Tabungan ' . $tabungan->nama_santri);
        // '<pre>' . var_dump($santri) . '</pre>';
        // die;
    }
}
