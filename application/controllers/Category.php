<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CategoryModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'store', 'sub_menu_active' => 'category']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/category',
            'plugin' => 'plugins/category',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $data = $this->CategoryModel->getAll()->result();
        echo json_encode($data);
    }

    public function getById($id)
    {
        $where_id = str_replace("'", "", htmlspecialchars($id, ENT_QUOTES));
        $data = $this->CategoryModel->getById($where_id)->row();
        echo json_encode($data);
    }

    public function add()
    {
        $this->form_validation->set_rules('title', 'title', 'required|min_length[1]|max_length[255]');

        if ($this->form_validation->run() == true) {
            $data['title'] = str_replace("'", "", htmlspecialchars($this->input->post('title'), ENT_QUOTES));

            $act = $this->CategoryModel->add($data);
            if ($act) {
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data kategori berhasil ditambah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data kategori gagal ditambah !'
                );
            }
        } else {
            $response = array(
                'type' => 'error',
                'title' => 'Gagal !!!',
                'message' => validation_errors(),
            );
        }

        log_activity('insert', 'tambah kategori', 'tambah data kategori pada halaman kategori');
        echo json_encode($response);
    }

    public function update()
    {
        $this->form_validation->set_rules('title', 'title', 'required|min_length[1]|max_length[255]');

        if ($this->form_validation->run() == true) {
            $id = str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
            $data['title'] = str_replace("'", "", htmlspecialchars($this->input->post('title'), ENT_QUOTES));

            $act = $this->CategoryModel->update($id, $data);
            if ($act) {
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data kategori berhasil diubah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data kategori gagal diubah !'
                );
            }
        } else {
            $response = array(
                'type' => 'error',
                'title' => 'Gagal !!!',
                'message' => validation_errors(),
            );
        }

        log_activity(
            'update',
            'update kategori',
            'update data kategori pada halaman kategori'
        );
        echo json_encode($response);
    }

    public function delete()
    {
        $id = str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));

        $act = $this->CategoryModel->delete($id);
        if ($act) {
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data kategori berhasil dihapus.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data kategori gagal dihapus !'
            );
        }

        log_activity(
            'delete',
            'delete kategori',
            'delete data kategori pada halaman kategori'
        );
        echo json_encode($response);
    }

    public function count_product()
    {
        $data = $this->CategoryModel->count_product()->result();
        echo json_encode($data);
    }
}
