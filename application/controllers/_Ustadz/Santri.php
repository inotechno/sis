<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Santri extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SantriModel');
        $this->load->model('WaliSantriModel');
        $this->load->model('UserModel');
        $this->load->model('TagModel');
        $this->load->library('pagination');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'santri-us', 'sub_menu_active' => '']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/ustadz/santri',
            'plugin' => 'plugins/ustadz/santri',
            'css' => 'css/santri',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function show()
    {
        $this->load->model('UstadzModel');
        $this->load->model('RombelModel');
        $ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
        $where['k.wali_kelas_id'] = $ustadz->id_ustadz;

        $list = $this->RombelModel->getSantriRombel($where);

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ls) {
            if ($ls->jenis_kelamin == 'L') {
                $jk = 'Laki-laki';
            } else {
                $jk = 'Perempuan';
            }

            if ($ls->tag_id == NULL) {
                $tag = '<span class="badge badge-danger">Not Found </span>';
            } else {
                $tag = '<span class="badge iq-primary">' . $ls->tag_id . '</span>';
            }

            if (!empty($ls->images)) {
                $images = $ls->images;
            } else {
                $images = 'default.png';
            }

            $row = array();
            $row[] = '<img class="rounded-circle img-fluid avatar-40" src="' . base_url('assets/images/user/') . $images . '" alt="profile">';
            $row[] = '<span class="badge iq-primary">' . $ls->tag_id . '</span>';
            $row[] = $ls->nis;
            $row[] = $ls->nama_santri;
            $row[] = $ls->nama_kelas;
            $row[] = $ls->tempat_lahir . ', ' . date_indo(date('Y-m-d', strtotime($ls->tanggal_lahir)));
            $row[] = $jk;
            $row[] = $ls->nama_wali;

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

    public function GetUserById($id)
    {
        $data = $this->SantriModel->GetUserById(str_replace("'", "", htmlspecialchars($id, ENT_QUOTES)))->row();
        echo json_encode($data);
    }

    public function GetSantriByNIS($nis)
    {
        $data = $this->SantriModel->GetSantriByNIS(str_replace("'", "", htmlspecialchars($nis, ENT_QUOTES)))->row();
        echo json_encode($data);
    }

    public function GetSantriByWali()
    {
        $id = $this->session->userdata('id');

        $where['wali_id'] = $this->WaliSantriModel->GetUserById($id)->row('id_wali_santri');
        $data = $this->SantriModel->GetSantriByWali($where)->result();

        echo json_encode($data);
    }

    public function update()
    {
        $this->form_validation->set_rules('name', 'name', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('nis', 'nis', 'required|numeric');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');

        if ($this->form_validation->run() == true) {
            $id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
            $user['name'] = str_replace("'", "", htmlspecialchars($this->input->post('name'), ENT_QUOTES));
            $user['email'] = str_replace("'", "", htmlspecialchars($this->input->post('email'), ENT_QUOTES));

            $user = $this->UserModel->update($id, $user);

            if ($user) {
                log_activity('update', 'update santri', 'update data santri pada halaman santri');
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Data user berhasil diubah.'
                );

                $data['nis'] = str_replace("'", "", htmlspecialchars($this->input->post('nis'), ENT_QUOTES));
                $data['jenis_kelamin'] = str_replace("'", "", htmlspecialchars($this->input->post('jenis_kelamin'), ENT_QUOTES));
                $data['tempat_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tempat_lahir'), ENT_QUOTES));
                $data['tanggal_lahir'] = str_replace("'", "", htmlspecialchars($this->input->post('tanggal_lahir'), ENT_QUOTES));

                $santri = $this->SantriModel->update($id, $data);

                if ($santri) {
                    $response = array(
                        'type' => 'success',
                        'title' => 'Berhasil !!!',
                        'message' => 'Data santri berhasil diubah.'
                    );
                } else {
                    $response = array(
                        'type' => 'warning',
                        'title' => 'Gagal !!!',
                        'message' => 'Data santri gagal diubah !'
                    );
                }
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Data user gagal ditambah !'
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

    public function addBalance()
    {
        $this->form_validation->set_rules('saldo', 'saldo', 'required|numeric');

        if ($this->form_validation->run() == true) {
            $id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));

            $saldo_awal = $this->SantriModel->GetUserById($id)->row('saldo');

            $data['saldo'] = $saldo_awal + str_replace("'", "", htmlspecialchars($this->input->post('saldo'), ENT_QUOTES));


            $santri = $this->SantriModel->update($id, $data);

            if ($santri) {
                $response = array(
                    'type' => 'success',
                    'title' => 'Berhasil !!!',
                    'message' => 'Saldo berhasil ditambah !'
                );
            } else {
                $response = array(
                    'type' => 'warning',
                    'title' => 'Gagal !!!',
                    'message' => 'Gagal menambahkan saldo, silahkan coba kembali !'
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

    public function update_walisantri()
    {
        $id = str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));
        $data['wali_id'] = str_replace("'", "", htmlspecialchars($this->input->post('wali_id'), ENT_QUOTES));

        $santri = $this->SantriModel->update($id, $data);

        if ($santri) {
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data wali santri berhasil disimpan !.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data wali santri berhasil disimpan ! !'
            );
        }

        echo json_encode($response);
    }

    public function delete()
    {
        $id =  str_replace("'", "", htmlspecialchars($this->input->post('id'), ENT_QUOTES));

        $delete = $this->UserModel->delete($id);
        if ($delete) {
            log_activity('delete', 'delete santri', 'delete data santri pada halaman santri');
            $response = array(
                'type' => 'success',
                'title' => 'Berhasil !!!',
                'message' => 'Data santri berhasil diubah.'
            );
        } else {
            $response = array(
                'type' => 'warning',
                'title' => 'Gagal !!!',
                'message' => 'Data santri gagal diubah !'
            );
        }

        echo json_encode($response);
    }
}
