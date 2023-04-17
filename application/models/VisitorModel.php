<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VisitorModel extends CI_Model
{
    var $table = 'visitor_logs';

    var $column_order = array(null, 'v.tag_id', 'v.nama_lengkap', 'v.keterangan', 'v.date_in', 'v.date_out');
    var $column_search = array('v.tag_id', 'v.nama_lengkap', 'v.keterangan'); //field yang diizin untuk pencarian 
    var $order = array('v.date_in' => 'desc'); // default order 

    // Datatable
    private function _get_datatables_query()
    {
        $this->db->select('v.*, u.name as penerima');
        $this->db->join('users as u', 'u.id = v.user_id', 'LEFT');
        $this->db->from($this->table . ' as v');
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

    function GetVisitor()
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

    function GetAll($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->limit(1);
        $this->db->order_by('date_in', 'desc');
        return $this->db->get($this->table);
    }

    function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    function addTag($data)
    {
        return $this->db->insert('visitor_tags', $data);
    }

    function GetTagCheckIn()
    {
        $this->db->where('in_out', 0);
        $this->db->limit(1);
        return $this->db->get('visitor_tags');
    }

    function GetTagCheckOut()
    {
        $this->db->where('in_out', 1);
        $this->db->limit(1);
        return $this->db->get('visitor_tags');
    }


    function update($data, $tag_id)
    {
        return $this->db->update($this->table, $data, ['tag_id' => $tag_id, 'date_out' => null]);
    }
}

/* End of file CategoryModel.php */
/* Location: ./application/models/CategoryModel.php */
