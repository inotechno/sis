<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ConfigModel extends CI_Model
{
    var $table = 'config';

    function all()
    {
        return  $this->db->get($this->table);
    }

    function update($data)
    {
        foreach ($data as $key => $value) {
            $this->db->update($this->table, ['value' => $value], ['name' => $key]);
        }

        return true;
    }
}

/* End of file ProductModel.php */
/* Location: ./application/models/ProductModel.php */
