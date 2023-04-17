<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TagModel');
        $this->load->model('TransaksiModel');
        $this->load->model('SantriModel');
        $this->load->model('JadwalModel');
    }

    public function itemtroli($tagid)
    {
        $item = $this->db->get_where('sampleitems', ['tagid' => $tagid])->row_array();
        $echo = [
            'name' => $item['name'],
            'price' => $item['price']
        ];
        echo json_encode($echo);
    }
    public function itemtrolipost()
    {
        $tagid = $this->input->post('tagid');
        $item = $this->db->get_where('sampleitems', ['tagid' => $tagid])->row_array();
        $echo = [
            'name' => $item['name'],
            'price' => $item['price']
        ];
        echo json_encode($echo);
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }
    public function doabsen($rfid)
    {
        $this->load->model('KehadiranModel');
        $this->load->helper('hari');

        $this->load->model('UserModel');

        // $user =
        $santri = $this->SantriModel->GetSantriByTagId($rfid);

        // var_dump($santri);
        $data = [];
        if ($santri->num_rows() > 0) {

            $check_jadwal = $this->JadwalModel->GetJadwalByKelasAndHari($santri->row()->id_kelas, strtolower(hari_ini()));
            // var_dump($check_jadwal->row());
            if ($check_jadwal->num_rows() > 0) {
                $att['santri_id'] = $santri->row()->id_santri;
                $att['jadwal_id'] = $check_jadwal->row()->id;
                $insert = $this->KehadiranModel->add($att);

                $data = [
                    'status' => 'success',
                    'waktu' => date('H:i:s'),
                    'nama' => $santri->row()->nama_santri,
                    'uid' => $rfid
                ];
            } else {
                $data = [
                    'status' => 'success',
                    'waktu' => date('H:i:s'),
                    'nama' => 'Tidak ada jadwal !',
                    'uid' => $rfid
                ];
            }
        } else {
            $data = [
                'status' => 'failed'
            ];
        }

        echo json_encode($data, true);
    }

    ///////////////////////////////////// wifi
    public function getssid()
    {
        $data = [
            'ssid' => 'TPM Logistik',
            'password' => 'dutaMas26'
        ];
        echo json_encode($data, true);
    }

    /////////////////////////////////// SEBAGAI DOMPET DIGITAL

    public function walletcheck($rfid)
    {

        $santri = $this->db->get_where('santri', ['tag_id' => $rfid])->row_array();

        $get = $this->SantriModel->GetUserById($santri['user_id'])->row_array();
        $data = [];
        if ($get) {
            $data = [
                'status' => 'success',
                'nama' => $get['name'],
                'saldo' => number_format($get['saldo'])
            ];
        } else {
            $data = [
                'status' => 'failed'
            ];
        }
        echo json_encode($data, true);
    }

    public function pay()
    {
        $rfid = $this->input->get('uid');

        $id = $this->db->get_where('santri', ['tag_id' => $rfid])->row_array();

        $act = $this->TransaksiModel->GetTransactionBySantri($id['id'])->row_array();
        if ($act) {

            if ($act['saldo'] > $act['gross_amount']) {
                $data = [
                    'status' => 'success',
                    'sisa' => number_format($act['saldo'] - $act['gross_amount'])
                ];

                $this->TransaksiModel->update($act['bill_id'], ['status_paid' => 200]);
                $this->SantriModel->update($id['user_id'], ['saldo' => $act['saldo'] - $act['gross_amount']]);
            } else {
                $data = [
                    'status' => 'unable',
                    'sisa' => number_format($act['saldo'])
                ];
            }
            echo json_encode($data, true);
        } else {
            $data = [
                'status' => 'failed'
            ];
            echo json_encode($data, true);
        }
    }

    ////////////////////////////////////// GENERAL 

    public function visitorcount($rfid)
    {
        $this->load->model('VisitorModel');

        // $cek = $this->db->order_by('date_in', 'desc')->get_where('visitor_logs', ['tag_id' => $rfid], 1);
        // if ($cek->num_rows() > 0) {
        //     $dt = $cek->row();
        //     if ($dt->date_out == null) {
        //         $add['tag_id'] = $rfid;
        //         $add['in_out'] = 1;
        //     } else {
        //         $add['tag_id'] = $rfid;
        //     }
        // } else {
        //     $add['tag_id'] = $rfid;
        // }
        $add['tag_id'] = $rfid;

        $this->VisitorModel->addTag($add);
        $data = ['status' => 'success', 'waktu' => date('H:i:s')];
        echo json_encode($data, true);
    }

    public function addtagid($rfid)
    {
        $date = date('Y-m-d H:i:s');
        $data['tag_id'] = $rfid;

        $check = $this->db->get_where('tags', ['tag_id' => $data['tag_id']]);
        if ($check->num_rows() > 0) {
            $data = ['status' => 'success', 'waktu' => 'Error duplicate tag !'];
        } else {
            $this->TagModel->insert($data);
            $data = ['status' => 'success', 'waktu' => $date];
        }
        echo json_encode($data, true);
    }
}
