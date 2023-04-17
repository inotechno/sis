<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelasModel extends CI_Model
{
    var $table = 'kelas';
    var $table_rombel = 'rombel';
    var $table_santri = 'santri';

    var $column_order = array(null, 'k.nama_kelas', 'k.tingkat', 'ta.tahun_ajaran', 'ta.semester', 'u.name');
    var $column_search = array('k.nama_kelas', 'k.tingkat', 'ta.tahun_ajaran', 'ta.semester', 'u.name'); //field yang diizin untuk pencarian 
    var $order = array('k.created_at' => 'desc'); // default order 

    // Datatable
    private function _get_datatables_query()
    {
        $this->db->select('k.nama_kelas, k.tingkat, ta.tahun_ajaran, u.name as wali_kelas, k.id, k.slug');
        $this->db->join('ustadz as wk', 'wk.id = k.wali_kelas_id', 'left');
        $this->db->join('users as u', 'u.id = wk.user_id', 'left');
        $this->db->join('tahun_ajaran as ta', 'ta.id = k.tahun_ajaran_id', 'left');
        $this->db->where('ta.status', 1);
        $this->db->from($this->table . ' as k');
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

    function getKelas()
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

    function GetKelasById($id)
    {
        $this->db->select('k.nama_kelas, k.tingkat, ta.tahun_ajaran, ta.semester,, u.name as wali_kelas, wk.id as wali_kelas_id, ta.id as tahun_ajaran_id, k.id, k.slug');
        $this->db->join('ustadz as wk', 'wk.id = k.wali_kelas_id', 'left');
        $this->db->join('users as u', 'u.id = wk.user_id', 'left');
        $this->db->join('tahun_ajaran as ta', 'ta.id = k.tahun_ajaran_id', 'left');
        $this->db->where('k.id', $id);
        $this->db->from($this->table . ' as k');

        return $this->db->get();
    }

    function all($where = null)
    {
        $this->db->select('k.nama_kelas, k.tingkat, ta.tahun_ajaran, ta.semester, u.name as wali_kelas, wk.id as wali_kelas_id, ta.id as tahun_ajaran_id, k.id, k.slug');
        $this->db->join('ustadz as wk', 'wk.id = k.wali_kelas_id', 'left');
        $this->db->join('users as u', 'u.id = wk.user_id', 'left');
        $this->db->join('tahun_ajaran as ta', 'ta.id = k.tahun_ajaran_id', 'left');
        $this->db->from($this->table . ' as k');
        $this->db->where('ta.status', 1);
        if ($where != null) {
            $this->db->where($where);
        }
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
