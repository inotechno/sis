<?php

// function untuk menampilkan nama hari ini dalam bahasa indonesia
// di buat oleh malasngoding.com

function log_activity($event_type, $event_name, $event_description)
{
    $CI = &get_instance();

    if (!empty($CI->session->userdata('sub_menu_active'))) {
        $sub_menu = ' > ' . $CI->session->userdata('sub_menu_active');
    } else {
        $sub_menu = '';
    }

    $param['affected_user'] = $CI->session->userdata('name');
    $param['event_type'] = $event_type; //asset, asesoris, komponen, inventori
    $param['event_page'] = $CI->session->userdata('menu_active') . $sub_menu; //membuat, menambah, menghapus, mengubah,
    $param['event_name'] = $event_name; //nama item
    $param['event_description'] = $event_description; //target
    $param['ip_address'] = $CI->input->ip_address(); //target

    //load model log
    $CI->load->model('LogModel');

    //save to database
    $CI->LogModel->add($param);
}
