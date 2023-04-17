<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Maklumat extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MaklumatModel');
        $this->load->helper('upload');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'maklumat-ws', 'sub_menu_active' => '']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/walisantri/maklumat',
            'plugin' => 'plugins/walisantri/maklumat',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function getCategory()
    {
        $data = $this->MaklumatModel->getCategory()->result_array();
        echo json_encode($data);
    }

    public function all()
    {
        $where['p.role_id'] = $this->session->userdata('role_id');
        $data = $this->MaklumatModel->all($limit = null, $where)->result();
        echo json_encode($data);
    }

    public function GetMaklumatById($id)
    {
        $post = $this->MaklumatModel->GetMaklumatById(str_replace("'", "", htmlspecialchars($id, ENT_QUOTES)))->row();

        $data['id'] = $post->id;
        $data['title'] = $post->title;
        $data['category_slug'] = $post->category_slug;
        $data['role_id'] = $post->role_id;
        $data['content'] = htmlspecialchars_decode($post->content);
        echo json_encode($data);
    }
}
