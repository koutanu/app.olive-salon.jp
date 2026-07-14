<?php

define('SYS_NAME', 'olive-salon');
define('DOC_ROOT', realpath(dirname(__FILE__)) . '/../../www/');
define('LIBS', '../libs/');
define('CORE', LIBS . 'core/');
define('CONTROLLERS', LIBS . 'controllers/');
define('MODELS', LIBS . 'models/');
define('VIEWS', LIBS . 'views/');
define('COMMON', LIBS . 'common/');
define('MAX_ROW', 15);
define('DB_TYPE', 'mysql');

// プロジェクトルートの .env を読み込む（存在する場合）
$envFile = realpath(dirname(__FILE__) . '/../../../.env');
if ($envFile && is_readable($envFile)) {
	foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
		$line = trim($line);
		if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
			continue;
		}
		[$k, $v] = explode('=', $line, 2);
		$k = trim($k);
		$v = trim($v, " \t\"'");
		if (getenv($k) === false) {
			putenv("$k=$v");
			$_ENV[$k] = $v;
		}
	}
}

/**
 * 環境変数を優先し、未設定時はローカル Docker 用の既定値を使う。
 * 本番では APP_URL / DB_* / MAP_API / GEO_API を設定すること。
 */
function env_or($key, $default = '')
{
	$value = getenv($key);
	if ($value === false || $value === '') {
		return $default;
	}
	return $value;
}

$appUrl = env_or('APP_URL', '');
if ($appUrl === '') {
	$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
	$host = env_or('APP_HOST', $_SERVER['HTTP_HOST'] ?? 'localhost');
	$appUrl = $scheme . '://' . $host . '/';
}
if (substr($appUrl, -1) !== '/') {
	$appUrl .= '/';
}
define('URL', $appUrl);

define('DB_HOST', env_or('DB_HOST', 'db'));
define('DB_NAME', env_or('DB_NAME', '51l20_olive_system'));
define('DB_USER', env_or('DB_USER', 'root'));
define('DB_PASS', env_or('DB_PASS', 'root'));

define('MAP_API', env_or('MAP_API', ''));
define('GEO_API', env_or('GEO_API', ''));

date_default_timezone_set('Asia/Tokyo');
