<?php

class Supplier_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function update($table, $data)
    {
        return $this->db->update($table, $data, "id = :id");
    }

    public function getSupplierAll()
    {
        $sql = "SELECT * FROM m_supplier ORDER BY id DESC;";
        $data = $this->db->select($sql);
        return $data;
    }
}
