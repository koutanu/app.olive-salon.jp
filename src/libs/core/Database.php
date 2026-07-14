<?php

/**
 * Database layer with identifier validation and prepared statements.
 */
class Database extends PDO
{
	/** @var int transact() 内の最後の INSERT で得た ID（commit 後は lastInsertId() が 0 になるため保持） */
	public $lastTransactInsertId = 0;

	private static $allowedTables = [
		'm_customer', 'm_users', 'm_menu', 'm_menu_option', 'm_products', 'm_supplier', 'm_tax',
		't_sales', 't_sales_products', 't_sales_menu_option', 't_stock', 't_stock_products', 't_log',
		's_stock', 's_stock_delivery',
	];

	public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
	{
		parent::__construct($DB_TYPE . ':host=' . $DB_HOST . ';dbname=' . $DB_NAME . ';charset=utf8mb4', $DB_USER, $DB_PASS);
		parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	private function assertIdentifier($name)
	{
		if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $name)) {
			throw new InvalidArgumentException('Invalid SQL identifier');
		}
	}

	private function assertTable($table)
	{
		$this->assertIdentifier($table);
		if (!in_array($table, self::$allowedTables, true)) {
			throw new InvalidArgumentException('Table not allowed: ' . $table);
		}
	}

	private function filterColumns(array $data)
	{
		$filtered = [];
		foreach ($data as $key => $value) {
			$this->assertIdentifier($key);
			$filtered[$key] = $value;
		}
		return $filtered;
	}

	public function select($sql, $bind = array())
	{
		$sth = $this->prepare($sql);
		try {
			foreach ($bind as $key => $value) {
				$sth->bindValue(":$key", $value);
			}
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			error_log($e->getMessage());
			return array();
		}
	}

	public function insert($table, $data)
	{
		$this->assertTable($table);
		$data = $this->filterColumns($data);
		$data['created_by'] = Session::getUserInfo('user_id');

		$fieldNames = implode(', ', array_keys($data));
		$fieldValues = ':' . implode(', :', array_keys($data));
		$sth = $this->prepare("INSERT INTO `$table` ($fieldNames) VALUES ($fieldValues);");
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
		$userId = class_exists('Session') ? Session::getUserInfo('user_id') : null;

		if (strpos($sql, ':created_by') !== false && !array_key_exists('created_by', $bind)) {
			$bind['created_by'] = $userId;
		}
		if (strpos($sql, ':updated_by') !== false && !array_key_exists('updated_by', $bind)) {
			$bind['updated_by'] = $userId;
		}
		if (strpos($sql, ':user_id') !== false && !array_key_exists('user_id', $bind)) {
			$bind['user_id'] = $userId;
		}

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

	public function update($table, $data, $where, $whereBind = array())
	{
		$this->assertTable($table);
		$data = $this->filterColumns($data);
		$data['updated_by'] = Session::getUserInfo('user_id');

		$fieldDetails = "";
		foreach ($data as $key => $value) {
			$fieldDetails .= "`$key`=:$key,";
		}
		$fieldDetails = rtrim($fieldDetails, ',');

		$sql = "UPDATE `$table` SET $fieldDetails WHERE $where";
		$sth = $this->prepare($sql);

		foreach ($data as $key => $value) {
			$sth->bindValue(":$key", $value);
		}
		foreach ($whereBind as $key => $value) {
			$sth->bindValue(":$key", $value);
		}

		try {
			$sth->execute();
			return array(true, $sth->rowCount());
		} catch (Exception $e) {
			error_log($e->getMessage());
			return array(false, "DB Error");
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
		$this->lastTransactInsertId = 0;
		$i = 0;
		$count = count($sqls);
		try {
			foreach ($sqls as $sql) {
				$sth = $this->prepare($sql);
				$bind = $binds[$i] ?? [];
				foreach ($bind as $key => $value) {
					$sth->bindValue(":$key", $value, PDO::PARAM_STR);
				}
				$sth->execute();
				$insertId = $this->lastInsertId();
				if ($insertId) {
					$this->lastTransactInsertId = (int)$insertId;
				}
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
