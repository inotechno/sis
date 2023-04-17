<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SembakoModel extends CI_Model
{
    var $table = 'sembako';
    var $table_items = 'sembako_detail';

    public function __construct()
    {
        parent::__construct();

        // Load Models - Model_1 and Model_2
        $this->load->model('ProductModel');
    }

    function GetSembako($where = null)
    {
        $this->db->select('
            s.id, 
            s.ustadz_id, 
            s.user_id, 
            s.tahun_ajaran_id,
            us.name as nama_ustadz,
            u.name as nama_pemberi,
            ta.tahun_ajaran,
            ta.semester
        ');

        $this->db->join('ustadz as ust', 'ust.id = s.ustadz_id', 'left');
        $this->db->join('users as us', 'us.id = ust.user_id', 'left');
        $this->db->join('users as u', 'u.id = s.user_id', 'left');
        $this->db->join('tahun_ajaran as ta', 'ta.id = s.tahun_ajaran_id', 'left');
        $this->db->where('ta.status', 1);

        if ($where != null)
            $this->db->where($where);

        $this->db->from($this->table . ' as s');
        return $this->db->get();
    }

    function create_sembako($data, $items)
    {
        $this->db->trans_start();
        $this->db->insert($this->table, $data);
        $bill_id = $this->db->insert_id();

        $result = array();

        foreach ($items as $i => $value) {
            $result[] = array(
                'sembako_id' => $bill_id,
                'product_id' => str_replace("'", "", htmlspecialchars($_POST['product_id'][$i], ENT_QUOTES)),
                'total_item' => str_replace("'", "", htmlspecialchars($_POST['total_item'][$i], ENT_QUOTES)),
            );

            $this->ProductModel->update_stok($_POST['product_id'][$i], '-', $_POST['total_item'][$i]);
        }

        $this->db->insert_batch($this->table_items, $result);
        $this->db->trans_complete();

        return true;
    }
}

/* End of file ProductModel.php */
/* Location: ./application/models/ProductModel.php */
