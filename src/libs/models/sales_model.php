<?php

class Sales_Model extends Model
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

    public function getCustomerById($id)
    {
        $sql = "SELECT * FROM m_customer WHERE id = " . $id . ";";
        $data = $this->db->select($sql);
        return $data[0];
    }

    public function getMenuListAll()
    {
        $sql = "SELECT * FROM m_menu ORDER BY order_no;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getOptionListAll()
    {
        $sql = "SELECT * FROM m_menu_option;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getSalesToMonth($date)
    {
        $sql = "SELECT t_sales.*, m_customer.name ";
        $sql .= "FROM t_sales ";
        $sql .= "LEFT JOIN m_customer ON m_customer.id = t_sales.customer_id ";
        $sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m') = '" . $date . "' ";
        $sql .= "ORDER BY t_sales.created_at DESC;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getSalesById($id)
    {
        $sql = "SELECT * FROM t_sales WHERE customer_id = " . $id . " ORDER BY created_at DESC;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getSalesLastByIdNotCancel($id)
    {
        $sql = "SELECT * FROM t_sales WHERE customer_id = " . $id . " ORDER BY created_at DESC LIMIT 1;";
        $data = $this->db->select($sql);
        if (!empty($data)) {
            return $data[0];
        }
    }

    public function saveDetail($sqls, $binds)
    {
        return $this->db->transact($sqls, $binds);
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM m_products ORDER BY id DESC;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getGrossProfitMonthly()
    {
        $sql = "SELECT SUM(sales + products_gross_profit) AS gross_profit, MAX(created_at) AS created_at ";
        $sql .= "FROM t_sales ";
        $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getMenuGrossProfitMonthly()
    {
        $sql = "SELECT SUM(sales) AS gross_profit, MAX(created_at) AS created_at ";
        $sql .= "FROM t_sales ";
        $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getProductsGrossProfitMonthly()
    {
        $sql = "SELECT SUM(products_gross_profit) AS gross_profit, MAX(created_at) AS created_at ";
        $sql .= "FROM t_sales ";
        $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getSalesDetailById($id)
    {
        $sql = "SELECT t_sales.*, m_customer.name as customer_name, m_menu.name as menu_name FROM t_sales ";
        $sql .= "LEFT JOIN m_customer ON t_sales.customer_id = m_customer.id ";
        $sql .= "LEFT JOIN t_sales_products ON t_sales.id = t_sales_products.sales_id ";
        $sql .= "LEFT JOIN m_menu ON t_sales.menu_id = m_menu.id ";
        $sql .= "WHERE t_sales.id = " . $id . " LIMIT 1;";
        $data = $this->db->select($sql);
        return $data[0];
    }

    public function getGrossProfitMonthlyById($id)
    {
        $sql = "SELECT SUM(sales + products_total_sales) AS gross_profit, MAX(created_at) AS created_at ";
        $sql .= "FROM t_sales WHERE customer_id = " . $id . " ";
        $sql .= "AND DATE_FORMAT(t_sales.created_at, '%Y%m%d') >= '" . date('Ym01', strtotime("-1 year")) . "' GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getMenuGrossProfitMonthlyById($id)
    {
        $sql = "SELECT SUM(sales) AS gross_profit, MAX(created_at) AS created_at ";
        $sql .= "FROM t_sales WHERE customer_id = " . $id . " ";
        $sql .= "AND DATE_FORMAT(t_sales.created_at, '%Y%m%d') >= '" . date('Ym01', strtotime("-1 year")) . "' GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getProductsGrossProfitMonthlyById($id)
    {
        $sql = "SELECT SUM(t_sales_products.price) AS gross_profit, SUM(t_sales_products.cost) AS cost, MAX(created_at) AS created_at ";
        $sql .= "FROM t_sales ";
        $sql .= "LEFT JOIN t_sales_products ON t_sales_products.sales_id = t_sales.id ";
        $sql .= "WHERE customer_id = " . $id . " ";
        $sql .= "AND DATE_FORMAT(t_sales.created_at, '%Y%m%d') >= '" . date('Ym01', strtotime("-1 year")) . "' GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getSalesProductsById($id)
    {
        $sql = "SELECT t_sales_products.*, m_products.name, s_stock.cost, s_stock.max_unit, m_tax.tax_rate, s_stock.postage_cost ";
        $sql .= "FROM t_sales_products ";
        $sql .= "LEFT JOIN s_stock ON s_stock.id = t_sales_products.stock_id ";
        $sql .= "LEFT JOIN m_products ON m_products.id = s_stock.products_id ";
        $sql .= "LEFT JOIN m_tax ON m_tax.id = s_stock.tax_id ";
        $sql .= "WHERE sales_id = " . $id . ";";
        $data = $this->db->select($sql);
        return $data;
    }

    public function deleteSales($id)
    {
        $sql = "DELETE FROM t_sales WHERE id = :id;";
        $bind = array('id' => $id);
        return $this->db->delete($sql, $bind);
    }

    public function getAllStock()
    {
        $sql = "SELECT SUM(s_stock.lot) as lot, SUM(s_stock.unit) as unit, MAX(m_products.name) as name, MAX(s_stock.price) as price, MAX(s_stock.max_unit) as max_unit, ";
        $sql .= "s_stock.products_id, MAX(s_stock.id) as id, m_products.unit as products_unit, MAX(s_stock.tax_id) as tax_id ";
        $sql .= "FROM s_stock ";
        $sql .= "LEFT JOIN m_products ON m_products.id = s_stock.products_id ";
        $sql .= "WHERE s_stock.lot > 0 OR s_stock.unit > 0 GROUP BY products_id ORDER BY m_products.id DESC;";
        return $this->db->select($sql);
    }

    public function getStockLotById($id)
    {
        $sql = "SELECT * FROM s_stock WHERE NOT lot <= 0 AND products_id = " . $id . " ORDER BY delivery_at DESC LIMIT 1;";
        $data = $this->db->select($sql);
        return $data[0];
    }

    public function getStockUnitById($id)
    {
        $sql = "SELECT * FROM s_stock WHERE NOT (lot <= 0 AND unit <= 0) AND products_id = " . $id . " ORDER BY unit DESC, delivery_at DESC LIMIT 1;";
        $data = $this->db->select($sql);
        return $data[0];
    }

    public function getTaxRate()
    {
        $sql = "SELECT * FROM m_tax;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getMenuOptionById($id)
    {
        $sql = "SELECT * FROM t_sales_menu_option LEFT JOIN m_menu_option ON m_menu_option.id = t_sales_menu_option.menu_option_id WHERE sales_id = " . $id . ";";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getProductsGrossProfitByDate($date)
    {
        $sql = "SELECT SUM(t_sales_products.price - t_sales_products.cost) AS products_grossprofit FROM t_sales ";
        $sql .= "LEFT JOIN t_sales_products ON t_sales_products.sales_id = t_sales.id ";
        $sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m') = " . $date . ";";
        $data = $this->db->select($sql);
        return $data[0];
    }

    public function getReservationCustomerByDate($date)
    {
        $sql = "SELECT t_sales.*, m_customer.name ";
        $sql .= "FROM t_sales ";
        $sql .= "LEFT JOIN m_customer ON m_customer.id = t_sales.customer_id ";
        $sql .= "WHERE DATE_FORMAT(t_sales.next_reservation_date, '%Y%m') = " . $date . " ";
        $sql .= "AND (cancel_flag is Null OR cancel_flag = 0) ";
        $sql .= "AND DATE_FORMAT(t_sales.next_reservation_date, '%Y%m%d') > " . date('Ymd') . ";";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getCancelCustomerByDate($date)
    {
        $sql = "SELECT t_sales.*, m_customer.name ";
        $sql .= "FROM t_sales ";
        $sql .= "LEFT JOIN m_customer ON m_customer.id = t_sales.customer_id ";
        $sql .= "WHERE DATE_FORMAT(t_sales.next_reservation_date, '%Y%m') = " . $date . " ";
        $sql .= "AND cancel_flag = 1;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getTodayCustomer()
    {
        $month = date('m');
        $sql = "SELECT t_sales.*, m_customer.name FROM m_customer ";
        $sql .= "LEFT JOIN t_sales ON t_sales.customer_id = m_customer.id ";
        $sql .= "WHERE DATE_FORMAT(next_reservation_date, '%Y%m%d') = " . date('Ymd') . ";";
        $data = $this->db->select($sql);
        return $data;
    }
}
