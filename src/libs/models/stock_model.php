<?php

class Stock_Model extends Model
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

    public function stock_price_update($table, $data)
    {
        $products_id = $data['products_id'] ?? null;
        return $this->db->update($table, $data, "products_id = :products_id", ['products_id' => $products_id]);
    }

    public function saveDetail($sqls, $binds)
    {
        return $this->db->transact($sqls, $binds);
    }

    public function getSupplierAll()
    {
        $sql = "SELECT * FROM m_supplier ORDER BY id DESC;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getProductsBySupplierId($id)
    {
        $sql = "SELECT * FROM m_products WHERE supplier_id = :id ORDER BY id DESC;";
        $data = $this->db->select($sql, ['id' => (int)$id]);
        return $data;
    }

    public function getStockDetail($data)
    {
        $sql = "SELECT * FROM t_stock WHERE products_id = :products_id AND ";
        $sql .= "price = :price AND ";
        $sql .= "cost = :cost ";
        $sql .= "LIMIT 1;";
        $result = $this->db->select($sql, [
            'products_id' => $data['products_id'],
            'price' => $data['price'],
            'cost' => $data['cost'],
        ]);
        if (!empty($result)) {
            return $result[0];
        } else {
            return '';
        }
    }

    public function deleteStock($id)
    {
        $sql = "DELETE FROM t_stock WHERE id = :id;";
        $bind = array('id' => (int)$id);
        return $this->db->delete($sql, $bind);
    }

    public function getStockAll()
    {
        $sql = "SELECT SUM(s_stock.lot) as lot, SUM(s_stock.unit) as unit, m_products.name, m_products.image1_link, MAX(m_products.id) as products_id ";
        $sql .= "FROM s_stock LEFT JOIN m_products ON m_products.id = s_stock.products_id ";
        $sql .= "GROUP BY products_id ORDER BY MAX(s_stock.lot) DESC, MAX(s_stock.unit) DESC;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getStockById($id)
    {
        $sql = "SELECT s_stock.*, m_products.name ";
        $sql .= "FROM s_stock LEFT JOIN m_products ON m_products.id = s_stock.products_id ";
        $sql .= "WHERE s_stock.products_id = :id LIMIT 1;";
        $data = $this->db->select($sql, ['id' => (int)$id]);
        return $data;
    }

    public function getStockDeliveryById($id)
    {
        $sql = "SELECT t_stock_products.*, m_products.name, t_stock.delivery_at ";
        $sql .= "FROM t_stock_products LEFT JOIN m_products ON m_products.id = t_stock_products.products_id ";
        $sql .= "LEFT JOIN t_stock ON t_stock.id = t_stock_products.stock_id ";
        $sql .= "WHERE t_stock_products.products_id = :id ORDER BY delivery_at DESC;";
        $data = $this->db->select($sql, ['id' => (int)$id]);
        return $data;
    }

    public function getTaxRate()
    {
        $sql = "SELECT * FROM m_tax;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getAlreadyStock($data)
    {
        $sql = "SELECT * FROM s_stock ";
        $sql .= "WHERE products_id = :products_id AND ";
        $sql .= "cost = :cost AND ";
        $sql .= "postage_cost = :postage_cost;";
        $result = $this->db->select($sql, [
            'products_id' => $data['products_id'],
            'cost' => $data['cost'],
            'postage_cost' => $data['postage_cost'],
        ]);
        return $result;
    }
}
