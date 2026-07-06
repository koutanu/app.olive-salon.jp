<?php

/**
 * ログ自動削除スクリプト
 * 実行方法: php delete_old_logs.php
 */

require_once dirname(__DIR__) . '/libs/core/Config.php';

/* * 注意: config.php 内で定義されている定数名 (例: DB_HOST, DB_NAME など) が
 * 実際のものと異なる場合は、以下の接続処理の変数名を書き換えてください。
 */

try {
	// 2. DB接続
	// config.phpで定義されている定数を使用
	$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
	$pdo = new PDO($dsn, DB_USER, DB_PASS, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	]);

	// 3. 削除の実行
	// 保存期間を日数で指定（例：180日 ＝ 約半年）
	$retention_days = 180;

	// t_log テーブルの datetime カラムを基準に古いデータを削除
	$sql = "DELETE FROM t_log WHERE datetime < NOW() - INTERVAL :days DAY";

	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':days', $retention_days, PDO::PARAM_INT);
	$stmt->execute();

	$count = $stmt->rowCount();

	// 実行結果をログ出力（ConoHaのジョブ履歴などで確認用）
	echo "[" . date('Y-m-d H:i:s') . "] 削除完了: {$count} 件のログを整理しました。\n";
} catch (Exception $e) {
	// エラーが発生した場合は標準エラーログに記録
	error_log("[" . date('Y-m-d H:i:s') . "] Log Cleanup Error: " . $e->getMessage());
	echo "エラーが発生しました。詳細はサーバーログを確認してください。\n";
	exit(1);
}
