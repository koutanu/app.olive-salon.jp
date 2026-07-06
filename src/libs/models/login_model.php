<?php

class Login_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function auth($account)
    {
        $sql = "SELECT * FROM m_users WHERE account = :account;";
        $sth = $this->db->prepare($sql);
        $bind = array('account' => $account);
        foreach ($bind as $key => $value) {
            if (gettype($value) == 'string') {
                $sth->bindValue(":$key", $value, PDO::PARAM_STR);
            } else {
                $sth->bindValue(":$key", (int) $value, PDO::PARAM_INT);
            }
        }
        $sth->execute();

        $data = $sth->fetch(PDO::FETCH_ASSOC);
        $count = $sth->rowCount();
        $user_info = array();
        if ($count > 0) {
            print_r(INPUT_POST['password']);
            if (password_verify(filter_input(INPUT_POST, 'password'), $data['password'])) {
                $user_info = array(
                    'user_id' => $data['id'],
                    'user_account' => $data['account'],
                    'user_name' => $data['name'],
                    'user_auth' => $data['auth'],
                );
                return $user_info;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function createUser($account, $name, $password)
    {
        $user_data['account'] = $account;
        $user_data['name'] = $name;
        $user_data['password'] = password_hash($password, PASSWORD_DEFAULT);
        $user_data['created_at'] = date('Y-m-d H:i:s');
        $result = $this->db->insert('m_users', $user_data);
        return $result;
    }
}
