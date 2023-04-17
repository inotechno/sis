<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MapelModel extends CI_Model
{
    var $table = 'mata_pelajaran';

    var $column_order = array(null, 'm.nama_mapel', 'm.tingkat', 'm.nilai_kkm');
    var $column_search = array('m.nama_mapel', 'm.tingkat'); //field yang diizin untuk pencarian 
    var $order = array('m.created_at' => 'desc'); // default order 

    // Datatable
    private function _get_datatables_query()
    {
        $this->db->from($this->table . ' as m');
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

    function getMapel()
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

    function GetMapelById($id)
    {
        $this->db->where('m.id', $id);
        $this->db->from($this->table . ' as m');

        return $this->db->get();
    }

    function GetMapelBySlug($slug)
    {
        $this->db->where('m.slug_mapel', $slug);
        $this->db->from($this->table . ' as m');

        return $this->db->get();
    }

    function all()
    {
        $this->db->from($this->table . ' as m');
        return $this->db->get();
    }

    function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}

/* End of file ProductModel.php */
/* Location: ./application/models/ProductModel.php */
