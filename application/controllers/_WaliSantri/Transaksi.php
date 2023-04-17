<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TransaksiModel');
        $this->load->model('WaliSantriModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'store-ws', 'sub_menu_active' => 'transaksi-ws']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/walisantri/transaksi',
            'plugin' => 'plugins/walisantri/transaksi',
            'css' => 'css/transaksi',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function getCart()
    {
        $id = $this->session->userdata('id');
        $data = array();

        $where['wali_id'] = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');
        $product  = $this->TransaksiModel->getCart($where)->result();

        // var_dump($product);
        // die;

        foreach ($product as $pr => $v) {
            $images = $this->ProductModel->getImages($v->id)->result();
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
                'images' => $images,
            );
        }

        echo json_encode($data);
    }

    public function checkout()
    {
        $id = $this->session->userdata('id');

        $where['wali_id'] = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');
        $bill['santri_id'] = str_replace("'", "", htmlspecialchars($this->input->post('santri_id'), ENT_QUOTES));
        $bill['order_id'] = date('dmYHis');
        $bill['gross_amount'] = str_replace("'", "", htmlspecialchars($this->input->post('amount'), ENT_QUOTES));

        $items = $this->input->post('product_id', true);

        $check_tagihan = $this->TransaksiModel->GetTransactionBySantri($bill['santri_id']);

        if ($check_tagihan->num_rows() > 0) {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Santri masih memiliki tagihan yang belum dibayar !'
            );
        } else {

            $act = $this->TransaksiModel->create_bill_santri($bill, $items);

            if ($act) {
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data Produk berhasil ditambah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data Produk gagal ditambah !'
                );
            }
        }

        echo json_encode($response);
    }
}
