<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SaldoModel extends CI_Model
{
    var $table = 'wallet_history';
    var $table_items = 'bills';

    var $column_order = array(null, 'b.gross_amount', 'w.amount', 's.nis', 'u.name', 'b.order_id');
    var $column_search = array('b.gross_amount', 'w.amount', 's.nis', 'u.name', 'b.order_id'); //field yang diizin untuk pencarian 
    var $order = array('b.created_at' => 'desc'); // default order 

    // Datatable
    private function _get_datatables_query()
    {
        $this->db->select('
            b.id, 
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
            w.amount,
            w.validation_at,
            w.validation_by
        ');

        $this->db->join($this->table_items . ' as b', 'w.bill_id = b.id', 'left');
        $this->db->join('santri as s', 's.id = b.santri_id', 'left');
        $this->db->join('users as u', 'u.id = s.user_id', 'left');
        $this->db->from($this->table . ' as w');
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

    function GetHistoryByIdBill($id)
    {
        $this->db->select('
            b.id, 
            b.gross_amount, 
            b.santri_id,
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
            w.amount,
            w.validation_at,
            w.validation_by
        ');

        $this->db->join($this->table_items . ' as b', 'w.bill_id = b.id', 'left');
        $this->db->join('santri as s', 's.id = b.santri_id', 'left');
        $this->db->join('users as u', 'u.id = s.user_id', 'left');
        $this->db->from($this->table . ' as w');
        $this->db->where('b.id', $id);
        return $this->db->get();
    }

    function update($data, $id)
    {
        $this->db->update($this->table, $data, ['bill_id' => $id]);
    }
}

/* End of file ProductModel.php */
/* Location: ./application/models/ProductModel.php */
