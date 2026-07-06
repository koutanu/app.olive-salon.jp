<?php

class Database extends PDO
{

    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
    {
        parent::__construct($DB_TYPE . ':host=' . $DB_HOST . ';dbname=' . $DB_NAME . ';charset=utf8', $DB_USER, $DB_PASS);
        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //AFTER_ERRMODE = エラーレポート / ERRMODE_EXCEPTION = 例外を投げる
    }

    public function select($sql, $bind = array())
    {
        $this->query("SET NAMES utf8");
        $sth = $this->prepare($sql);
        try {
            foreach ($bind as $key => $value) {
                $sth->bindValue(":$key", $value);
            }
            $sth->execute();
            $data = $sth->fetchAll(PDO::FETCH_ASSOC); //fetchAll = 全ての結果行を含む配列を返す
            return $data;
        } catch (Exception $e) {
            $html = '<!DOCTYPE html><html lang="ja"><head><title>Database Error</title></head><body><h1>update Error!</h1><p>' . $e->getMessage() . "\n" . '</p></body></html>';
            file_put_contents('log/database_error.html', $html);
            return $data = array();
        }
    }

    public function insert($table, $data)
    {
        $fieldNames = implode(', ', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));
        $sth = $this->prepare("INSERT INTO $table ($fieldNames) VALUES ($fieldValues);");
        try {
            foreach ($data as $key => $value) {
                $sth->bindValue(":$key", $value);
            }
            $sth->execute();
            $last_insert_id = $this->lastInsertId();
            return array(true, $last_insert_id);
        } catch (Exception $e) {
            return array(false, $e->getMessage());
        }
    }

    public function executesql($sql, $bind = array())
    {
        $sth = $this->prepare($sql);
        foreach ($bind as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        try {
            $sth->execute();
            $row_count = $sth->rowCount();
            return array(true, $row_count);
        } catch (Exception $e) {
            return array(false, $e->getMessage());
        }
    }

    public function update($table, $data, $where)
    {
        $fieldDetails = NULL;
        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        $sql = "UPDATE $table SET $fieldDetails WHERE $where";
        $sth = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        try {
            $sth->execute();
            $row_count = $sth->rowCount();
            return array(true, $row_count);
        } catch (Exception $e) {
            return array(false, $e->getMessage());
        }
    }

    public function delete($sql, $bind = array())
    {
        $sql1 = str_replace(';', ' LIMIT 1;', $sql);
        return $this->executesql($sql1, $bind);
    }

    public function deleteall($sql, $bind = array())
    {
        return $this->executesql($sql, $bind);
    }

    public function transact($sqls = array(), $binds = array())
    {
        $this->beginTransaction();
        $i = 0;
        $count = count($sqls);
        try {
            foreach ($sqls as $sql) {
                $sth = $this->prepare($sql);
                $bind = $binds[$i];
                foreach ($bind as $key => $value) {
                    $sth->bindValue(":$key", $value, PDO::PARAM_STR);
                }
                $sth->execute();
                $i++;
            }
            if ($i == $count) {
                $this->commit();
                return array(true, $i);
            } else {
                $rollback = $this->rollBack();
                return array(false, $rollback);
            }
        } catch (Exception $e) {
            $this->rollBack();
            return array(false, $e->getMessage());
        }
    }
}
