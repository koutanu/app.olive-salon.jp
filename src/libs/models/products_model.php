<?php

class Products_Model extends Model
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
        $id = $data['id'] ?? null;
        return $this->db->update($table, $data, "id = :id", ['id' => $id]);
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM m_products ORDER BY id DESC;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getProductsById($id)
    {
        $sql = "SELECT * FROM m_products WHERE id = :id;";
        $data = $this->db->select($sql, ['id' => (int)$id]);
        return $data[0] ?? null;
    }

    public function deleteProducts($id)
    {
        $sql = "DELETE FROM m_products WHERE id = :id;";
        $bind = array('id' => (int)$id);
        return $this->db->delete($sql, $bind);
    }

    public function getSupplierAll()
    {
        $sql = "SELECT * FROM m_supplier ORDER BY id DESC;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getTaxRate()
    {
        $sql = "SELECT * FROM m_tax ORDER BY id DESC;";
        $data = $this->db->select($sql);
        return $data;
    }
}
