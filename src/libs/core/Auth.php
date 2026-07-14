<?php

class Auth
{

	public static function checkLogin()
	{
		Session::init();

		$logged = isset($_SESSION['login_state']) ? $_SESSION['login_state'] : false;

		if ($logged == false || $logged == null) {
			$result = false;
		} else {
			$result = true;
		}
		return $result;
	}

	/**
	 * 現在のログインユーザーが管理者(auth = 0)かどうかを判定する
	 */
	public static function isAdmin()
	{
		if (!self::checkLogin()) {
			return false;
		}
		return (int)Session::getUserInfo('user_auth') === 0;
	}

	/**
	 * 管理者でなければ権限エラー画面へ遷移させて処理を停止する
	 */
	public static function requireAdmin()
	{
		if (!self::isAdmin()) {
			header('location: ' . URL . 'failure/index');
			exit;
		}
		return true;
	}

	public static function handleLogin()
	{
		$requestedurl = $_GET['url'] ?? '';
		$now = time();
		if (!self::checkLogin()) {
			if (isset($_SESSION['reset']) || isset($_SESSION['home'])) {
				$_SESSION['last_request_time'] = $now;
			} else {
				if ($requestedurl != 'failure/permission') {
					Session::destroy();
					Session::init();
					$_SESSION['requestedurl'] = $requestedurl;
					$_SESSION['last_request_time'] = $now;
				}
				header('location: ' . URL . 'login');
				return false;
			}
		} else {
			$lastreq = $_SESSION['last_request_time'] ?? 0;
			if (($lastreq + 7200) <= $now) {
				if ($requestedurl != 'failure/permission') {
					Session::destroy();
					Session::init();
					$_SESSION['requestedurl'] = $requestedurl;
					$_SESSION['last_request_time'] = $now;
				}
				header('location: ' . URL . 'login');
				return false;
			} else {
				$_SESSION['last_request_time'] = $now;
			}
		}
		return true;
	}
}
