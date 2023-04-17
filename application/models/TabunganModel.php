<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TabunganModel extends CI_Model
{
    var $table = 'tabungan';

    function GetTabunganBySantri($id)
    {
        $this->db->select('t.id, t.nominal, t.created_at, t.debit_kredit, u.name as nama_santri, s.nis, a.name as nama_penerima');
        $this->db->join('santri as s', 't.santri_id = s.id', 'LEFT');
        $this->db->join('users as a', 'a.id = t.user_id', 'LEFT');
        $this->db->join('users as u', 'u.id = s.user_id', 'LEFT');
        $this->db->where('t.santri_id', $id);
        $this->db->from($this->table . ' as t');
        return $this->db->get();
    }

    function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    function GetTabunganById($id)
    {
        $this->db->select('t.id, t.nominal, t.created_at, t.debit_kredit, u.name as nama_santri, s.nis, a.name as nama_penerima');
        $this->db->join('santri as s', 't.santri_id = s.id', 'LEFT');
        $this->db->join('users as a', 'a.id = t.user_id', 'LEFT');
        $this->db->join('users as u', 'u.id = s.user_id', 'LEFT');
        $this->db->where('t.id', $id);
        $this->db->from($this->table . ' as t');
        return $this->db->get();
    }

    function validasi($data)
    {
        $this->db->where('santri_id', $data['santri_id']);
        $this->db->where('tahun_ajaran_id', $data['tahun_ajaran_id']);
        $this->db->where('bulan', strtolower($data['bulan']));
        $this->db->from($this->table);
        return $this->db->get();
    }
}

/* End of file ProductModel.php */
/* Location: ./application/models/ProductModel.php */
