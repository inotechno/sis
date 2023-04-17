<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductModel extends CI_Model
{
	var $table = 'products';

	function getAll($limit, $where = NULL)
	{
		$this->db->select('p.*, c.title as category_title, c.images as category_images');
		$this->db->join('category as c', 'p.category_id = c.id', 'LEFT');
		$this->db->order_by('title', 'asc');
		// $this->db->group_by('p.id');
		if ($where != NULL) {
			$this->db->where($where);
		}

		$this->db->limit($limit, 0);
		$this->db->from($this->table . ' as p');
		return $this->db->get();
	}

	function getById($id)
	{
		return $this->db->where('id', $id)->get($this->table);
	}

	function getByBarcode($barcode)
	{
		return $this->db->where('barcode', $barcode)->get($this->table);
	}

	public function getImages($id)
	{
		return $this->db->get_where('product_images', ['product_id' => $id]);
	}

	function add($data, $image)
	{
		$this->db->trans_start();
		$this->db->insert($this->table, $data);
		$product_id = $this->db->insert_id();

		$result = [];

		foreach ($image as $i => $value) {
			$result[] = array(
				'product_id' => $product_id,
				'file_name' => $value['file_name'],
			);
		}

		if (count($result) > 0) {
			$this->db->insert_batch('product_images', $result);
		}

		$this->db->trans_complete();

		return true;
	}

	function addImage($data)
	{
		return $this->db->insert('product_images', $data);
	}

	function update($id, $data)
	{
		return $this->db->update($this->table, $data, ['id' => $id]);
	}

	function delete($id)
	{
		return $this->db->delete($this->table, ['id' => $id]);
	}

	function count_all()
	{
		return $this->db->count_all_results($this->table);
	}

	function update_stok($id, $act, $val)
	{
		$stok_awal = $this->db->get_where($this->table, ['id' => $id])->row();
		if ($stok_awal->category_id == 7) { // Category Unit Usaha = 7
			$stok = 1;
		} else {
			if ($act == '+') {
				$stok = intval($stok_awal->stok) + intval($val);
			} else {
				$stok = intval($stok_awal->stok) - intval($val);
			}
		}

		$this->db->update($this->table, ['stok' => $stok], ['id' => $id]);
	}
}

/* End of file ProductModel.php */
/* Location: ./application/models/ProductModel.php */
