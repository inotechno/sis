<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProductModel');
        $this->load->library('pagination');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'store-ws', 'sub_menu_active' => 'product-ws']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/walisantri/product',
            'plugin' => 'plugins/walisantri/product',
            'css' => 'css/product',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $where = NULL;
        if (!empty($this->input->get('category_id'))) {
            $where['category_id'] =  str_replace("'", "", htmlspecialchars($this->input->get('category_id'), ENT_QUOTES));
        }

        $data = array();
        $limit = (!empty($this->input->get('limit'))) ? $this->input->get('limit') : NULL;

        $product = $this->ProductModel->getAll($limit, $where)->result();
        foreach ($product as $pr => $v) {
            $images = $this->ProductModel->getImages($v->id)->result();
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
                'updated_at' => $v->updated_at,
                'images' => $images,
            );
        }
        // echo $this->db->last_query($data);
        // die;
        echo json_encode($data);
    }

    public function getById($id)
    {
        $where_id = str_replace("'", "", htmlspecialchars($id, ENT_QUOTES));
        $data = $this->ProductModel->getById($where_id)->row();

        // echo $this->db->last_query($data);
        // die;
        echo json_encode($data);
    }

    public function GetByBarcode($barcode)
    {
        $where_id = str_replace("'", "", htmlspecialchars($barcode, ENT_QUOTES));
        $data = $this->ProductModel->getByBarcode($where_id)->row();

        // echo $this->db->last_query($data);
        // die;
        echo json_encode($data);
    }
}
