<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransaksiModel extends CI_Model
{
	var $table = 'bills';
	var $table_items = 'bill_items';

	var $column_order = array(null, 'b.gross_amount', 'b.order_id', 's.nis', 'u.name', 'b.order_id');
	var $column_search = array('b.gross_amount', 'b.order_id', 's.nis', 'u.name', 'b.order_id'); //field yang diizin untuk pencarian 
	var $order = array('b.created_at' => 'desc'); // default order 

	// Datatable
	private function _get_datatables_query()
	{
		$this->db->select('
            b.id, 
            b.gross_amount, 
            b.payment_id, 
            b.status_paid, 
            b.order_id,
            b.paid_at,
            b.payment_type,
            b.bank,
            b.bank_account,
            b.link,
            b.deadline,
            b.created_at,
            s.nis, 
            s.saldo, 
            u.name, 
            u.email, 
            u.id as user_id, 
            u.role_id,
            u.images,
            uws.name as wali_santri
        ');

		$this->db->join('wali_santri as ws', 'ws.id = b.wali_id', 'left');
		$this->db->join('santri as s', 's.id = b.santri_id', 'left');
		$this->db->join('users as uws', 'uws.id = ws.user_id', 'left');
		$this->db->join('users as u', 'u.id = s.user_id', 'left');
		$this->db->join('bill_items as bi', 'bi.bill_id = b.id', 'left');
		$this->db->group_by('b.id');
		$this->db->from($this->table . ' as b');
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

	public function __construct()
	{
		parent::__construct();

		// Load Models - Model_1 and Model_2
		$this->load->model('ProductModel');
	}

	function create_bill_santri($bill, $items)
	{
		$this->db->trans_start();
		$this->db->insert($this->table, $bill);
		$bill_id = $this->db->insert_id();

		$result = array();

		foreach ($items as $i => $value) {
			$result[] = array(
				'bill_id' => $bill_id,
				'product_id' => str_replace("'", "", htmlspecialchars($_POST['product_id'][$i], ENT_QUOTES)),
				'price' => str_replace("'", "", htmlspecialchars($_POST['price'][$i], ENT_QUOTES)),
				'total_item' => str_replace("'", "", htmlspecialchars($_POST['total_item'][$i], ENT_QUOTES)),
			);

			$this->ProductModel->update_stok($_POST['product_id'][$i], '-', $_POST['total_item'][$i]);
		}

		$this->db->insert_batch($this->table_items, $result);
		$this->db->trans_complete();

		return true;
	}

	function create_wallet_history($bill, $items)
	{
		$this->db->insert($this->table, $bill);
		$items['bill_id'] = $this->db->insert_id();

		return $this->db->insert('wallet_history', $items);
	}

	function create_spp($bill, $items)
	{
		$this->db->insert($this->table, $bill);
		$items['bill_id'] = $this->db->insert_id();

		return $this->db->insert('pembayaran_spp', $items);
	}

	function update($id, $data)
	{
		return $this->db->update($this->table, $data, ['id' => $id]);
	}

	function delete($id)
	{
		return $this->db->delete($this->table, ['id' => $id]);
	}

	function GetTransaction($where)
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
            u.images,
            SUM(bi.total_item) as total_item
        ');

		$this->db->join('santri as s', 's.id = b.santri_id', 'left');
		$this->db->join('users as u', 'u.id = s.user_id', 'left');
		$this->db->join('bill_items as bi', 'bi.bill_id = b.id', 'left');
		$this->db->group_by('bi.bill_id');
		if ($where != null)
			$this->db->where($where);

		$this->db->from($this->table . ' as b');
		return $this->db->get();
	}

	public function GetDetailTransaction($transaction_id)
	{
		$this->db->select('
            p.title, 
            p.barcode, 
            p.price,
			b.order_id,
			b.santri_id,
			b.wali_id
        ');

		$this->db->join('bills as b', 'b.id = bi.bill_id', 'LEFT');
		$this->db->join('products as p', 'bi.product_id = p.id', 'LEFT');
		$this->db->where('bi.bill_id', $transaction_id);
		$this->db->from($this->table_items . ' as bi');
		return $this->db->get();
	}


	function ReportTransaction($start, $end)
	{
		$this->db->select('
            b.id, 
            b.gross_amount, 
            b.payment_id, 
            b.status_paid, 
            b.order_id,
            b.wali_id,
            b.paid_at,
            b.payment_type,
            b.bank,
            b.bank_account,
            b.link,
            b.deadline,
            b.created_at,
            s.nis, 
            s.saldo, 
            u.name, 
            u.email, 
            u.id as user_id, 
            u.role_id,
            u.images,
            uws.name as wali_santri
        ');

		$this->db->join('wali_santri as ws', 'ws.id = b.wali_id', 'left');
		$this->db->join('santri as s', 's.id = b.santri_id', 'left');
		$this->db->join('users as uws', 'uws.id = ws.user_id', 'left');
		$this->db->join('users as u', 'u.id = s.user_id', 'left');
		$this->db->from($this->table . ' as b');
		$this->db->where('DATE(b.created_at) >= ', $start);
		$this->db->where('DATE(b.created_at) <= ', $end);
		return $this->db->get();
	}

	function GetTransactionBySantri($id)
	{
		$this->db->select('u.id, u.name, s.nis, s.saldo, s.tag_id, s.id as santri_id, s.user_id, b.id as bill_id, b.order_id, b.gross_amount, b.status_paid, b.paid_at, b.created_at');
		$this->db->where('b.status_paid', 203);
		$this->db->where('b.santri_id', $id);
		$this->db->join('santri as s', 's.id = b.santri_id', 'LEFT');
		$this->db->join('users as u', 'u.id = s.user_id', 'LEFT');
		$this->db->from($this->table . ' as b');
		return $this->db->get();
	}

	function add_cart($data)
	{
		return $this->db->insert('cart', $data);
	}

	function delete_cart($id)
	{
		return $this->db->delete('cart', ['id_cart' => $id]);
	}

	function getCart($where = null)
	{
		$this->db->select('p.*, u.name as nama_wali, ws.id as id_wali_santri, c.id_cart');
		$this->db->join('products as p', 'c.product_id = p.id', 'LEFT');
		$this->db->join('wali_santri as ws', 'c.wali_id = ws.id', 'LEFT');
		$this->db->join('users as u', 'u.id = ws.user_id', 'LEFT');
		$this->db->where('c.checkout_at', NULL);
		if ($where != null)
			$this->db->where($where);

		$this->db->from('cart as c');
		return $this->db->get();
	}

	function GetOrderDetail($where)
	{
		$this->db->select('b.*');
		$this->db->where($where);
		$this->db->from($this->table . ' as b');
		return $this->db->get();
	}

	function deleteCart($items)
	{
		foreach ($items as $i => $value) {
			$result[] = array(
				'id_cart' => str_replace("'", "", htmlspecialchars($_POST['id_cart'][$i], ENT_QUOTES)),
				'checkout_at' => date('Y-m-d H:i:s'),
			);
		}

		$this->db->update_batch('cart', $result, 'id_cart');
	}

	function count_item($bill_id)
	{
		$this->db->select('SUM(total_item) as total_item');
		$this->db->where('bill_id', $bill_id);
		return $this->db->get('bill_items');
	}
}

/* End of file ProductModel.php */
/* Location: ./application/models/ProductModel.php */
