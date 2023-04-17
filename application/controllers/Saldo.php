<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldo extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SaldoModel');
        $this->load->model('TransaksiModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'keuangan', 'sub_menu_active' => 'saldo']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/saldo',
            'plugin' => 'plugins/saldo',
            'css' => 'css/saldo',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $list = $this->SaldoModel->getOrder();
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

                if ($ls->validation_at != NULL) {
                    $action = '<div class="flex align-items-center list-user-action">
                                <span data-id="' . $ls->id . '" class="iq-bg-success" title="Tervalidasi"><i class="ri-checkbox-circle-fill"></i> Tervalidasi</span>
                            </div>';
                }
            }

            $row = array();
            $row[] = $ls->order_id;
            $row[] = $ls->nis;
            $row[] = $ls->name;
            $row[] = $ls->amount;
            $row[] = $status;
            $row[] = date('d-m-Y H:i:s', strtotime($ls->created_at));
            $row[] = $action;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->SaldoModel->count_all(),
            "recordsFiltered" => $this->SaldoModel->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function validation()
    {
        $this->load->model('SantriModel');
        $id = str_replace("'", "", htmlspecialchars($this->input->POST('id'), ENT_QUOTES));

        $trx = $this->SaldoModel->GetHistoryByIdBill($id)->row();
        $saldo_awal = $this->SantriModel->GetSantriById(['s.id' => $trx->santri_id])->row('saldo');

        // var_dump($saldo_awal);
        // echo $this->db->last_query($saldo_awal);
        // die;

        $wallet['validation_at'] = date('Y-m-d H:i:s');
        $wallet['validation_by'] = $this->session->userdata('name');

        $this->SaldoModel->update($wallet, $id);

        $data['saldo'] = $saldo_awal + $trx->amount;
        $santri = $this->SantriModel->update($trx->user_id, $data);

        if ($santri) {
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

    public function topup_saldo()
    {
        $bill['santri_id'] = str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
        $bill['order_id'] = date('dmYHis');
        $bill['gross_amount'] = str_replace("'", "", htmlspecialchars($this->input->post('saldo'), ENT_QUOTES));
        $bill['status_paid'] = 200;

        $items['amount'] = $bill['gross_amount'];
        $act = $this->TransaksiModel->create_wallet_history($bill, $items);

        if ($act) {
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data Invoice berhasil ditambah, silahkan validasi !'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data Invoice gagal ditambah, silahkan ulang !!'
            );
        }

        echo json_encode($response);
    }
}
