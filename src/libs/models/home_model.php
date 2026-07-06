<?php

class Home_Model extends Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getCustomerBirthday()
	{
		$sql = 'SELECT year,month,day FROM m_customer;';
		$data = $this->db->select($sql);
		return $data;
	}

	public function getProductsAll()
	{
		$sql = "SELECT * FROM m_products;";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getStockAll()
	{
		$sql = "SELECT s_stock.*, m_products.name FROM s_stock LEFT JOIN m_products ON m_products.id = s_stock.products_id WHERE s_stock.lot > 0 OR s_stock.unit > 0 ORDER BY products_id;";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getAllCustomer()
	{
		$sql = "SELECT * FROM m_customer ORDER BY kana ASC;";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getProductsGrossProfitMonthly() //月ごとにgroupした商品の売り上げと原価の合計
	{
		$sql = "SELECT SUM(t_sales_products.price) AS price, SUM(t_sales_products.cost) AS cost, MAX(created_at) AS created_at ";
		$sql .= "FROM t_sales ";
		$sql .= "LEFT JOIN t_sales_products ON t_sales_products.sales_id = t_sales.id ";
		// $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m%d') >= '" . date('Ym01', strtotime("-1 year -1 month")) . "' GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getProductsGrossProfitYearly() //年間
	{
		$sql = "SELECT SUM(t_sales_products.price) AS price, SUM(t_sales_products.cost) AS cost, MAX(created_at) AS created_at ";
		$sql .= "FROM t_sales ";
		$sql .= "LEFT JOIN t_sales_products ON t_sales_products.sales_id = t_sales.id ";
		// $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m%d') >= '" . date('Y0101') . "' GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getPurchasePriceMonthly()
	{
		$sql = "SELECT SUM(postage + total_price) AS purchase_price, MAX(created_at) AS created_at ";
		$sql .= "FROM s_stock_delivery ";
		$sql .= "GROUP BY DATE_FORMAT(s_stock_delivery.created_at, '%Y%m');";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getMenuGrossProfitMonthly() //月ごとにgroupした施術売上の合計
	{
		$sql = "SELECT SUM(sales) AS gross_profit, MAX(created_at) AS created_at ";
		$sql .= "FROM t_sales ";
		// $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m%d') >= '" . date('Ym01', strtotime("-1 year -1 month")) . "' GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getMenuGrossProfitYearly() //年間
	{
		$sql = "SELECT SUM(sales) AS gross_profit, MAX(created_at) AS created_at ";
		$sql .= "FROM t_sales ";
		// $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m%d') >= '" . date('Y0101') . "' GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getProductsSalesMonthly()
	{
		$sql = "SELECT SUM(products_total_sales) AS gross_profit, MAX(created_at) AS created_at ";
		$sql .= "FROM t_sales ";
		$sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m%d') >= '" . date('Ym1', strtotime("-1 year -1 month")) . "'GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getProductsCountMonthly($date)
	{
		$sql = "SELECT MAX(m_products.name) as name, SUM(t_sales_products.price) AS price, SUM(t_sales_products.lot) AS lot, SUM(t_sales_products.unit) AS unit, MAX(m_tax.tax_rate) as tax_rate ";
		$sql .= "FROM t_sales_products ";
		$sql .= "LEFT JOIN s_stock ON s_stock.id = t_sales_products.stock_id ";
		$sql .= "LEFT JOIN m_products ON m_products.id = s_stock.products_id ";
		$sql .= "LEFT JOIN t_sales ON t_sales.id = t_sales_products.sales_id ";
		$sql .= "LEFT JOIN m_tax ON m_tax.id = t_sales_products.tax_id ";
		$sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m') = '" . $date . "' GROUP BY products_id;";
		$data = $this->db->select($sql);
		return $data;
	}



	public function getAveMenuGrossProfitMonthly()
	{
		$sql = "SELECT SUM(sales) AS gross_profit, MAX(created_at) AS created_at ";
		$sql .= "FROM t_sales ";
		$sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m%d') between '" . date('Ym01', strtotime("-1 year -1 month")) . "' and '" . date('Ymd') . "' GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getAveProductsGrossProfitMonthly()
	{
		$sql = "SELECT SUM(t_sales_products.price) AS price, SUM(t_sales_products.cost) AS cost, MAX(created_at) AS created_at ";
		$sql .= "FROM t_sales ";
		$sql .= "LEFT JOIN t_sales_products ON t_sales_products.sales_id = t_sales.id ";
		$sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m%d') between '" . date('Ym01', strtotime("-1 year -1 month")) . "' and '" . date('Ymd') . "' GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$data = $this->db->select($sql);
		return $data;
	}

	public function getAveProductsSalesMonthly()
	{
		$sql = "SELECT SUM(products_total_sales) AS gross_profit, MAX(created_at) AS created_at ";
		$sql .= "FROM t_sales ";
		$sql .= "WHERE DATE_FORMAT(t_sales.created_at, '%Y%m%d') between '" . date('Ym01', strtotime("-1 year -1 month")) . "' and '" . date('Ymd') . "' GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m');";
		$data = $this->db->select($sql);
		return $data;
	}
}
