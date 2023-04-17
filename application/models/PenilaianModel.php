<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenilaianModel extends CI_Model
{
    var $table = 'raport';

    function GetRaportBySantri($id)
    {
        $this->db->select('p.id as id_raport, u.name as nama_santri, wk.nip, s.nis, k.nama_kelas, ta.tahun_ajaran, us.name as nama_ustadz, p.total_sakit, p.total_izin, p.total_tanpa_keterangan, p.naik_kelas, ta.semester, p.akhlak_kepribadian');
        $this->db->join('santri as s', 's.id = p.santri_id', 'LEFT');
        $this->db->join('rombel as r', 's.id = r.santri_id', 'LEFT');
        $this->db->join('kelas as k', 'k.id = r.kelas_id', 'LEFT');
        $this->db->join('users as u', 'u.id = s.user_id', 'LEFT');
        $this->db->join('ustadz as wk', 'wk.id = k.wali_kelas_id', 'LEFT');
        $this->db->join('users as us', 'us.id = wk.user_id', 'LEFT');
        $this->db->join('tahun_ajaran as ta', 'ta.id = p.tahun_ajaran_id', 'LEFT');
        $this->db->where('p.santri_id', $id);
        $this->db->from($this->table . ' as p');
        return $this->db->get();
    }

    function GetNilaiByRaport($id)
    {
        $this->db->select('m.nama_mapel, p.nilai_angka, p.id as id_penilaian, p.nilai_huruf, p.deskripsi, m.nilai_kkm');
        $this->db->join('mata_pelajaran as m', 'm.id = p.mapel_id', 'LEFT');
        $this->db->where('p.raport_id', $id);
        $this->db->from('penilaian as p');
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
