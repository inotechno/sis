<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Xendit\Xendit;

class Saldo extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        Xendit::setApiKey(_XENDIT_KEY);
        $this->load->model('TransaksiModel');
        $this->load->model('WaliSantriModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'keuangan-ws', 'sub_menu_active' => 'saldo-ws']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/walisantri/saldo',
            'plugin' => 'plugins/walisantri/saldo',
            'css' => 'css/saldo',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function invoice($order_id)
    {
        $this->session->set_userdata(['menu_active' => 'store-ws', 'sub_menu_active' => 'order-ws']);
        $menu = $this->MenusModel->getMenu();

        $where['order_id'] = $order_id;
        $order = $this->TransaksiModel->GetOrderDetail($where)->row();

        $data = [
            'content' => 'components/invoice',
            'plugin' => 'plugins/invoice',
            'css' => 'css/invoice',
            'menus' => fetch_menu($menu),
            'order' => $order
        ];


        $this->load->view('layouts/app', $data);
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
        $amount = $this->input->post('amount');
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

            $items['amount'] = $this->input->post('amount');
            $this->TransaksiModel->create_wallet_history($data, $items);

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

            $items['amount'] = $this->input->post('amount');
            $this->TransaksiModel->create_wallet_history($data, $items);

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

            $items['amount'] = $this->input->post('amount');
            $this->TransaksiModel->create_wallet_history($data, $items);

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

            $items['amount'] = $this->input->post('amount');
            $this->TransaksiModel->create_wallet_history($data, $items);
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

            $items['amount'] = $this->input->post('amount');
            $this->TransaksiModel->create_wallet_history($data, $items);

            // echo $this->db->last_query();
            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }
}
