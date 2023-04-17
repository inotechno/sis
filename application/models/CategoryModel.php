<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CategoryModel extends CI_Model
{
    var $table = 'category';

    function getAll($where = NULL)
    {
        $this->db->select('c.*, COUNT(p.category_id) as total_product');
        $this->db->join('products as p', 'c.id = p.category_id', 'LEFT');
        if ($where != NULL) {
            $this->db->where($where);
        }
        $this->db->group_by('c.id');
        $this->db->from('category as c');
        return $this->db->get();
    }

    function getById($id)
    {
        return $this->db->where('id', $id)->get($this->table);
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

    function count_all()
    {
        return $this->db->count_all_results();
    }
}

/* End of file CategoryModel.php */
/* Location: ./application/models/CategoryModel.php */
