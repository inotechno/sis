<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Import extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KelasModel');
        $this->load->model('UserModel');
    }

    public function index()
    {
        $this->session->set_userdata(['menu_active' => 'master-data', 'sub_menu_active' => 'import-massal']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/import',
            'plugin' => 'plugins/import',
            'css' => 'css/import',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function preview_santri()
    {
        $path         = 'assets/documents/';
        $json         = [];
        $this->upload_config($path);
        if (!$this->upload->do_upload('template')) {
            $json = [
                'error_message' => $this->upload->display_errors(),
            ];
        } else {
            $file_data     = $this->upload->data();
            $file_name     = $path . $file_data['file_name'];
            $arr_file     = explode('.', $file_name);
            $extension     = end($arr_file);
            if ('csv' == $extension) {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet     = $reader->load($file_name);
            $sheet_data     = $spreadsheet->getActiveSheet()->toArray();

            unset($sheet_data[0]);

            $html = '';
            $total_data = 0;
            foreach ($sheet_data as $sd) {
                $html .= '<tr>
                            <td>' . $sd[1] . '</td>
                            <td>' . $sd[2] . '</td>
                            <td>' . $sd[3] . '</td>
                            <td>' . $sd[4] . '</td>
                            <td>' . $sd[5] . '</td>
                            <td>' . $sd[6] . '</td>
                            <td>' . $sd[7] . '</td>
                        </tr>';
            }
        }

        echo $html;
    }

    public function import_santri()
    {
        $this->load->model('SantriModel');
        $path         = 'assets/documents/';
        $json         = [];
        $this->upload_config($path);
        if (!$this->upload->do_upload('template')) {
            $json = [
                'error_message' => $this->upload->display_errors(),
            ];
        } else {
            $file_data     = $this->upload->data();
            $file_name     = $path . $file_data['file_name'];
            $arr_file     = explode('.', $file_name);
            $extension     = end($arr_file);
            if ('csv' == $extension) {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet     = $reader->load($file_name);
            $sheet_data     = $spreadsheet->getActiveSheet()->toArray();

            unset($sheet_data[0]);
            $user = array();
            $data = array();
            foreach ($sheet_data as $sd) {

                $cek_email = $this->UserModel->validasi(['email' => $sd[2]]);
                $check_nis = $this->SantriModel->GetSantriByNIS($sd[4]);

                if ($cek_email->num_rows() == 0 && $check_nis->num_rows() == 0) {
                    $user = array(
                        'name' => $sd[1],
                        'email' => $sd[2],
                        'password' => password_hash($sd[3], PASSWORD_DEFAULT),
                        'role_id' => 3,
                        'status' => 0,
                    );

                    $user = $this->UserModel->add($user);
                    $last_id = $this->db->insert_id();

                    log_activity('insert', 'tambah santri', 'tambah data santri pada halaman santri');

                    $data['user_id'] = $last_id;
                    $data['nis'] = $sd[4];
                    $data['jenis_kelamin'] = $sd[5];
                    $data['tempat_lahir'] = $sd[6];
                    $data['tanggal_lahir'] = date('Y-m-d', strtotime($sd[7]));

                    $santri = $this->SantriModel->add($data);

                    if ($santri) {
                        $response = array(
                            'type' => 'success',
                            'title' => 'Berhasil !!!',
                            'message' => 'Data santri berhasil ditambah.'
                        );
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
                        'message' => 'Terdapat data santri yang sama !.'
                    );
                }
            }
        }

        echo json_encode($response);
    }

    public function preview_wali_santri()
    {
        $path         = 'assets/documents/';
        $json         = [];
        $this->upload_config($path);
        if (!$this->upload->do_upload('template')) {
            $json = [
                'error_message' => $this->upload->display_errors(),
            ];
        } else {
            $file_data     = $this->upload->data();
            $file_name     = $path . $file_data['file_name'];
            $arr_file     = explode('.', $file_name);
            $extension     = end($arr_file);
            if ('csv' == $extension) {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet     = $reader->load($file_name);
            $sheet_data     = $spreadsheet->getActiveSheet()->toArray();

            unset($sheet_data[0]);

            $html = '';
            $total_data = 0;
            foreach ($sheet_data as $sd) {
                $html .= '<tr>
                            <td>' . $sd[1] . '</td>
                            <td>' . $sd[2] . '</td>
                            <td>' . $sd[3] . '</td>
                            <td>' . $sd[4] . '</td>
                            <td>' . $sd[5] . '</td>
                            <td>' . $sd[6] . '</td>
                            <td>' . $sd[7] . '</td>
                        </tr>';
            }
        }

        echo $html;
    }

    public function import_wali_santri()
    {
        $this->load->model('WaliSantriModel');
        $path         = 'assets/documents/';
        $json         = [];
        $this->upload_config($path);
        if (!$this->upload->do_upload('template')) {
            $json = [
                'error_message' => $this->upload->display_errors(),
            ];
        } else {
            $file_data     = $this->upload->data();
            $file_name     = $path . $file_data['file_name'];
            $arr_file     = explode('.', $file_name);
            $extension     = end($arr_file);
            if ('csv' == $extension) {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet     = $reader->load($file_name);
            $sheet_data     = $spreadsheet->getActiveSheet()->toArray();

            unset($sheet_data[0]);
            $user = array();
            $data = array();
            foreach ($sheet_data as $sd) {

                $cek_email = $this->UserModel->validasi(['email' => $sd[2]]);

                if ($cek_email->num_rows() == 0) {
                    $user = array(
                        'name' => $sd[1],
                        'email' => $sd[2],
                        'password' => password_hash($sd[3], PASSWORD_DEFAULT),
                        'role_id' => 4,
                        'status' => 1,
                    );

                    $user = $this->UserModel->add($user);
                    $last_id = $this->db->insert_id();

                    log_activity('insert', 'tambah wali santri', 'tambah data wali santri menggunakan import massal');

                    $data['user_id'] = $last_id;
                    $data['nik'] = $sd[4];
                    $data['jenis_kelamin'] = $sd[5];
                    $data['tempat_lahir'] = $sd[6];
                    $data['tanggal_lahir'] = date('Y-m-d', strtotime($sd[7]));

                    $santri = $this->WaliSantriModel->add($data);

                    if ($santri) {
                        $response = array(
                            'type' => 'success',
                            'title' => 'Berhasil !!!',
                            'message' => 'Data wali santri berhasil ditambah.'
                        );
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
                        'message' => 'Terdapat data wali santri yang sama !.'
                    );
                }
            }
        }

        echo json_encode($response);
    }

    public function preview_ustadz()
    {
        $path         = 'assets/documents/';
        $json         = [];
        $this->upload_config($path);
        if (!$this->upload->do_upload('template')) {
            $json = [
                'error_message' => $this->upload->display_errors(),
            ];
        } else {
            $file_data     = $this->upload->data();
            $file_name     = $path . $file_data['file_name'];
            $arr_file     = explode('.', $file_name);
            $extension     = end($arr_file);
            if ('csv' == $extension) {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet     = $reader->load($file_name);
            $sheet_data     = $spreadsheet->getActiveSheet()->toArray();

            unset($sheet_data[0]);

            $html = '';
            $total_data = 0;
            foreach ($sheet_data as $sd) {
                $html .= '<tr>
                            <td>' . $sd[1] . '</td>
                            <td>' . $sd[2] . '</td>
                            <td>' . $sd[3] . '</td>
                            <td>' . $sd[4] . '</td>
                            <td>' . $sd[5] . '</td>
                            <td>' . $sd[6] . '</td>
                            <td>' . $sd[7] . '</td>
                            <td>' . $sd[8] . '</td>
                        </tr>';
            }
        }

        echo $html;
    }

    public function import_ustadz()
    {
        $this->load->model('UstadzModel');
        $path         = 'assets/documents/';
        $json         = [];
        $this->upload_config($path);
        if (!$this->upload->do_upload('template')) {
            $json = [
                'error_message' => $this->upload->display_errors(),
            ];
        } else {
            $file_data     = $this->upload->data();
            $file_name     = $path . $file_data['file_name'];
            $arr_file     = explode('.', $file_name);
            $extension     = end($arr_file);
            if ('csv' == $extension) {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet     = $reader->load($file_name);
            $sheet_data     = $spreadsheet->getActiveSheet()->toArray();

            unset($sheet_data[0]);
            $user = array();
            $data = array();
            foreach ($sheet_data as $sd) {

                $cek_email = $this->UserModel->validasi(['email' => $sd[2]]);

                if ($cek_email->num_rows() == 0) {
                    $user = array(
                        'name' => $sd[1],
                        'email' => $sd[2],
                        'password' => password_hash($sd[3], PASSWORD_DEFAULT),
                        'role_id' => 5,
                        'status' => 1,
                    );

                    $user = $this->UserModel->add($user);
                    $last_id = $this->db->insert_id();

                    log_activity('insert', 'tambah ustadz', 'tambah data ustadz menggunakan import massal');

                    $data['user_id'] = $last_id;
                    $data['nip'] = $sd[4];
                    $data['nik'] = $sd[5];
                    $data['jenis_kelamin'] = $sd[6];
                    $data['tempat_lahir'] = $sd[7];
                    $data['tanggal_lahir'] = date('Y-m-d', strtotime($sd[8]);

                    $ustadz = $this->UstadzModel->add($data);

                    if ($ustadz) {
                        $response = array(
                            'type' => 'success',
                            'title' => 'Berhasil !!!',
                            'message' => 'Data ustadz berhasil ditambah.'
                        );
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
                        'message' => 'Terdapat data ustadz yang sama !.'
                    );
                }
            }
        }

        echo json_encode($response);
    }

    public function preview_mapel()
    {
        $path         = 'assets/documents/';
        $json         = [];
        $this->upload_config($path);
        if (!$this->upload->do_upload('template')) {
            $json = [
                'error_message' => $this->upload->display_errors(),
            ];
        } else {
            $file_data     = $this->upload->data();
            $file_name     = $path . $file_data['file_name'];
            $arr_file     = explode('.', $file_name);
            $extension     = end($arr_file);
            if ('csv' == $extension) {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet     = $reader->load($file_name);
            $sheet_data     = $spreadsheet->getActiveSheet()->toArray();

            unset($sheet_data[0]);

            $html = '';
            $total_data = 0;
            foreach ($sheet_data as $sd) {
                $slug = implode("-", explode(" ", trim(strtolower($sd[1]))));

                $html .= '<tr>
                            <td>' . $sd[1] . '</td>
                            <td>' . $sd[2] . '</td>
                            <td>' . $sd[3] . '</td>
                        </tr>';
            }
        }

        echo $html;
    }

    public function import_mapel()
    {
        $this->load->model('MapelModel');
        $path         = 'assets/documents/';
        $json         = [];
        $this->upload_config($path);
        if (!$this->upload->do_upload('template')) {
            $json = [
                'error_message' => $this->upload->display_errors(),
            ];
        } else {
            $file_data     = $this->upload->data();
            $file_name     = $path . $file_data['file_name'];
            $arr_file     = explode('.', $file_name);
            $extension     = end($arr_file);
            if ('csv' == $extension) {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet     = $reader->load($file_name);
            $sheet_data     = $spreadsheet->getActiveSheet()->toArray();

            unset($sheet_data[0]);
            $data = array();
            foreach ($sheet_data as $sd) {

                $data = array(
                    'nama_mapel' => $sd[1],
                    'tingkat' => $sd[2],
                    'slug_mapel' =>   implode("-", explode(" ", trim(strtolower($sd[1])))),
                    'nilai_kkm' =>  $sd[3],
                );

                $mapel = $this->MapelModel->add($data);

                if ($mapel) {
                    log_activity('insert', 'tambah mata pelajaran', 'tambah data mata pelajaran pada halaman mapel');
                    $response = array(
                        'type' => 'success',
                        'title' => 'Berhasil !!!',
                        'message' => 'Data mapel berhasil ditambah.'
                    );
                } else {
                    $response = array(
                        'type' => 'warning',
                        'title' => 'Gagal !!!',
                        'message' => 'Data mapel gagal ditambah !'
                    );
                }
            }
        }

        echo json_encode($response);
    }


    public function upload_config($path)
    {
        if (!is_dir($path))
            mkdir($path, 0777, TRUE);
        $config['upload_path']         = './' . $path;
        $config['allowed_types']     = 'csv|CSV|xlsx|XLSX|xls|XLS';
        $config['max_filename']         = '255';
        $config['encrypt_name']     = TRUE;
        $config['max_size']         = 4096;
        $this->load->library('upload', $config);
    }
}
