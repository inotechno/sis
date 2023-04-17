<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
    }

    public function all()
    {
        $data = $this->UserModel->getRoles()->result();
        echo json_encode($data);
    }
}
