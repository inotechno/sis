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
        $this->session->set_userdata(['menu_active' => 'maklumat', 'sub_menu_active' => '']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/maklumat',
            'plugin' => 'plugins/maklumat',
            'css' => 'css/maklumat',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $list = $this->MaklumatModel->getMaklumat();

        $data = array();
        $no = $_POST['start'];
        $no = 1;
        foreach ($list as $ls) {
            if ($ls->status == 'draft') {
                $status = '<span class="badge badge-warning">Draft</span>';
            } else {
                $status = '<span class="badge badge-success">Posted</span>';
            }

            $row = array();
            $row[] = $no++;
            $row[] = $ls->title_excerpt;
            $row[] = substr(strip_tags(htmlspecialchars_decode($ls->content)), 0, 300);
            $row[] = $ls->category_name;
            $row[] = $ls->role_name;
            $row[] = $ls->user_name;
            $row[] = $status;
            $row[] = ' <div class="flex align-items-center list-maklumat-action">
                        <a data-id="' . $ls->id . '" class="iq-bg-success btn-post" href="#" title="Post"><i class="ri-upload-2-line"></i></a>
                        <a data-id="' . $ls->id . '" class="iq-bg-warning btn-update" href="#" title="Edit"><i class="ri-pencil-line"></i></a>
                        <a data-id="' . $ls->id . '" class="iq-bg-danger btn-delete" href="#" title="Delete"><i class="ri-delete-bin-line"></i></a>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->MaklumatModel->count_all(),
            "recordsFiltered" => $this->MaklumatModel->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function getCategory()
    {
        $data = $this->MaklumatModel->getCategory()->result_array();
        echo json_encode($data);
    }

    public function all()
    {
        $data = $this->MaklumatModel->all()->result();
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

    public function add()
    {
        $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required|min_length[5]');
        $this->form_validation->set_rules('tujuan', 'Tujuan', 'required');

        if ($this->form_validation->run() == true) {
            $data['title'] = str_replace("'", "", htmlspecialchars($this->input->post('title'), ENT_QUOTES));
            $data['content'] = htmlspecialchars($this->input->post('content'));
            $data['role_id'] = str_replace("'", "", htmlspecialchars($this->input->post('tujuan'), ENT_QUOTES));
            $data['user_id'] = $this->session->userdata('id');

            $data['title_excerpt'] = substr($data['title'], 0, 40);

            $data['slug'] = implode("-", explode(" ", trim(strtolower($data['title_excerpt']))));
            $category_slug = implode("-", explode(" ", trim(strtolower($this->input->post('category')))));

            $check_category = $this->MaklumatModel->getCategoryBySlug($category_slug);
            if ($check_category->num_rows() == 0) {
                $cat['title'] = str_replace("'", "", htmlspecialchars($this->input->post('category'), ENT_QUOTES));
                $cat['slug'] = implode("-", explode(" ", trim(strtolower($this->input->post('category')))));
                $data['category_id'] = $this->MaklumatModel->addCategoryByPost($cat);
            } else {
                $data['category_id'] = $check_category->row('id');
            }

            if (!empty($_FILES['thumbnail']['name'])) {
                $upload = h_upload($_FILES['thumbnail']['name'], 'assets/images/posts', 'jpg|png|jpeg', '2048', 'thumbnail');

                if (!empty($upload['success'])) {
                    $data['thumbnail'] = $upload['success']['file_name'];
                }
            }

            $maklumat = $this->MaklumatModel->add($data);

            if ($maklumat) {
                log_activity('insert', 'tambah maklumat', 'tambah data maklumat pada halaman maklumat');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data maklumat berhasil ditambah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data maklumat gagal ditambah !'
                );
            }
        } else {
            $response = array(
                'type' => 'error',
                'title' => 'Gagal !!!',
                'message' => validation_errors(),
            );
        }

        echo json_encode($response);
    }

    public function update()
    {
        $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required|min_length[5]');
        $this->form_validation->set_rules('tujuan', 'Tujuan', 'required');

        if ($this->form_validation->run() == true) {
            $id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
            $data['title'] = str_replace("'", "", htmlspecialchars($this->input->post('title'), ENT_QUOTES));
            $data['content'] = htmlspecialchars($this->input->post('content'), ENT_QUOTES);
            $data['role_id'] = str_replace("'", "", htmlspecialchars($this->input->post('tujuan'), ENT_QUOTES));
            $data['user_id'] = $this->session->userdata('id');

            $data['title_excerpt'] = substr($data['title'], 0, 40);

            $data['slug'] = implode("-", explode(" ", trim(strtolower($data['title_excerpt']))));
            $category_slug = implode("-", explode(" ", trim(strtolower($this->input->post('category')))));

            $check_category = $this->MaklumatModel->getCategoryBySlug($category_slug);
            if ($check_category->num_rows() == 0) {
                $cat['title'] = str_replace("'", "", htmlspecialchars($this->input->post('category'), ENT_QUOTES));
                $cat['slug'] = implode("-", explode(" ", trim(strtolower($this->input->post('category')))));
                $data['category_id'] = $this->MaklumatModel->addCategoryByPost($cat);
            } else {
                $data['category_id'] = $check_category->row('id');
            }

            if (!empty($_FILES['thumbnail']['name'])) {
                $upload = h_upload($_FILES['thumbnail']['name'], 'assets/images/posts', 'jpg|png|jpeg', '2048', 'thumbnail');

                if (!empty($upload['success'])) {
                    $data['thumbnail'] = $upload['success']['file_name'];
                }
            }

            $maklumat = $this->MaklumatModel->update($id, $data);

            if ($maklumat) {
                log_activity('update', 'update maklumat', 'update data maklumat pada halaman maklumat');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data maklumat berhasil diubah.'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data maklumat gagal ditambah !'
                );
            }
        } else {
            $response = array(
                'type' => 'error',
                'title' => 'Gagal !!!',
                'message' => validation_errors(),
            );
        }

        echo json_encode($response);
    }

    public function posting()
    {
        $id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
        $data['status'] = 'posted';

        $maklumat = $this->MaklumatModel->update($id, $data);

        if ($maklumat) {
            log_activity('update', 'update maklumat', 'posting maklumat pada halaman maklumat');
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Maklumat berhasil di posting'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Maklumat gagal di posting !'
            );
        }

        echo json_encode($response);
    }

    public function delete()
    {
        $id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));

        $delete = $this->MaklumatModel->delete($id);
        if ($delete) {
            log_activity('delete', 'delete maklumat', 'delete data maklumat pada halaman maklumat');
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data maklumat berhasil diubah.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data maklumat gagal diubah !'
            );
        }

        echo json_encode($response);
    }

    //Upload image summernote
    function upload_image()
    {
        if (!empty($_FILES['image']['name'])) {
            $upload = h_upload($_FILES["image"]["name"], 'assets/images/posts/', 'gif|jpg|png|jpeg', '1024', 'image');

            if (!empty($upload['success'])) {
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/images/posts/' . $upload['success']['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '60%';
                $config['width'] = 800;
                $config['height'] = 800;
                $config['new_image'] = './assets/images/posts/' . $upload['success']['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                echo base_url('assets/images/posts/' . $upload['success']['file_name']);
            } else {
                echo $this->upload->display_errors();
            }
        }
    }

    //Delete image summernote
    function delete_image()
    {
        $src = $this->input->post('src');
        $file_name = str_replace(base_url(), '', $src);
        if (unlink($file_name)) {
            echo 'File Delete Successfully';
        }
    }
}
