<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SantriModel extends CI_Model
{
	var $table = 'users';
	var $table_santri = 'santri';

	var $column_order = array(null, 'u.name', 's.nis', 'u.email', 's.tempat_lahir', 's.jenis_kelamin', 's.tanggal_lahir', 's.tag_id');
	var $column_search = array('u.name', 's.nis', 'u.email', 's.tempat_lahir', 's.jenis_kelamin', 's.tag_id'); //field yang diizin untuk pencarian 
	var $order = array('u.created_at' => 'desc'); // default order 

	// Datatable
	private function _get_datatables_query()
	{
		$this->db->select('
            s.nis, 
            s.jenis_kelamin, 
            s.id as id_santri, 
            s.tempat_lahir, 
            s.saldo, 
            s.tag_id, 
            s.tanggal_lahir, 
            u.name, 
            u.email, 
            u.id, 
            u.role_id, 
            u.status, 
            u.images');
		$this->db->where('u.role_id', 3);
		$this->db->join('santri as s', 's.user_id = u.id', 'left');
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

	function getSantri($where = null)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		if ($where != null)
			$this->db->where($where);

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

	function check_duplicate_tag($tag_id)
	{
		return $this->db->get_where($this->table_santri, ['tag_id' => $tag_id]);
	}

	// Datatable End

	function GetUserById($id)
	{
		$this->db->select('s.id as id_santri, s.nis, s.jenis_kelamin, s.tempat_lahir, s.tanggal_lahir, s.tag_id, s.wali_id, s.saldo, u.name, u.email, u.id, u.role_id, u.status, u.images');
		$this->db->where('u.role_id', 3);
		$this->db->where('u.id', $id);
		$this->db->join('santri as s', 's.user_id = u.id', 'left');
		$this->db->from($this->table . ' as u');

		return $this->db->get();
	}

	function GetSantriByNIS($nis)
	{
		$this->db->select('s.id as id_santri, s.nis, s.jenis_kelamin, s.tempat_lahir, s.tanggal_lahir, s.tag_id, s.wali_id, s.saldo , u.name, u.email, u.id, u.role_id, u.status, u.images');
		$this->db->where('u.role_id', 3);
		$this->db->where('s.nis', $nis);
		$this->db->join('santri as s', 's.user_id = u.id', 'left');
		$this->db->from($this->table . ' as u');

		return $this->db->get();
	}

	function GetSantriByTag($tag)
	{
		$this->db->select('s.id as id_santri, s.nis, s.jenis_kelamin, s.tempat_lahir, s.tanggal_lahir, s.tag_id, s.wali_id, s.saldo , u.name, u.email, u.id, u.role_id, u.status, u.images');
		$this->db->where('u.role_id', 3);
		$this->db->where('s.tag_id', $tag);
		$this->db->join('santri as s', 's.user_id = u.id', 'left');
		$this->db->from($this->table . ' as u');

		return $this->db->get();
	}

	function GetSantriByTagId($tag)
	{
		$this->db->select('s.id as id_santri, s.nis, s.tag_id, u.name as nama_santri, k.id as id_kelas, k.nama_kelas, k.tingkat');
		$this->db->join($this->table_santri . ' as s', 's.user_id = u.id', 'left');
		$this->db->join('rombel as r', 'r.santri_id = s.id', 'LEFT');
		$this->db->join('kelas as k', 'k.id = r.kelas_id', 'LEFT');
		$this->db->where('s.tag_id', $tag);
		$this->db->from($this->table . ' as u');

		return $this->db->get();
	}

	function GetSantriByWali($where = null)
	{
		$this->db->select('s.id as id_santri, s.nis, s.jenis_kelamin, s.tempat_lahir, s.tanggal_lahir, s.tag_id, s.wali_id, s.saldo , u.name, u.email, u.id, u.role_id, u.status, u.images');
		$this->db->where('u.role_id', 3);
		if ($where != null) {
			$this->db->where($where);
		}
		$this->db->join('santri as s', 's.user_id = u.id', 'left');
		$this->db->from($this->table . ' as u');

		return $this->db->get();
	}

	function GetSantriById($where = null)
	{
		$this->db->select('s.id as id_santri, s.nis, s.jenis_kelamin, s.tempat_lahir, s.tanggal_lahir, s.tag_id, s.wali_id, s.saldo , u.name, u.email, u.id, u.role_id, u.status, u.images');
		$this->db->where('u.role_id', 3);
		if ($where != null) {
			$this->db->where($where);
		}
		$this->db->join('santri as s', 's.user_id = u.id', 'left');
		$this->db->from($this->table . ' as u');

		return $this->db->get();
	}

	function add($data)
	{
		return $this->db->insert($this->table_santri, $data);
	}

	function update($id, $data)
	{
		return $this->db->update($this->table_santri, $data, ['user_id' => $id]);
	}
}

/* End of file ProductModel.php */
/* Location: ./application/models/ProductModel.php */
