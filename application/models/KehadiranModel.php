<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KehadiranModel extends CI_Model
{
	var $table = 'absensi';

	var $column_order = array(null, 'm.nama_mapel', 'k.nama_kelas', 'u.name', 'j.hari', 'kd.status', 'kd.created_at');
	var $column_search = array('m.nama_mapel', 'k.nama_kelas', 'u.name', 'j.hari', 'kd.status'); //field yang diizin untuk pencarian 
	var $order = array('k.nama_kelas' => 'asc', 'j.hari' => 'asc', 'j.waktu_mulai' => 'asc', 'kd.created_at' => 'desc'); // default order 

	// Datatable
	private function _get_datatables_query()
	{
		// $this->db->select('SUM(IF(kd.status = "hadir", 1, 0)) AS hadir');
		// $this->db->select('SUM(IF(kd.status = "izin", 1, 0)) AS izin');
		// $this->db->select('SUM(IF(kd.status = "sakit", 1, 0)) AS sakit');
		// $this->db->select('SUM(IF(kd.status = "tidak hadir", 1, 0)) AS tidak_hadir');
		$this->db->select('k.nama_kelas, m.nama_mapel, u.name as nama_santri, k.tingkat, m.tingkat, j.hari, j.waktu_mulai, kd.id, j.id as id_jadwal, kd.status, kd.created_at, k.id as id_kelas, m.id as id_mapel, s.id as id_santri, s.nis');
		$this->db->join('jadwal as j', 'j.id = kd.jadwal_id', 'left');
		$this->db->join('santri as s', 's.id = kd.santri_id', 'left');
		$this->db->join('mata_pelajaran as m', 'm.id = j.mapel_id', 'left');
		$this->db->join('kelas as k', 'k.id = j.kelas_id', 'left');
		$this->db->join('users as u', 's.user_id = u.id', 'left');
		$this->db->group_by('j.mapel_id, kd.santri_id');

		if ($this->input->post('id_santri')) {
			$this->db->where('s.id', $this->input->post('id_santri'));
		}

		if ($this->input->post('id_jadwal')) {
			$this->db->where('j.id', $this->input->post('id_jadwal'));
		}

		$this->db->from($this->table . ' as kd');
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

	function getKehadiran($where = null)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		if ($where != null)
			$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
	}

	function getKehadiranByJadwal($jadwal)
	{
		$this->_get_datatables_query();
		// $this->db->select('COUNT(kd.santri_id) as jumlah_santri');
		// $this->db->where('kd.created_at')
		$this->db->where('kd.jadwal_id', $jadwal);
		$this->db->order_by('kd.created_at', 'desc');
		$this->db->group_by('kd.santri_id');

		$query = $this->db->get();
		return $query->result();
	}

	function _getKehadiranByJadwal($jadwal)
	{
		$this->db->select('k.nama_kelas, m.nama_mapel, u.name as nama_santri, k.tingkat, m.tingkat, j.hari, j.waktu_mulai, kd.id, j.id as id_jadwal, kd.status, kd.created_at, k.id as id_kelas, m.id as id_mapel, s.id as id_santri, s.nis');
		$this->db->join('jadwal as j', 'j.id = kd.jadwal_id', 'left');
		$this->db->join('santri as s', 's.id = kd.santri_id', 'left');
		$this->db->join('mata_pelajaran as m', 'm.id = j.mapel_id', 'left');
		$this->db->join('kelas as k', 'k.id = j.kelas_id', 'left');
		$this->db->join('users as u', 's.user_id = u.id', 'left');
		$this->db->from($this->table . ' as kd');
		$this->db->where('kd.jadwal_id', $jadwal);
		$this->db->group_by('kd.santri_id');

		return $this->db->get();
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
		$this->db->from($this->table . ' as kd');
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
