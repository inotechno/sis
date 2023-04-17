<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

use Xendit\Xendit;

class Rest extends REST_Controller
{
    public function __construct()
    {

        parent::__construct();
        $config = $this->db->get('config')->result_array();
        foreach ($config as $cf) {
            define("_{$cf['name']}", $cf['value']);
        }
        $this->load->model('AuthModel');
        $this->load->model('WaliSantriModel');
        $this->load->model('SantriModel');
        $this->load->model('TransaksiModel');
        $this->load->model('UstadzModel');
        $this->load->model('JadwalModel');
        $this->load->model('KehadiranModel');

        Xendit::setApiKey(_XENDIT_KEY);
    }

    // Start Method POST

    public function Login_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');
        $data = $this->AuthModel->login($email)->row();

        // echo $this->db->last_query($data);
        // die;
        if ($data) {
            if ($data->status != 0) {
                if (password_verify($password, $data->password)) {
                    unset($data->password);
                    $this->response($data, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'Password yang anda masukan salah, silahkan coba lagi ! !'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Email tidak aktif, silahkan verifikasi email !'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Akun belum terdaftar, silahkan registrasi !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function AddCart_post()
    {
        $id = $this->post('user_id');

        $data['wali_id'] = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');
        $data['product_id'] = str_replace("'", "", htmlspecialchars($this->post('product_id'), ENT_QUOTES));

        $data = $this->TransaksiModel->add_cart($data);
        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Produk berhasil di simpan kedalam keranjang !'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function DeleteCart_post()
    {
        $id = $this->post('id_cart');

        $data = $this->TransaksiModel->delete_cart($id);
        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Produk berhasil di hapus dalam keranjang !'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Produk gagal di hapus dari keranjang !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // End Method POST

    // Start Method GET

    public function GetTransactionByWali_get()
    {
        $id = $this->get('user_id');

        $where['b.wali_id'] = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');
        $data = $this->TransaksiModel->GetTransaction($where);

        // var_dump($data);
        // echo $this->db->last_query($data);
        // die;

        if ($data->num_rows() > 0) {
            // $this->response($data->result(), REST_Controller::HTTP_OK);
            $this->response([
                'status' => true,
                'data_transaction' => $data->result(),
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function GetSantriByWali_get()
    {
        $id = $this->get('user_id');

        $where['s.wali_id'] = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');
        $data = $this->SantriModel->GetSantriByWali($where);

        // var_dump($data);
        // echo $this->db->last_query($data);
        // die;

        if ($data->num_rows() > 0) {
            // $this->response($data->result(), REST_Controller::HTTP_OK);
            $this->response([
                'status' => true,
                'data_santri' => $data->result(),
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function GetCategory_get()
    {
        $where = NULL;
        $this->load->model('CategoryModel');
        if (!empty($this->get('user_id'))) {
            $where['id'] =  str_replace("'", "", htmlspecialchars($this->get('user_id'), ENT_QUOTES));
        }

        $data = $this->CategoryModel->getAll($where);
        if ($data->num_rows() > 0) {
            $this->response($data->result(), REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kategori tidak di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function GetProduct_get()
    {
        $where = NULL;

        $this->load->model('ProductModel');
        if (!empty($this->get('category_id'))) {
            $where['category_id'] =  str_replace("'", "", htmlspecialchars($this->get('category_id'), ENT_QUOTES));
        }

        if (!empty($this->get('user_id'))) {
            $where['id'] =  str_replace("'", "", htmlspecialchars($this->get('user_id'), ENT_QUOTES));
        }

        $limit = (!empty($this->get('limit'))) ? $this->get('limit') : NULL;

        $default[] = array(
            'id' => '1',
            'product_id' => '1',
            'file_name' => 'default.png'
        );

        $product = $this->ProductModel->getAll($limit, $where)->result();
        foreach ($product as $pr => $v) {
            $images = $this->ProductModel->getImages($v->id);
            if ($images->num_rows() > 0) {
                $data_images = $images->result();
            } else {
                $data_images = $default;
            }
            $data[] = array(
                'barcode' => $v->barcode,
                'category_id' => $v->category_id,
                'category_images' => $v->category_images,
                'category_title' => $v->category_title,
                'created_at' => $v->created_at,
                'description' => $v->description,
                'id' => $v->id,
                'price' => $v->price,
                'stok' => $v->stok,
                'title' => $v->title,
                'satuan' => $v->satuan,
                'images' => $data_images,
            );
        }

        if (count($data) > 0) {
            // $this->response($data->result(), REST_Controller::HTTP_OK);
            $this->response([
                'status' => true,
                'data_product' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Produk tidak di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function GetCart_get()
    {
        $id = $this->get('user_id');

        $data = array();
        $where['wali_id'] = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');
        $product  = $this->TransaksiModel->getCart($where);

        // var_dump($product->result());
        // die;

        $default[] = array(
            'id' => '1',
            'product_id' => '1',
            'file_name' => 'default.png'
        );

        foreach ($product->result() as $pr => $v) {
            $images = $this->ProductModel->getImages($v->id);
            if ($images->num_rows() > 0) {
                $data_images = $images->result();
            } else {
                $data_images = $default;
            }
            $data[] = array(
                'barcode' => $v->barcode,
                'category_id' => $v->category_id,
                'created_at' => $v->created_at,
                'description' => $v->description,
                'id' => $v->id,
                'price' => $v->price,
                'stok' => $v->stok,
                'title' => $v->title,
                'satuan' => $v->satuan,
                'updated_at' => $v->updated_at,
                'nama_wali' => $v->nama_wali,
                'id_wali_santri' => $v->id_wali_santri,
                'id_cart' => $v->id_cart,
                'images' => $data_images,
            );
        }

        if ($data > 0) {
            // $this->response($data->result(), REST_Controller::HTTP_OK);
            $this->response([
                'status' => true,
                'data_cart' => $data,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Produk tidak di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function GetTabungan_get()
    {
        $this->load->model('TabunganModel');

        $id = $this->get('santri_id');
        $data = $this->TabunganModel->GetTabunganBySantri($id);
        if ($data->num_rows() > 0) {
            // $this->response($data->result(), REST_Controller::HTTP_OK);
            $this->response([
                'status' => true,
                'data_tabungan' => $data->result(),
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Tabungan tidak di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function GetSPP_get()
    {
        $this->load->model('SPPModel');
        $id = $this->get('santri_id');
        $data = $this->SPPModel->GetSPPBySantri($id);
        if ($data->num_rows() > 0) {
            // $this->response($data->result(), REST_Controller::HTTP_OK);
            $this->response([
                'status' => true,
                'data_spp' => $data->result(),
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'SPP tidak di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function GetMaklumat_get()
    {
        $this->load->model('MaklumatModel');

        $limit = (!empty($this->get('limit'))) ? $this->get('limit') : NULL;
        $where['p.role_id'] = 4;
        $data = $this->MaklumatModel->all($limit, $where);
        if ($data->num_rows() > 0) {
            // $this->response($data->result(), REST_Controller::HTTP_OK);
            $this->response([
                'status' => true,
                'data_maklumat' => $data->result(),
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Artikel maklumat tidak di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // API Ustadz

    public function GetSantriByWaliKelas_get()
    {
        $this->load->model('UstadzModel');
        $this->load->model('RombelModel');
        $ustadz = $this->UstadzModel->GetUserById($this->get('user_id'))->row();
        $where['k.wali_kelas_id'] = $ustadz->id_ustadz;

        $data = $this->RombelModel->getAll($where);
        if ($data->num_rows() > 0) {
            // $this->response($data->result(), REST_Controller::HTTP_OK);
            $this->response([
                'status' => true,
                'data_santri' => $data->result(),
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Santri tidak di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function GetJadwalUstadz_get()
    {

        $ustadz = $this->UstadzModel->GetUserById($this->get('id'))->row();
        $where['ustadz_id'] = $ustadz->id_ustadz;

        $data = $this->JadwalModel->GetJadwalUstadz($where);
        // echo $this->db->last_query($data);
        // die;
        if ($data->num_rows() > 0) {
            // $this->response($data->result(), REST_Controller::HTTP_OK);
            $this->response([
                'status' => true,
                'data_jadwal' => $data->result(),
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Jadwal ustadz di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function GetJadwalWaktuIni_get()
    {
        $this->load->helper('hari');
        $data = array();
        $ustadz = $this->UstadzModel->GetUserById($this->get('id'))->row();
        $jadwal = $this->JadwalModel->GetJadwalWaktuIni(strtolower(hari_ini()), $ustadz->id_ustadz);

        // echo $this->db->last_query($jadwal);
        // die;
        if ($jadwal->num_rows() > 0) {
            $jdwl = $jadwal->row();
            $list = $this->KehadiranModel->_getKehadiranByJadwal($jdwl->id);

            $data['status'] = 'success';
            $data['jadwal'] = $jdwl;
            $data['jumlah_santri'] = $list->num_rows();

            $this->response([
                'status' => true,
                'data_jadwal' => $data,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Jadwal ustadz di temukan !'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // End API Ustadz

    // End Method GET






    // Payment XENDIT
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

    public function pay_post()
    {
        $type = $this->db->get_where('payment_types', ['name_slug' => $this->post('payment_type')])->row();
        // var_dump($type);
        // die;
        $data['amount'] = $this->post('amount');
        $data['ppn'] = ($data['amount'] + $type->fee) * 11 / 100;
        $data['payment_type'] = $this->post('payment_type');
        $data['user_id'] = $this->post('user_id');
        $data['santri_id'] = $this->post('santri_id');
        // $gross_amount = 10000;
        $data['gross_amount'] = ($data['amount'] + $type->fee) + $data['ppn'];
        $data['product_id'] = $this->post('product_id', true);

        $items = $this->post('id_cart', true);
        // echo json_encode($this->input->post());
        // die;
        $this->TransaksiModel->deleteCart($items);

        if ($type->type_slug == 'transfer_bank') {
            $pay = $this->virtual_account($data);
        }

        if ($type->type_slug == 'ewallets') {
            $pay = $this->ewallet($data);
        }

        if ($type->type_slug == 'retails') {
            $pay = $this->retail($data);
        }

        if ($type->type_slug == 'qrcode') {
            $pay = $this->qrcode($data);
        }

        if ($type->type_slug == 'credit_card') {
            $pay = $this->credit_card($data);
        }

        if (!empty($pay['order_id'])) {
            $pay['payment_type'] = $this->db->get_where('payment_types', ['name_slug' => $pay['bank']])->row();
            $this->response([
                'status' => true,
                'message' => $pay
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'error'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    function virtual_account($dt)
    {
        $order_id = date('YmdHis');
        $wali_id = $this->WaliSantriModel->GetUserById($dt['user_id'])->row();

        $date = new DateTime('now');
        $expire = new DateTime('+3 Hours');

        $params = [
            "external_id" => $order_id,
            "bank_code" => $dt['payment_type'],
            "name" => $wali_id->name,
            "currency" =>  "IDR",
            "is_single_use" =>  true,
            "is_closed" =>  true,
            "expected_amount" =>  $dt['gross_amount'],
            "expiration_date" => $expire->format(DateTimeInterface::ISO8601),
        ];

        $xendit_res = \Xendit\VirtualAccounts::create($params);

        try {
            $data['order_id'] = $xendit_res['external_id'];
            $data['santri_id'] = $dt['santri_id'];
            $data['wali_id'] = $wali_id->id_wali_santri;
            $data['gross_amount'] = $xendit_res['expected_amount'];
            $data['payment_type'] = 'transfer_bank';
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($order_id));
            $data['deadline'] = date('Y-m-d H:i:s', strtotime($xendit_res['expiration_date']));

            $data['bank'] = $xendit_res['bank_code'];
            $data['bank_account'] = $xendit_res['account_number'];
            $data['payment_id'] = $xendit_res['id'];

            $act = $this->TransaksiModel->create_bill_santri($data, $dt['product_id']);

            // echo $this->db->last_query();
            // var_dump($xendit_res);
            // die;
            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }

    function ewallet($dt)
    {
        $order_id = date('YmdHis');
        $wali_id = $this->WaliSantriModel->GetUserById($dt['id'])->row();

        $date = new DateTime('now');
        $expire = new DateTime('+3 Hours');

        $params = array(
            'reference_id' => $order_id,
            'currency' => 'IDR',
            'amount' => $dt['gross_amount'],
            'checkout_method' => 'ONE_TIME_PAYMENT',
            'metadata' => [
                'meta' => 'data'
            ],
            'channel_code' => $dt['payment_type'],
        );

        if ($dt['payment_type'] == 'ID_OVO') {
            $params['channel_properties'] = [
                'mobile_number' => $wali_id->phone,
            ];
        }

        if ($dt['payment_type'] == 'ID_DANA' || $dt['payment_type'] == 'ID_LINKAJA') {
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
            $data['santri_id'] = $dt['santri_id'];
            $data['wali_id'] = $wali_id->id_wali_santri;
            $data['gross_amount'] = $xendit_res['capture_amount'];
            $data['payment_type'] = 'ewallets';
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($order_id));
            $data['deadline'] = $expire->format(DateTimeInterface::ISO8601);

            $data['bank'] = $xendit_res['channel_code'];
            $data['bank_account'] = $xendit_res['channel_properties']['mobile_number'];
            $data['payment_id'] = $xendit_res['id'];
            $data['link'] = $xendit_res['actions']['desktop_web_checkout_url'];

            $act = $this->TransaksiModel->create_bill_santri($data, $dt['product_id']);

            // echo $this->db->last_query();

            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }

    function retail($dt)
    {
        $order_id = date('YmdHis');
        $wali_id = $this->WaliSantriModel->GetUserById($dt['id'])->row();

        $date = new DateTime('now');
        $expire = new DateTime('+3 Hours');

        $params = [
            'external_id' => $order_id,
            'retail_outlet_name' => $dt['payment_type'],
            'name' => $wali_id->name,
            'expected_amount' => $dt['gross_amount'],
            'expiration_date' => $expire->format(DateTimeInterface::ISO8601)
        ];

        $xendit_res = \Xendit\Retail::create($params);
        // var_dump($xendit_res);
        // die;
        try {
            $data['order_id'] = $xendit_res['external_id'];
            $data['santri_id'] = $dt['santri_id'];
            $data['wali_id'] = $wali_id->id_wali_santri;
            $data['gross_amount'] = $xendit_res['expected_amount'];
            $data['payment_type'] = 'retails';
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($order_id));
            $data['deadline'] = date('Y-m-d H:i:s', strtotime($xendit_res['expiration_date']));

            $data['bank'] = $xendit_res['retail_outlet_name'];
            $data['bank_account'] = $xendit_res['payment_code'];
            $data['payment_id'] = $xendit_res['id'];

            $act = $this->TransaksiModel->create_bill_santri($data, $dt['product_id']);

            // echo $this->db->last_query();

            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }

    function qrcode($dt)
    {
        $order_id = date('YmdHis');
        $wali_id = $this->WaliSantriModel->GetUserById($dt['id'])->row();

        $date = new DateTime('now');
        $expire = new DateTime('+3 Hours');

        $params = [
            'external_id' =>  $order_id,
            'type' => 'DYNAMIC',
            'callback_url' => 'https://sis.mindotek.com',
            'amount' =>  $dt['gross_amount'],
            'expiration_date' => $expire->format(DateTimeInterface::ISO8601)
        ];

        $xendit_res = \Xendit\QRCode::create($params);
        // var_dump($xendit_res);
        // die;
        try {
            $data['order_id'] = $xendit_res['external_id'];
            $data['santri_id'] = $dt['santri_id'];
            $data['wali_id'] = $wali_id->id_wali_santri;
            $data['gross_amount'] = $xendit_res['amount'];
            $data['payment_type'] = 'qrcode';
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($order_id));
            $data['deadline'] = $expire->format(DateTimeInterface::ISO8601);

            $data['bank'] = 'QRIS';
            $data['bank_account'] = $xendit_res['type'];
            $data['payment_id'] = $xendit_res['id'];
            $data['link'] = $xendit_res['qr_string'];

            $act = $this->TransaksiModel->create_bill_santri($data, $dt['product_id']);

            // echo $this->db->last_query();

            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }

    function credit_card($dt)
    {
        $order_id = date('YmdHis');
        $wali_id = $this->WaliSantriModel->GetUserById($dt['id'])->row();

        $date = new DateTime('now');
        $expire = new DateTime('+3 Hours');

        $params = [
            'token_id' => $this->input->post('token_id'),
            'external_id' => $order_id,
            'authentication_id' => $this->input->post('auth_id'),
            'amount' => $dt['gross_amount'],
            'card_cvn' => $this->input->post('cvn'),
            'capture' => false
        ];

        $xendit_res = \Xendit\Cards::create($params);
        // var_dump($xendit_res);
        // die;
        try {
            $data['order_id'] = $xendit_res['external_id'];
            $data['santri_id'] = $dt['santri_id'];
            $data['wali_id'] = $wali_id->id_wali_santri;
            $data['gross_amount'] = $dt['gross_amount'];
            $data['payment_type'] = 'credit_card';
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($order_id));
            $data['deadline'] = $expire->format(DateTimeInterface::ISO8601);

            $data['bank'] = 'CREDIT_CARD';
            $data['bank_account'] = $xendit_res['masked_card_number'];
            $data['payment_id'] = $xendit_res['id'];
            $data['status_paid'] = 200;
            $data['paid_at'] = date('Y-m-d H:i:s');

            $act = $this->TransaksiModel->create_bill_santri($data, $dt['product_id']);

            // echo $this->db->last_query();
            // $this->load->view('payment/successpage', $response);

            return $data;
        } catch (\Xendit\Exceptions\ApiException $e) {
            return $e->getMessage();
        }
    }
    // End Payment XENDIT
}
