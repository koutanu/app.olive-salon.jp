<?php

class Analysis_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }
    // ----------------------------------------------------------------------------------全体
    public function getAllVisitorsCount()
    {
        $sql = "SELECT MAX(created_at) AS created_at, COUNT((SELECT id WHERE sales > 0)) AS visitors_count ";
        $sql .= "FROM t_sales GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m') ORDER BY created_at DESC LIMIT 6";
        return array_reverse($this->db->select($sql));
    }

    public function getAllReservationCount()
    {
        $sql = "SELECT MAX(created_at) AS created_at, COUNT(next_reservation_flag) as reservation_count ";
        $sql .= "FROM t_sales ";
        $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m') ORDER BY created_at DESC LIMIT 6;";
        return array_reverse($this->db->select($sql));
    }
    // ----------------------------------------------------------------------------------新規
    public function getNewVisitorsCount()
    {
        $sql = "SELECT MAX(created_at) AS created_at, COUNT((SELECT first_discount AS dis WHERE first_discount > 0)) AS visitors_count ";
        $sql .= "FROM t_sales GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m') ORDER BY created_at DESC LIMIT 6;";
        return array_reverse($this->db->select($sql));
    }

    public function getNewReservationCount()
    {
        $sql = "SELECT MAX(created_at) AS created_at, COUNT((SELECT next_reservation_flag WHERE ";
        $sql .= "next_reservation_flag = 1 AND first_discount > 0 AND NOT cancel_flag = 1 ";
        $sql .= "OR next_reservation_flag = 1 AND first_discount > 0 AND cancel_flag IS NULL ";
        $sql .= "OR next_reservation_flag = 1 AND first_discount > 0 AND cancel_flag = 0 ";
        $sql .= ")) AS reservation_count ";
        $sql .= "FROM t_sales GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m') ORDER BY created_at DESC LIMIT 6;";
        return array_reverse($this->db->select($sql));
    }
    // ----------------------------------------------------------------------------------既存
    public function getExistingVisitorsCount()
    {
        $sql = "SELECT MAX(created_at) AS created_at, COUNT((SELECT id WHERE first_discount = 0 AND sales > 0)) AS visitors_count FROM t_sales GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m') ORDER BY created_at DESC LIMIT 6";
        return array_reverse($this->db->select($sql));
    }

    public function getExistingReservationCount()
    {
        $sql = "SELECT MAX(created_at) AS created_at, COUNT(next_reservation_flag) as reservation_count ";
        $sql .= "FROM t_sales WHERE ";
        $sql .= "first_discount <= 0 AND NOT cancel_flag = 1 ";
        $sql .= "OR first_discount <= 0 AND cancel_flag = 0 ";
        $sql .= "OR first_discount <= 0 AND cancel_flag IS NULL ";
        $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y%m') ORDER BY created_at DESC LIMIT 6;";
        return array_reverse($this->db->select($sql));
    }
    //広告
    public function getAdvertisement()
    {
        $sql = "SELECT SUM(ad1) as ad1, SUM(ad2) as ad2, SUM(ad3) as ad3, SUM(ad_other) as ad_other ";
        $sql .= "FROM m_customer;";
        return $this->db->select($sql);
    }

    public function getMenuSalesByYear() //年ごとにgroupした施術総売上 今までの分全部
    {
        $sql = "SELECT SUM(sales) AS gross_profit, MAX(Year(created_at)) AS year ";
        $sql .= "FROM t_sales ";
        $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y');";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getProductsSalesByYear() //年ごとにgroupした商品総売上と原価 今までの分全部
    {
        $sql = "SELECT SUM(t_sales_products.price) AS price, SUM(t_sales_products.cost) AS cost, MAX(Year(created_at)) AS year ";
        $sql .= "FROM t_sales ";
        $sql .= "LEFT JOIN t_sales_products ON t_sales_products.sales_id = t_sales.id ";
        $sql .= "GROUP BY DATE_FORMAT(t_sales.created_at, '%Y');";
        $data = $this->db->select($sql);
        return $data;
    }
}
