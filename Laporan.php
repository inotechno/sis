<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KehadiranModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'laporan', 'sub_menu_active' => 'laporan-us-absensi']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/ustadz/laporan-absensi',
            'plugin' => 'plugins/ustadz/laporan-absensi',
            'css' => 'css/absensi',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function absensi()
    {
        $list = $this->KehadiranModel->getKehadiran();

        $data = array();
        $no = $_POST['start'];
        $sakit = 0;
        $hadir = 0;
        $izin = 0;
        $tidak_hadir = 0;

        foreach ($list as $ls) {

            if ($ls->status == 'hadir') {
                $hadir += 1;
            }
            if ($ls->status == 'izin') {
                $izin += 1;
            }
            if ($ls->status == 'sakit') {
                $sakit += 1;
            }
            if ($ls->status == 'tidak hadir') {
                $tidak_hadir += 1;
            }

            $row = array();
            $row[] = $ls->nis;
            $row[] = $ls->nama_santri;
            $row[] = $ls->nama_mapel;
            $row[] = date('d-m-Y H:i:s', strtotime($ls->created_at));
            $row[] = ucfirst($ls->status);

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->KehadiranModel->count_all(),
            "recordsFiltered" => $this->KehadiranModel->count_filtered(),
            "data" => $data,
            "total" => array('hadir' => $hadir, 'izin' => $izin, 'sakit' => $sakit, 'tidak_hadir' => $tidak_hadir),
        );

        echo json_encode($output);
    }
}
