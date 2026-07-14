<?php

class Session
{

	public static function init()
	{
		if (session_status() === PHP_SESSION_ACTIVE) {
			return;
		}
		ini_set('session.gc_maxlifetime', 7200);
		$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
		session_set_cookie_params([
			'lifetime' => 7200,
			'path' => '/',
			'secure' => $secure,
			'httponly' => true,
			'samesite' => 'Lax',
		]);
		session_start();
	}

	public static function regenerateID()
	{
		session_regenerate_id(true);
	}

	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public static function get($key)
	{
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
	}

	public static function destroy()
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time() - 42000, '/');
		}
		session_destroy();
	}

	public static function getSessionID()
	{
		$sessionId = session_id();
		return $sessionId;
	}

	public static function getUserInfo($key)
	{
		$user_info = self::get('user_info');
		if (!empty($user_info)) {
			if (isset($key)) {
				return $user_info[$key];
			} else {
				return $user_info;
			}
		}
	}

	public static function setToken($action)
	{
		$token = bin2hex(random_bytes(32));
		self::set('token/' . $action, $token);
		return $token;
	}

	public static function getToken($action)
	{
		$key = 'token/' . $action;
		$token = self::get($key);
		return $token;
	}

	/**
	 * トークンを検証し、成功時は消費（使い捨て）する。
	 * フォーム再表示用に新しいトークンを返せるよう、検証後はキーを削除する。
	 */
	public static function checkToken($action, $token)
	{
		$sessionToken = self::getToken($action);
		if (empty($sessionToken) || empty($token)) {
			return false;
		}
		$valid = hash_equals($sessionToken, $token);
		if ($valid) {
			unset($_SESSION['token/' . $action]);
		}
		return $valid;
	}
}
