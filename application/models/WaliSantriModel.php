<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WaliSantriModel extends CI_Model
{
    var $table = 'users';
    var $table_parrent = 'wali_santri';

    var $column_order = array(null, 'u.name', 'u.email', 'o.nik', 'o.tempat_lahir', 'o.jenis_kelamin', 'o.tanggal_lahir');
    var $column_search = array('u.name', 'u.email', 'o.nik', 'o.tempat_lahir', 'o.jenis_kelamin', 'o.phone'); //field yang diizin untuk pencarian 
    var $order = array('u.created_at' => 'desc'); // default order 

    // Datatable
    private function _get_datatables_query()
    {
        $this->db->select('o.jenis_kelamin, o.nik,o.phone, o.id as id_orangtua, o.tempat_lahir, o.tanggal_lahir, u.name, u.email, u.id, u.role_id, u.status, u.images');
        $this->db->where('u.role_id', 4);
        $this->db->join($this->table_parrent . ' as o', 'o.user_id = u.id', 'left');
        $this->db->from($this->table . ' as u');
        $i = 0;

        foreach ($this->column_search as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function getOrangtua()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all()
    {
        return $this->db->count_all_results($this->table);
    }

    // Datatable End

    function all()
    {
        $this->db->select('o.jenis_kelamin, o.nik, o.phone, o.id as id_wali_santri, o.tempat_lahir, o.tanggal_lahir, u.name, u.email, u.id, u.role_id, u.status, u.images');
        $this->db->where('u.role_id', 4);
        $this->db->join($this->table_parrent . ' as o', 'o.user_id = u.id', 'left');
        $this->db->from($this->table . ' as u');
        return $this->db->get();
    }

    function GetUserById($id)
    {
        $this->db->select('o.jenis_kelamin, o.nik, o.phone, o.id as id_wali_santri, o.tempat_lahir, o.tanggal_lahir, u.name, u.email, u.id, u.role_id, u.status, u.images');
        $this->db->where('u.role_id', 4);
        $this->db->where('u.id', $id);
        $this->db->join($this->table_parrent . ' as o', 'o.user_id = u.id', 'left');
        $this->db->from($this->table . ' as u');

        return $this->db->get();
    }

    function add($data)
    {
        return $this->db->insert($this->table_parrent, $data);
    }

    function update($id, $data)
    {
        return $this->db->update($this->table_parrent, $data, ['user_id' => $id]);
    }

    function add_wali_santri($data)
    {
        return $this->db->insert('wali_santri_rel', $data);
    }
}

/* End of file ProductModel.php */
/* Location: ./application/models/ProductModel.php */
