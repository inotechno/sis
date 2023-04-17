<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Visitor extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('VisitorModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'visitor', 'sub_menu_active' => '']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/visitor',
            'plugin' => 'plugins/visitor',
            'css' => 'css/visitor',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $list = $this->VisitorModel->GetVisitor();

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ls) {
            $row = array();
            $row[] = $ls->tag_id;
            $row[] = $ls->nama_lengkap;
            $row[] = $ls->keterangan;
            $row[] = $ls->date_in;
            $row[] = $ls->date_out;
            $row[] = $ls->penerima;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->VisitorModel->count_all(),
            "recordsFiltered" => $this->VisitorModel->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function GetTagCheckIn()
    {
        $get = $this->VisitorModel->GetTagCheckIn()->row();
        echo json_encode($get);
    }

    public function GetTagCheckOut()
    {
        $get = $this->VisitorModel->GetTagCheckOut()->row();
        echo json_encode($get);
    }

    public function update()
    {
        $tag_id = str_replace("'", "", htmlspecialchars($this->input->post('tag_id'), ENT_QUOTES));
        $data['date_out'] = date('Y-m-d H:i:s');
        $act = $this->VisitorModel->update($data, $tag_id);

        if ($act) {
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data pengunjung berhasil diupdate.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data pengunjung gagal diupdate !'
            );
        }

        echo json_encode($response);
    }

    public function add()
    {
        $this->form_validation->set_rules('tag_id', 'Tag RFID', 'required');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');

        if ($this->form_validation->run() == true) {
            $data['tag_id'] = str_replace("'", "", htmlspecialchars($this->input->post('tag_id'), ENT_QUOTES));
            $data['nama_lengkap'] = str_replace("'", "", htmlspecialchars($this->input->post('nama_lengkap'), ENT_QUOTES));
            $data['keterangan'] = str_replace("'", "", htmlspecialchars($this->input->post('keterangan'), ENT_QUOTES));
            $data['date_in'] = date('Y-m-d H:i:s');
            $data['user_id'] = $this->session->userdata('id');

            $act = $this->VisitorModel->add($data);

            if ($act) {
                log_activity('insert', 'pengunjung check in', 'Penerimaan tamu');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data pengunjung berhasil ditambah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data pengunjung gagal ditambah !'
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
