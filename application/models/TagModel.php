<?php
defined('BASEPATH') or exit('No direct script access allowed');


class TagModel extends CI_Model
{
	var $table = 'tags';

	function GetTagLastTime()
	{
		$this->db->limit(1);
		$this->db->where('in_use', 0);
		$this->db->order_by('created_at', 'DESC');
		$this->db->from($this->table);
		return $this->db->get();
	}

	function insert($data)
	{
		return $this->db->insert($this->table, $data);
	}

	function update($id, $data)
	{
		return $this->db->update($this->table, $data, ['tag_id' => $id]);
	}

	function check_duplicate($tag_id)
	{
		return $this->db->get_where($this->table, ['tag_id' => $tag_id]);
	}
}

/* End of file ProductModel.php */
/* Location: ./application/models/ProductModel.php */
