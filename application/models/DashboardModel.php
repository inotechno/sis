<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends CI_Model
{
    function count_santri()
    {
        return $this->db->count_all_results('santri');
    }

    function count_wali_santri()
    {
        return $this->db->count_all_results('wali_santri');
    }

    function count_ustadz()
    {
        return $this->db->count_all_results('ustadz');
    }

    function count_produk()
    {
        return $this->db->count_all_results('products');
    }

    function count_invoice()
    {
        return $this->db->count_all_results('bills');
    }
}
