<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LogModel extends CI_Model
{

    var $table = 'logs';

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
