<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProductModel');
        $this->load->library('pagination');
        $this->load->helper('upload');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'store', 'sub_menu_active' => 'product']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/product',
            'plugin' => 'plugins/product',
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
        // $data = [];
        $where_id = str_replace("'", "", htmlspecialchars($id, ENT_QUOTES));
        $data = $this->ProductModel->getById($where_id)->row();
        $data->images = $this->ProductModel->getImages($data->id)->result();

        // array_push($images, $data);
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

    public function add()
    {
        $image = array();
        $this->form_validation->set_rules('title', 'title', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('barcode', 'barcode', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('price', 'price', 'required|greater_than_equal_to[100]');
        $this->form_validation->set_rules('description', 'description', 'required|min_length[20]|max_length[255]');

        if ($this->form_validation->run() == true) {
            $data['title'] = str_replace("'", "", htmlspecialchars($this->input->post('title'), ENT_QUOTES));
            $data['barcode'] = str_replace("'", "", htmlspecialchars($this->input->post('barcode'), ENT_QUOTES));
            $data['price'] = str_replace("'", "", htmlspecialchars($this->input->post('price'), ENT_QUOTES));
            $data['stok'] = str_replace("'", "", htmlspecialchars($this->input->post('stok'), ENT_QUOTES));
            $data['satuan'] = str_replace("'", "", htmlspecialchars($this->input->post('satuan'), ENT_QUOTES));
            $data['description'] = str_replace("'", "", htmlspecialchars($this->input->post('description'), ENT_QUOTES));
            $data['category_id'] = str_replace("'", "", htmlspecialchars($this->input->post('category_id'), ENT_QUOTES));

            if (!empty($_FILES['image1']['name'])) {
                $upload = h_upload($_FILES['image1']['name'], 'assets/images/products', 'jpg|png|jpeg', '2048', 'image1');

                if (!empty($upload['success'])) {
                    $image[]['file_name'] = $upload['success']['file_name'];
                }
            }

            if (!empty($_FILES['image2']['name'])) {
                $upload = h_upload($_FILES['image2']['name'], 'assets/images/products', 'jpg|png|jpeg', '2048', 'image2');

                if (!empty($upload['success'])) {
                    $image[]['file_name'] = $upload['success']['file_name'];
                }
            }

            if (!empty($_FILES['image3']['name'])) {
                $upload = h_upload($_FILES['image3']['name'], 'assets/images/products', 'jpg|png|jpeg', '2048', 'image3');

                if (!empty($upload['success'])) {
                    $image[]['file_name'] = $upload['success']['file_name'];
                }
            }

            if (!empty($_FILES['image4']['name'])) {
                $upload = h_upload($_FILES['image4']['name'], 'assets/images/products', 'jpg|png|jpeg', '2048', 'image4');

                if (!empty($upload['success'])) {
                    $image[]['file_name'] = $upload['success']['file_name'];
                }
            }

            if (!empty($_FILES['image5']['name'])) {
                $upload = h_upload($_FILES['image5']['name'], 'assets/images/products', 'jpg|png|jpeg', '2048', 'image5');

                if (!empty($upload['success'])) {
                    $image[]['file_name'] = $upload['success']['file_name'];
                }
            }

            // var_dump($image);
            // die;
            $act = $this->ProductModel->add($data, $image);

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
        } else {
            $response = array(
                'type' => 'error',
                'title' => 'Gagal !!!',
                'message' => validation_errors(),
            );
        }

        log_activity('insert', 'Tambah Produk', 'Data produk pada admin');
        echo json_encode($response);
    }

    public function add_stok()
    {
        $this->form_validation->set_rules('stok', 'stok', 'required|min_length[1]|max_length[255]');

        if ($this->form_validation->run() == true) {
            $id = str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));

            $stok_awal = $this->ProductModel->getById($id)->row('stok');
            $data['stok'] = $stok_awal + str_replace("'", "", htmlspecialchars($this->input->post('stok'), ENT_QUOTES));

            $act = $this->ProductModel->update($id, $data);
            if ($act) {
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data stok berhasil ditambah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data stok berhasil ditambah !'
                );
            }
        } else {
            $response = array(
                'type' => 'error',
                'title' => 'Gagal !!!',
                'message' => validation_errors(),
            );
        }

        log_activity('update', 'update stok', 'Data produk pada admin');
        echo json_encode($response);
    }

    public function update()
    {
        $this->form_validation->set_rules('title', 'title', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('barcode', 'barcode', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('price', 'price', 'required|greater_than_equal_to[100]');
        $this->form_validation->set_rules('description', 'description', 'required|min_length[20]|max_length[255]');

        if ($this->form_validation->run() == true) {
            $id = str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
            $data['title'] = str_replace("'", "", htmlspecialchars($this->input->post('title'), ENT_QUOTES));
            $data['barcode'] = str_replace("'", "", htmlspecialchars($this->input->post('barcode'), ENT_QUOTES));
            $data['price'] = str_replace("'", "", htmlspecialchars($this->input->post('price'), ENT_QUOTES));
            $data['description'] = str_replace("'", "", htmlspecialchars($this->input->post('description'), ENT_QUOTES));
            $data['category_id'] = str_replace("'", "", htmlspecialchars($this->input->post('category_id'), ENT_QUOTES));

            $image['product_id'] = $id;
            if (!empty($_FILES['image1']['name'])) {
                $upload = h_upload($_FILES['image1']['name'], 'assets/images/products', 'jpg|png|jpeg', '2048', 'image1');

                if (!empty($upload['success'])) {
                    $image['file_name'] = $upload['success']['file_name'];
                }

                $insert = $this->ProductModel->addImage($image);
            }

            if (!empty($_FILES['image2']['name'])) {
                $upload = h_upload($_FILES['image2']['name'], 'assets/images/products', 'jpg|png|jpeg', '2048', 'image2');

                if (!empty($upload['success'])) {
                    $image['file_name'] = $upload['success']['file_name'];
                }

                $insert = $this->ProductModel->addImage($image);
            }

            if (!empty($_FILES['image3']['name'])) {
                $upload = h_upload($_FILES['image3']['name'], 'assets/images/products', 'jpg|png|jpeg', '2048', 'image3');

                if (!empty($upload['success'])) {
                    $image['file_name'] = $upload['success']['file_name'];
                }

                $insert = $this->ProductModel->addImage($image);
            }

            if (!empty($_FILES['image4']['name'])) {
                $upload = h_upload($_FILES['image4']['name'], 'assets/images/products', 'jpg|png|jpeg', '2048', 'image4');

                if (!empty($upload['success'])) {
                    $image['file_name'] = $upload['success']['file_name'];
                }

                $insert = $this->ProductModel->addImage($image);
            }

            if (!empty($_FILES['image5']['name'])) {
                $upload = h_upload($_FILES['image5']['name'], 'assets/images/products', 'jpg|png|jpeg', '2048', 'image5');

                if (!empty($upload['success'])) {
                    $image['file_name'] = $upload['success']['file_name'];
                }

                $insert = $this->ProductModel->addImage($image);
            }

            $act = $this->ProductModel->update($id, $data);
            if ($act) {
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data produk berhasil diubah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data produk gagal diubah !'
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
            'update produk',
            'Data produk pada admin'
        );
        echo json_encode($response);
    }

    public function delete()
    {
        $id = str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));

        $images = $this->ProductModel->getImages($id);

        if ($images->num_rows() > 0) {
            foreach ($images->result() as $img) {
                unlink('./assets/images/products/' . $img->file_name);
            }
        }

        $act = $this->ProductModel->delete($id);
        if ($act) {
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data produk berhasil dihapus.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data produk gagal dihapus !'
            );
        }

        log_activity('delete', 'delete produk', 'Data produk pada admin');
        echo json_encode($response);
    }

    public function removeImage()
    {
        $id = $this->input->post('id');
        $image = $this->db->get_where('product_images', ['id' => $id])->row();

        unlink('./assets/images/products/' . $image->file_name);
        $this->db->delete('product_images', ['id' => $id]);

        $response = array(
            'type' => 'success',
            'title' => 'Berhasil !!!',
            'message' => 'File berhasil di hapus !'
        );

        echo json_encode($response);
    }
}
