<?php

#[\AllowDynamicProperties]
class View
{
	// 全画面共通で使用する基本的な情報のみ保持
	// ※これらは require された HTML 内で $this->title のように呼び出せます
	public $alert;
	public $js;
	public $class;
	public $method;
	public $title;
	public $j_class;
	public $token;
	public $stock;
	public $grossprofit_graph;
	public $total_sales;
	public $menu_graph;
	public $products_graph;
	public $purchase_price;
	public $age_group;
	public $products_monthly;
	public $ave_grossprofit;
	public $ave_menu;
	public $ave_products;

	function __construct() {}

	/**
	 * 画面を組み立てて表示（レンダリング）する
	 * * @param string $class  フォルダ名
	 * @param string $method ファイル名
	 * @param string $title  ページタイトル
	 * @param array  $vars   HTMLに渡したいデータの連想配列
	 */
	public function render($class, $method, $title, $vars = [])
	{
		// 1. 基本情報をプロパティに保存
		$this->class  = $class;
		$this->method = $method;
		$this->title  = $title;

		// 2. データを変数として展開
		// これにより、['token' => 'abc'] は HTML内で $token として使えるようになります
		extract($vars);

		// 3. ブラウザキャッシュの設定（'refer' 画面のみ）
		if ($method == 'refer') {
			$limit = 30;
			$expires = gmdate("D, d M Y H:i:s", time() + $limit) . " GMT";
			header("Expires: $expires");
			header("Pragma: cache");
			header("Cache-Control: max-age=$limit");
		}

		switch ($class) {
			case 'login':
				require VIEWS . 'head.php';
				require VIEWS . 'header_omit_wrapper.php';
				if ($class != 'failure') {
					require VIEWS . $class . '/' . $method . '.php';
				} else {
					require VIEWS . 'failure/index.php';
				}
				require VIEWS . 'footer_omit_wrapper.php';
				break;
			default:
				require VIEWS . 'head.php';
				require VIEWS . 'header.php';
				require VIEWS . 'sidemenu.php';
				if ($class != 'failure') {
					require VIEWS . $class . '/' . $method . '.php';
				} else {
					require VIEWS . 'failure/index.php';
				}
				require VIEWS . 'footer.php';
				break;
		}
	}

	/**
	 * エラー画面専用の表示処理
	 */
	public function failure($class, $title, $name = '')
	{
		$this->class   = $class;
		$this->title   = $title;
		$this->j_class = $name;

		require VIEWS . 'head.php';
		require VIEWS . 'header.php';
		require VIEWS . 'failure/index.php';
		require VIEWS . 'footer.php';
	}

	public function h($string)
	{
		return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
	}

	/**
	 * JSON を HTML 属性値として安全に埋め込む
	 */
	public function jsonAttr($data)
	{
		if ($data === null || $data === '') {
			$json = '[]';
		} elseif (is_string($data)) {
			$json = $data;
		} else {
			$json = json_encode($data, JSON_UNESCAPED_UNICODE);
			if ($json === false) {
				$json = '[]';
			}
		}
		return htmlspecialchars($json, ENT_QUOTES, 'UTF-8');
	}
}
