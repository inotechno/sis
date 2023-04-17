<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $config = $this->db->get('config')->result_array();
        foreach ($config as $cf) {
            define("_{$cf['name']}", $cf['value']);
        }
    }

    public function index()
    {

        $data = [
            'content' => 'components/auth/login',
            'plugin' => 'plugins/auth/login',
        ];

        $this->load->view('layouts/auth', $data);
    }
}
