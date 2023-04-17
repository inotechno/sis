<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SPPModel extends CI_Model
{
    var $table = 'pembayaran_spp';
    var $table_items = 'bills';

    var $column_order = array(null, 'b.gross_amount', 'ps.amount', 's.nis', 'u.name', 'b.order_id');
    var $column_search = array('b.gross_amount', 'ps.amount', 's.nis', 'u.name', 'b.order_id'); //field yang diizin untuk pencarian 
    var $order = array('b.created_at' => 'desc'); // default order 

    // Datatable
    private function _get_datatables_query()
    {
        $this->db->select('
            b.id as id_bill, 
            b.gross_amount, 
            b.status_paid, 
            b.order_id,
            b.paid_at,
            b.created_at,
            s.nis, 
            s.saldo, 
            u.name, 
            u.email, 
            u.id as user_id, 
            u.role_id, 
            u.status, 
            u.images,
            ps.id,
            ps.nominal,
            ps.bulan,
            ps.tahun_ajaran_id,
            ps.status_code
        ');

        $this->db->join($this->table_items . ' as b', 'ps.bill_id = b.id', 'left');
        $this->db->join('santri as s', 's.id = b.santri_id', 'left');
        $this->db->join('users as u', 'u.id = s.user_id', 'left');
        $this->db->from($this->table . ' as ps');
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

        if (isset($_POST['status'])) {
            $status_paid = $_POST['status'];
            if ($status_paid == 'belum_dibayar') {
                $this->db->where('status_paid', 203);
            } else if ($status_paid == 'diproses') {
                $this->db->where('status_paid', 201);
            } else if ($status_paid == 'selesai') {
                $this->db->where('status_paid', 200);
            }
        }
    }

    function getOrder($where = null)
    {
        $this->_get_datatables_query();
        if ($where != null)
            $this->db->where($where);

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

    function GetSPPBySantri($id)
    {
        $this->db->select('ps.id, ps.nominal, ps.bulan, ps.status_code, ps.created_at as tanggal_bayar, ta.tahun_ajaran, ta.semester, u.name as nama_santri, s.nis, a.name as nama_penerima');
        $this->db->join('santri as s', 'ps.santri_id = s.id', 'LEFT');
        $this->db->join('tahun_ajaran as ta', 'ta.id = ps.tahun_ajaran_id', 'LEFT');
        $this->db->join('users as a', 'a.id = ps.user_id', 'LEFT');
        $this->db->join('users as u', 'u.id = s.user_id', 'LEFT');
        $this->db->where('ta.status', 1);
        $this->db->where('ps.santri_id', $id);
        $this->db->from($this->table . ' as ps');
        return $this->db->get();
    }

    function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    function update($data, $id)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    function GetSPPById($id)
    {
        $this->db->select('ps.id, ps.nominal, ps.bulan, ps.status_code, ps.created_at as tanggal_bayar, ta.tahun_ajaran, ta.semester, u.name as nama_santri, s.nis, a.name as nama_penerima');
        $this->db->join('santri as s', 'ps.santri_id = s.id', 'LEFT');
        $this->db->join('tahun_ajaran as ta', 'ta.id = ps.tahun_ajaran_id', 'LEFT');
        $this->db->join('users as a', 'a.id = ps.user_id', 'LEFT');
        $this->db->join('users as u', 'u.id = s.user_id', 'LEFT');
        $this->db->where('ps.id', $id);
        $this->db->from($this->table . ' as ps');
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
