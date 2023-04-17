<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Xendit\Xendit;

class SPP extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('WaliSantriModel');
        $this->load->model('RombelModel');
        $this->load->model('SPPModel');
        $this->load->model('TahunAjaranModel');
        $this->load->model('TransaksiModel');
        $this->load->helper('pdf');
        Xendit::setApiKey(_XENDIT_KEY);
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'keuangan-ws', 'sub_menu_active' => 'spp-ws']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/walisantri/spp',
            'plugin' => 'plugins/walisantri/spp',
            'css' => 'css/spp',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function bayar()
    {
        $this->session->set_userdata(['menu_active' => 'keuangan-ws', 'sub_menu_active' => 'spp-ws']);
        $menu = $this->MenusModel->getMenu();

        $get['bulan'] = $this->input->get('bulan');
        $get['santri_id'] = $this->input->get('santri_id');
        $get['nominal'] = 200000;

        $data = [
            'content' => 'components/walisantri/bayar-spp',
            'plugin' => 'plugins/walisantri/bayar-spp',
            'css' => 'css/spp',
            'menus' => fetch_menu($menu),
            'get' => $get
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

    public function CetakSPP($id)
    {
        $data = $this->SPPModel->GetSPPById($id)->row();
        // echo json_encode($data);
        // var_dump($data);
        // die;

        $html_ = $this->load->view('berkas/spp', $data, true);
        pdf_generator($html_, 'SPP ' . $data->nis);
    }

    public function get_payment_method()
    {
        $act = $this->db->get('payment_types')->result();
        foreach ($act as $a) {
            $data[$a->type_slug]['type'] = $a->type;
            $data[$a->type_slug]['type_slug'] = $a->type_slug;
            $data[$a->type_slug]['options'] = $this->db->get_where('payment_types', ['type_slug' => $a->type_slug])->result();
        }

        echo json_encode($data);
    }

    public function pay()
    {
        $type = $this->db->get_where('payment_types', ['name_slug' => $this->input->post('payment_type')])->row();
        // var_dump($type);
        // die;
        $amount = $this->input->post('nominal');
        // $gross_amount = 10000;
        $gross_amount = ($amount + $type->fee);

        if ($type->type_slug == 'transfer_bank') {
            $pay = $this->virtual_account($gross_amount);
        }

        if ($type->type_slug == 'ewallets') {
            $pay = $this->ewallet($gross_amount);
        }

        if ($type->type_slug == 'retails') {
            $pay = $this->retail($gross_amount);
        }

        if ($type->type_slug == 'qrcode') {
            $pay = $this->qrcode($gross_amount);
        }

        if ($type->type_slug == 'credit_card') {
            $pay = $this->credit_card($gross_amount);
        }

        redirect(base_url('Payment/invoice/' . $pay['order_id']));
    }

    function virtual_account($gross_amount)
    {
        $order_id = date('YmdHis');

        $id = $this->session->userdata('id');
        $wali_id = $this->WaliSantriModel->GetUserById($id)->row();

        $date = new DateTime('now');
        $expire = new DateTime('+3 Hours');

        $params = [
            "external_id" => $order_id,
            "bank_code" => $this->input->post('payment_type'),
            "name" => $this->session->userdata('name'),
            "currency" =>  "IDR",
            "is_single_use" =>  true,
            "is_closed" =>  true,
            "expected_amount" =>  $gross_amount,
            "expiration_date" => $expire->format(DateTimeInterface::ISO8601),
        ];

        $xendit_res = \Xendit\VirtualAccounts::create($params);

        try {
            $data['order_id'] = $xendit_res['external_id'];
            $data['santri_id'] = $this->input->post('santri_id');
            $data['wali_id'] = $wali_id->id_wali_santri;
            $data['gross_amount'] = $xendit_res['expected_amount'];
            $data['payment_type'] = 'transfer_bank';
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($order_id));
            $data['deadline'] = date('Y-m-d H:i:s', strtotime($xendit_res['expiration_date']));

            $data['bank'] = $xendit_res['bank_code'];
            $data['bank_account'] = $xendit_res['account_number'];
            $data['payment_id'] = $xendit_res['id'];

            $items['santri_id'] = $this->input->post('santri_id');
            $items['bulan'] = $this->input->post('bulan');
            $items['nominal'] = 200000;
            $items['tahun_ajaran_id'] = $this->TahunAjaranModel->getAktif()->row('id');

            $this->TransaksiModel->create_spp($data, $items);

            // echo $this->db->last_query();
            // var_dump($xendit_res);
            // die;
            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }

    function ewallet($gross_amount)
    {
        $order_id = date('YmdHis');

        $id = $this->session->userdata('id');
        $wali_id = $this->WaliSantriModel->GetUserById($id)->row();

        $date = new DateTime('now');
        $expire = new DateTime('+3 Hours');

        $params = array(
            'reference_id' => $order_id,
            'currency' => 'IDR',
            'amount' => $gross_amount,
            'checkout_method' => 'ONE_TIME_PAYMENT',
            'metadata' => [
                'meta' => 'data'
            ],
            'channel_code' => $this->input->post('payment_type'),
        );

        if ($this->input->post('payment_type') == 'ID_OVO') {
            $params['channel_properties'] = [
                'mobile_number' => $wali_id->phone,
            ];
        }

        if ($this->input->post('payment_type') == 'ID_DANA' || $this->input->post('payment_type') == 'ID_LINKAJA') {
            $params['channel_properties'] = [
                'mobile_number' => $wali_id->phone,
                'success_redirect_url' => 'https://sis.mindotek.com/Payment/invoice/' . $order_id,
            ];
        }

        // var_dump($params);
        // die;
        $xendit_res = \Xendit\EWallets::createEWalletCharge($params);
        try {
            $data['order_id'] = $xendit_res['reference_id'];
            $data['santri_id'] = $this->input->post('santri_id');
            $data['wali_id'] = $wali_id->id_wali_santri;
            $data['gross_amount'] = $xendit_res['capture_amount'];
            $data['payment_type'] = 'ewallets';
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($order_id));
            $data['deadline'] = $expire->format(DateTimeInterface::ISO8601);

            $data['bank'] = $xendit_res['channel_code'];
            $data['bank_account'] = $xendit_res['channel_properties']['mobile_number'];
            $data['payment_id'] = $xendit_res['id'];
            $data['link'] = $xendit_res['actions']['desktop_web_checkout_url'];

            $items['santri_id'] = $this->input->post('santri_id');
            $items['bulan'] = $this->input->post('bulan');
            $items['nominal'] = 200000;
            $items['tahun_ajaran_id'] = $this->TahunAjaranModel->getAktif()->row('id');

            $this->TransaksiModel->create_spp($data, $items);

            // echo $this->db->last_query();

            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }

    function retail($gross_amount)
    {
        $order_id = date('YmdHis');

        $id = $this->session->userdata('id');
        $wali_id = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');

        $date = new DateTime('now');
        $expire = new DateTime('+3 Hours');

        $params = [
            'external_id' => $order_id,
            'retail_outlet_name' => $this->input->post('payment_type'),
            'name' => $this->session->userdata('name'),
            'expected_amount' => $gross_amount,
            'expiration_date' => $expire->format(DateTimeInterface::ISO8601)
        ];

        $xendit_res = \Xendit\Retail::create($params);
        // var_dump($xendit_res);
        // die;
        try {
            $data['order_id'] = $xendit_res['external_id'];
            $data['santri_id'] = $this->input->post('santri_id');
            $data['wali_id'] = $wali_id->id_wali_santri;
            $data['gross_amount'] = $xendit_res['expected_amount'];
            $data['payment_type'] = 'retails';
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($order_id));
            $data['deadline'] = date('Y-m-d H:i:s', strtotime($xendit_res['expiration_date']));

            $data['bank'] = $xendit_res['retail_outlet_name'];
            $data['bank_account'] = $xendit_res['payment_code'];
            $data['payment_id'] = $xendit_res['id'];

            $items['santri_id'] = $this->input->post('santri_id');
            $items['bulan'] = $this->input->post('bulan');
            $items['nominal'] = 200000;
            $items['tahun_ajaran_id'] = $this->TahunAjaranModel->getAktif()->row('id');

            $this->TransaksiModel->create_spp($data, $items);

            // echo $this->db->last_query();

            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }

    function qrcode($gross_amount)
    {
        $order_id = date('YmdHis');

        $id = $this->session->userdata('id');
        $wali_id = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');

        $date = new DateTime('now');
        $expire = new DateTime('+3 Hours');

        $params = [
            'external_id' =>  $order_id,
            'type' => 'DYNAMIC',
            'callback_url' => 'https://sis.mindotek.com',
            'amount' =>  $gross_amount,
            'expiration_date' => $expire->format(DateTimeInterface::ISO8601)
        ];

        $xendit_res = \Xendit\QRCode::create($params);
        // var_dump($xendit_res);
        // die;
        try {
            $data['order_id'] = $xendit_res['external_id'];
            $data['santri_id'] = $this->input->post('santri_id');
            $data['wali_id'] = $wali_id->id_wali_santri;
            $data['gross_amount'] = $xendit_res['amount'];
            $data['payment_type'] = 'qrcode';
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($order_id));
            $data['deadline'] = $expire->format(DateTimeInterface::ISO8601);

            $data['bank'] = 'QRIS';
            $data['bank_account'] = $xendit_res['type'];
            $data['payment_id'] = $xendit_res['id'];
            $data['link'] = $xendit_res['qr_string'];

            $items['santri_id'] = $this->input->post('santri_id');
            $items['bulan'] = $this->input->post('bulan');
            $items['nominal'] = 200000;
            $items['tahun_ajaran_id'] = $this->TahunAjaranModel->getAktif()->row('id');

            $this->TransaksiModel->create_spp($data, $items);
            // echo $this->db->last_query();

            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }

    function credit_card($gross_amount)
    {
        $order_id = date('YmdHis');

        $id = $this->session->userdata('id');
        $wali_id = $this->WaliSantriModel->GetUserById($id)->row();

        $date = new DateTime('now');
        $expire = new DateTime('+3 Hours');

        $params = [
            'token_id' => $this->input->post('token_id'),
            'external_id' => $order_id,
            'authentication_id' => $this->input->post('auth_id'),
            'amount' => $gross_amount,
            'card_cvn' => $this->input->post('cvn'),
            'capture' => false
        ];

        $xendit_res = \Xendit\Cards::create($params);
        // var_dump($xendit_res);
        // die;
        try {
            $data['order_id'] = $xendit_res['external_id'];
            $data['santri_id'] = $this->input->post('santri_id');
            $data['wali_id'] = $wali_id->id_wali_santri;
            $data['gross_amount'] = $gross_amount;
            $data['payment_type'] = 'credit_card';
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($order_id));
            $data['deadline'] = $expire->format(DateTimeInterface::ISO8601);

            $data['bank'] = 'CREDIT_CARD';
            $data['bank_account'] = $xendit_res['masked_card_number'];
            $data['payment_id'] = $xendit_res['id'];
            $data['status_paid'] = 200;
            $data['paid_at'] = date('Y-m-d H:i:s');

            $items['santri_id'] = $this->input->post('santri_id');
            $items['bulan'] = $this->input->post('bulan');
            $items['nominal'] = 200000;
            $items['tahun_ajaran_id'] = $this->TahunAjaranModel->getAktif()->row('id');

            $this->TransaksiModel->create_spp($data, $items);

            // echo $this->db->last_query();
            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }
}
