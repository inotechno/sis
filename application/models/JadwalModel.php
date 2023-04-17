<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JadwalModel extends CI_Model
{
	var $table = 'jadwal';

	var $column_order = array(null, 'm.nama_mapel', 'k.nama_kelas', 'u.name', 'j.hari');
	var $column_search = array('m.nama_mapel', 'k.nama_kelas', 'u.name', 'j.hari'); //field yang diizin untuk pencarian 
	var $order = array('k.nama_kelas' => 'asc', 'j.hari' => 'asc', 'j.waktu_mulai' => 'asc'); // default order 

	// Datatable
	private function _get_datatables_query()
	{
		$this->db->select('k.nama_kelas, m.nama_mapel, u.name as nama_ustadz, k.tingkat, m.tingkat, j.hari, j.waktu_mulai, j.id, k.id as id_kelas, m.id as id_mapel, us.id as id_ustadz');
		$this->db->join('mata_pelajaran as m', 'm.id = j.mapel_id', 'left');
		$this->db->join('kelas as k', 'k.id = j.kelas_id', 'left');
		$this->db->join('ustadz as us', 'us.id = j.ustadz_id', 'left');
		$this->db->join('users as u', 'us.user_id = u.id', 'left');
		$this->db->from($this->table . ' as j');
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

	function getJadwal($where = null)
	{
		$this->_get_datatables_query();
		if ($where != null) {
			$this->db->where($where);
		}
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
		$this->db->where('j.id', $id);
		$this->db->from($this->table . ' as j');

		return $this->db->get();
	}

	public function GetJadwalUstadz($where)
	{
		$this->db->select('k.nama_kelas, m.nama_mapel, u.name as nama_ustadz, k.tingkat, m.tingkat, j.hari, j.waktu_mulai, j.id, k.id as id_kelas, m.id as id_mapel, us.id as id_ustadz');
		$this->db->join('mata_pelajaran as m', 'm.id = j.mapel_id', 'left');
		$this->db->join('kelas as k', 'k.id = j.kelas_id', 'left');
		$this->db->join('ustadz as us', 'us.id = j.ustadz_id', 'left');
		$this->db->join('users as u', 'us.user_id = u.id', 'left');
		$this->db->from($this->table . ' as j');
		$this->db->where($where);
		return $this->db->get();
	}

	function GetJadwalById($id)
	{
		$this->db->select('k.nama_kelas, m.nama_mapel, u.name as nama_ustadz, k.tingkat, m.tingkat, j.hari, j.waktu_mulai, j.id, k.id as id_kelas, m.id as id_mapel, us.id as id_ustadz');
		$this->db->join('mata_pelajaran as m', 'm.id = j.mapel_id', 'left');
		$this->db->join('kelas as k', 'k.id = j.kelas_id', 'left');
		$this->db->join('ustadz as us', 'us.id = j.ustadz_id', 'left');
		$this->db->join('users as u', 'us.user_id = u.id', 'left');
		$this->db->from($this->table . ' as j');
		$this->db->where('j.id', $id);
		return $this->db->get();
	}

	function validasi_duplicate($data)
	{
		$this->db->select('*, ADDTIME(waktu_mulai, "0:59:00") as waktu_selesai');
		$this->db->where('hari', $data['hari']);
		$this->db->where('mapel_id', $data['mapel_id']);
		$this->db->where('kelas_id', $data['kelas_id']);
		$this->db->where('TIME(waktu_mulai) <= ', DATE('H:i', strtotime($data['waktu_mulai']) + 60 * 60));
		$this->db->order_by('waktu_mulai', 'desc');
		$this->db->limit(1);
		$this->db->from($this->table);
		return $this->db->get();
	}

	function all()
	{
		$this->db->from($this->table . ' as j');
		return $this->db->get();
	}

	function GetJadwalByKelasAndHari($kelas, $hari)
	{
		$waktu = date('H:i');

		$this->db->where('hari', $hari);
		$this->db->where('kelas_id', $kelas);
		$this->db->where('date_add(waktu_mulai, interval 30 minute) >= ', $waktu);
		$this->db->from($this->table);
		return $this->db->get();
	}

	function GetJadwalWaktuIni($hari, $ustadz)
	{
		$waktu = date('H:i', strtotime('+20 minutes'));

		// echo $waktu;
		$this->db->select('k.nama_kelas, m.nama_mapel, u.name as nama_ustadz, k.tingkat, m.tingkat, j.hari, j.waktu_mulai, j.id, k.id as id_kelas, m.id as id_mapel, us.id as id_ustadz');
		$this->db->join('mata_pelajaran as m', 'm.id = j.mapel_id', 'left');
		$this->db->join('kelas as k', 'k.id = j.kelas_id', 'left');
		$this->db->join('ustadz as us', 'us.id = j.ustadz_id', 'left');
		$this->db->join('users as u', 'us.user_id = u.id', 'left');
		$this->db->from($this->table . ' as j');
		$this->db->where('j.hari', $hari);
		$this->db->where('j.ustadz_id', $ustadz);
		$this->db->where('j.waktu_mulai <= ', $waktu);
		$this->db->order_by('j.waktu_mulai', 'desc');
		$this->db->limit(1);

		return $this->db->get();
	}

	function GetJadwalByKelas($kelas)
	{
		$waktu = date('H:i');
		$this->db->select('k.nama_kelas, m.nama_mapel, m.slug_mapel, u.name as nama_ustadz, k.tingkat, m.tingkat, j.hari, j.waktu_mulai, j.id, k.id as id_kelas, m.id as id_mapel, us.id as id_ustadz');
		$this->db->join('mata_pelajaran as m', 'm.id = j.mapel_id', 'left');
		$this->db->join('kelas as k', 'k.id = j.kelas_id', 'left');
		$this->db->join('ustadz as us', 'us.id = j.ustadz_id', 'left');
		$this->db->join('users as u', 'us.user_id = u.id', 'left');
		$this->db->from($this->table . ' as j');
		$this->db->where('j.kelas_id', $kelas);
		return $this->db->get();
	}

	function GetMapelByWaliKelas($id)
	{
		$waktu = date('H:i');
		$this->db->select('k.nama_kelas, m.nama_mapel, m.slug_mapel, u.name as nama_ustadz, k.tingkat, m.tingkat, j.hari, j.waktu_mulai, j.id, k.id as id_kelas, m.id as id_mapel, us.id as id_ustadz');
		$this->db->join('mata_pelajaran as m', 'm.id = j.mapel_id', 'left');
		$this->db->join('kelas as k', 'k.id = j.kelas_id', 'left');
		$this->db->join('ustadz as us', 'us.id = j.ustadz_id', 'left');
		$this->db->join('users as u', 'us.user_id = u.id', 'left');
		$this->db->from($this->table . ' as j');
		$this->db->where('k.wali_kelas_id', $id);
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
