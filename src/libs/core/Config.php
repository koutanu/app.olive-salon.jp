<?php

define('URL', 'https://app.olive-salon.jp/www/');
define('SYS_NAME', 'template');
define('DOC_ROOT', realpath(dirname(__FILE__)) . '/../../www/');
define('LIBS', '../libs/');
define('CORE', LIBS . 'core/');
define('CONTROLLERS', LIBS . 'controllers/');
define('MODELS', LIBS . 'models/');
define('VIEWS', LIBS . 'views/');
define('COMMON', LIBS . 'common/');
define('MAX_ROW', 15);
define('DB_TYPE', 'mysql');
define('DB_HOST', 'mysql593.conoha.ne.jp');
define('DB_NAME', '51l20_olive_system');
define('DB_USER', '51l20_olive');
define('DB_PASS', 'd9NLjM#s');
define('INQUIRY_ADDRESS', 'slughedgehog@gmail.com');
define('MAP_API', 'AIzaSyCrE0CVswiYlvJs07iXN4JGu744aF5A7Bw');
define('GEO_API', 'AIzaSyBFaHy0yNjYYvyI8gDkJin0d1QXTNPhnFA');

require_once CORE . 'Mysqlview.php';
date_default_timezone_set('Asia/Tokyo');
