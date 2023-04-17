
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RombelModel extends CI_Model
{
	var $table = 'rombel';
	var $table_santri = 'santri';

	var $column_order = array(null, 'k.nama_kelas', 'k.tingkat', 'ta.tahun_ajaran', 'ta.semester', 'u.name');
	var $column_search = array('k.nama_kelas', 'k.tingkat', 'ta.tahun_ajaran', 'ta.semester', 'u.name'); //field yang diizin untuk pencarian 
	var $order = array('k.created_at' => 'desc'); // default order 

	// Datatable
	private function _get_datatables_query()
	{
		$this->db->select('
            k.nama_kelas, 
            k.tingkat, 
            ta.tahun_ajaran, 
            u.name as nama_santri, 
            s.jenis_kelamin, 
            s.tag_id, 
            u.images, 
            s.tanggal_lahir,
            s.tempat_lahir, 
            k.id, 
            s.id as id_santri, 
            s.nis, 
            k.slug,
            ws.name as nama_wali');
		$this->db->join('kelas as k', 'k.id = r.kelas_id', 'left');
		$this->db->join('santri as s', 's.id = r.santri_id', 'left');
		$this->db->join('wali_santri as wali', 'wali.id = s.wali_id', 'left');
		$this->db->join('users as ws', 'ws.id = wali.user_id', 'left');
		$this->db->join('users as u', 'u.id = s.user_id', 'left');
		$this->db->join('tahun_ajaran as ta', 'ta.id = k.tahun_ajaran_id', 'left');
		$this->db->where('ta.status', 1);
		$this->db->from($this->table . ' as r');
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

	function getSantriRombel($where = null)
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

	// Datatable End

	function getAll($where = null)
	{
		$this->db->select('
            k.nama_kelas, 
            k.tingkat, 
            ta.tahun_ajaran, 
            u.name as nama_santri, 
            s.jenis_kelamin, 
            s.tag_id, 
            u.images, 
            s.tanggal_lahir,
            s.tempat_lahir, 
            k.id, 
            s.id as id_santri, 
            s.nis, 
            k.slug,
            ws.name as nama_wali');
		$this->db->join('kelas as k', 'k.id = r.kelas_id', 'left');
		$this->db->join('santri as s', 's.id = r.santri_id', 'left');
		$this->db->join('wali_santri as wali', 'wali.id = s.wali_id', 'left');
		$this->db->join('users as ws', 'ws.id = wali.user_id', 'left');
		$this->db->join('ustadz as us', 'us.id = k.wali_kelas_id', 'LEFT');
		$this->db->join('users as u', 'u.id = s.user_id', 'left');
		$this->db->join('tahun_ajaran as ta', 'ta.id = k.tahun_ajaran_id', 'left');
		if ($where != null) {
			$this->db->where($where);
		}
		$this->db->from($this->table . ' as r');
		return $this->db->get();
	}

	function getById($id)
	{
		return $this->db->where('id', $id)->get($this->table);
	}

	function GetRombelByKelas($id)
	{
		$this->db->select(
			'u.name as nama_santri, 
            s.id as id_santri, 
            s.tag_id, 
            s.nis, 
            s.jenis_kelamin, 
            k.nama_kelas, 
            k.tingkat, 
            k.slug, 
            ta.tahun_ajaran, 
            wk.name as wali_kelas, 
            k.id as id_kelas
            '
		);
		$this->db->join('kelas as k', 'k.id = r.kelas_id', 'LEFT');
		$this->db->join('santri as s', 's.id = r.santri_id', 'LEFT');
		$this->db->join('users as u', 'u.id = s.user_id', 'LEFT');
		$this->db->join('ustadz as us', 'us.id = k.wali_kelas_id', 'LEFT');
		$this->db->join('users as wk', 'wk.id = us.user_id', 'LEFT');
		$this->db->join('tahun_ajaran as ta', 'ta.id = k.tahun_ajaran_id', 'LEFT');
		$this->db->where('r.kelas_id', $id);

		$this->db->from($this->table . ' as r');
		return $this->db->get();
	}

	function GetSantriRombelById($id)
	{
		$this->db->select('u.name as nama_santri, s.id as id_santri, s.nis, s.jenis_kelamin, k.nama_kelas, k.tingkat, k.slug, ta.tahun_ajaran, ta.semester, wk.name as wali_kelas, k.id as id_kelas');
		$this->db->join('kelas as k', 'k.id = r.kelas_id', 'LEFT');
		$this->db->join('santri as s', 's.id = r.santri_id', 'LEFT');
		$this->db->join('users as u', 'u.id = s.user_id', 'LEFT');
		$this->db->join('ustadz as us', 'us.id = k.wali_kelas_id', 'LEFT');
		$this->db->join('users as wk', 'wk.id = us.user_id', 'LEFT');
		$this->db->join('tahun_ajaran as ta', 'ta.id = k.tahun_ajaran_id', 'LEFT');
		$this->db->where('s.id', $id);

		$this->db->from($this->table . ' as r');
		return $this->db->get();
	}

	function GetSantriHaveNotRombel()
	{
		$this->db->select('u.name as nama_santri, s.id as id_santri, s.nis, s.jenis_kelamin, k.nama_kelas, k.tingkat, k.slug, ta.tahun_ajaran, k.id as id_kelas');
		$this->db->join('rombel as r', 's.id = r.santri_id', 'LEFT');
		$this->db->join('kelas as k', 'k.id = r.kelas_id', 'LEFT');
		$this->db->join('users as u', 'u.id = s.user_id', 'LEFT');
		$this->db->join('tahun_ajaran as ta', 'ta.id = k.tahun_ajaran_id', 'LEFT');
		$this->db->where('k.id', null);
		if (!empty($this->input->get('nis'))) {
			$this->db->where('s.nis', $this->input->get('nis'));
		}

		$this->db->from('santri as s');
		return $this->db->get();
	}

	function add($data)
	{
		return $this->db->insert($this->table, $data);
	}

	function addAnggota($kelas, $santri)
	{
		foreach ($santri as $i => $value) {
			$data['kelas_id'] = $kelas;
			$data['santri_id'] = str_replace("'", "", htmlspecialchars($_POST['santri_id'][$i], ENT_QUOTES));

			$this->db->insert($this->table, $data);
		}

		return true;
	}

	function transferAnggota($data)
	{
		$this->delete($data['santri_id']);
		$this->db->insert($this->table, $data);

		return true;
	}

	function update($id, $data)
	{
		return $this->db->update($this->table, $data, ['id' => $id]);
	}

	function delete($id)
	{
		return $this->db->delete($this->table, ['santri_id' => $id]);
	}
}

/* End of file CategoryModel.php */
/* Location: ./application/models/CategoryModel.php */
