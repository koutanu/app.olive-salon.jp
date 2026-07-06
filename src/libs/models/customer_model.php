<?php

class Customer_Model extends Model
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

    public function getAllCustomer()
    {
        $sql = "SELECT * FROM m_customer ";
        $sql .= "LEFT JOIN (SELECT customer_id, created_at AS last_visit_date FROM t_sales WHERE (customer_id, created_at) IN (SELECT customer_id,MAX(created_at) FROM t_sales GROUP BY customer_id)) ";
        $sql .= "AS x ON x.customer_id = m_customer.id ORDER BY kana ASC;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getCustomerById($id)
    {
        $sql = "SELECT * FROM m_customer WHERE id = " . $id . ";";
        $data = $this->db->select($sql);
        return $data[0];
    }

    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM m_customer WHERE id = :id;";
        $bind = array('id' => $id);
        return $this->db->delete($sql, $bind);
    }

    public function searchCustomerByName($name)
    {
        $kana =  mb_convert_kana($name, 'C', 'utf-8');
        $sql = "SELECT name, id, kana FROM m_customer WHERE replace(replace(name,'　',''),' ','') LIKE '%" . $name . "%' ";
        $sql .= "OR replace(replace(kana,'　',''),' ','') LIKE '%" . $kana . "%' ORDER BY kana ASC;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function searchCustomerByInitial($initial)
    {
        $kana =  mb_convert_kana($initial, 'C', 'utf-8');
        $sql = "SELECT name, id, kana FROM m_customer WHERE replace(replace(name,'　',''),' ','') LIKE '" . $initial . "%' ";
        $sql .= "OR replace(replace(kana,'　',''),' ','') LIKE '" . $kana . "%' ORDER BY kana ASC;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getBirthdayCustomer()
    {
        $month = date('m');
        $sql = "SELECT * FROM m_customer WHERE month = " . $month . " ORDER BY day;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getBirthdayNextmonthCustomer()
    {
        $month = date('m + 1');
        $sql = "SELECT * FROM m_customer WHERE month = " . $month . " ORDER BY day;";
        $data = $this->db->select($sql);
        return $data;
    }

    public function getTodayCustomer()
    {
        $sql = "SELECT * FROM m_customer ";
        $sql .= "LEFT JOIN t_sales ON t_sales.customer_id = m_customer.id ";
        $sql .= "WHERE DATE_FORMAT(next_reservation_date, '%Y%m%d') = " . date('Ymd') . " AND NOT cancel_flag = 1 ";
        $sql .= "OR DATE_FORMAT(next_reservation_date, '%Y%m%d') = " . date('Ymd') . " AND cancel_flag IS NULL;";
        $data = $this->db->select($sql);
        return $data;
    }
}
