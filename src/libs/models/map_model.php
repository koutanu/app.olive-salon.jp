<?php

class Map_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCustomerGeoAll()
    {
        $sql = 'SELECT lat, lng, name, id FROM m_customer;';
        $data = $this->db->select($sql);
        return $data;
    }

    public function getCustomerGeoRecently()
    {
        $from = date('Ymd', strtotime("-6 month"));
        $sql = "SELECT lat, lng, name, id FROM m_customer ";
        $sql .= "LEFT JOIN (SELECT customer_id, created_at AS last_visit_date FROM t_sales WHERE (customer_id, created_at) IN (SELECT customer_id,MAX(created_at) FROM t_sales GROUP BY customer_id)) ";
        $sql .= "AS x ON x.customer_id = m_customer.id WHERE DATE_FORMAT(last_visit_date, '%Y%m%d') >= :from_date ORDER BY kana ASC;";
        $data = $this->db->select($sql, ['from_date' => $from]);
        return $data;
    }
}
