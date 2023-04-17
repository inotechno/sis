<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TransaksiModel');
        $this->load->model('WaliSantriModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'store-ws', 'sub_menu_active' => 'order-ws']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/walisantri/order',
            'plugin' => 'plugins/walisantri/order',
            'css' => 'css/order',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $id = $this->session->userdata('id');

        $where['b.wali_id'] = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');
        $list = $this->TransaksiModel->getOrder($where);

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ls) {
            if ($ls->status_paid == 203) {
                $action = '<a data-id="' . $ls->id . '" class="iq-bg-danger btn-delete" href="#" title="Delete"><i class="ri-delete-bin-line"></i></a>';
                $status = '<span class="badge iq-bg-danger">Belum dibayar</span>';
            } else if ($ls->status_paid == 201) {
                $action  = '';
                $status = '<span class="badge iq-bg-warning">Diproses</span>';
            } else if ($ls->status_paid == 200) {
                $action  = '';
                $status = '<span class="badge iq-bg-primary">Selesai</span>';
            } else {
                $action  = '';
                $status = '';
            }

            $row = array();
            $row[] = $ls->order_id;
            $row[] = $ls->nis;
            $row[] = $ls->name;
            $row[] = $ls->wali_santri;
            $row[] = $ls->gross_amount;
            $row[] = $status;
            $row[] = $this->TransaksiModel->count_item($ls->id)->row('total_item');
            $row[] = date('d-m-Y H:i:s', strtotime($ls->created_at));
            $row[] = '<div class="flex align-items-center list-user-action">
                        <a class="iq-bg-primary btn-view" href="' . site_url('Payment/invoice/' . $ls->order_id) . '" title="View"><i class="ri-eye-line"></i></a>
                        ' . $action . '
                    </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->TransaksiModel->count_all(),
            "recordsFiltered" => $this->TransaksiModel->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function add_cart()
    {
        $id = $this->session->userdata('id');

        $data['wali_id'] = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');
        $data['product_id'] = str_replace("'", "", htmlspecialchars($this->input->post('product_id'), ENT_QUOTES));

        $cart = $this->TransaksiModel->add_cart($data);
        if ($cart) {
            log_activity('insert', 'tambah cart', 'wali santri menambahkan produk kedalam keranjang');
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Produk berhasil di tambahkan kedalam keranjang.'
            );
        } else {
            $response = array(
                'type' => 'error',
                'title' => 'Gagal !!!',
                'message' => 'Produk berhasil di tambahkan kedalam keranjang !'
            );
        }

        echo json_encode($response);
    }
}
