<?php

class Google {
    /**
     * Copy spread sheet - Googleスプレッドシートをコピー
     * @param string $spreadsheet_id - 引数：スプレッドシートID
     * @param string $destination_folder_id - 引数：コピー先フォルダID
     * @param string $new_filename - 引数：コピー先ファイル名
     * @return string $result - 戻り値：新規ファイルID
     */
    public static function copySpreadsheet($spreadsheet_id, $destination_folder_id, $new_filename){
        try {
            $url = GAS_COPY_SS . '?ssid=' . $spreadsheet_id . '&fid=' . $destination_folder_id . '&fname=' . urlencode($new_filename);//URL
            $conn = curl_init(); // cURLセッションの初期化
            curl_setopt($conn, CURLOPT_URL, $url); //　取得するURLを指定
            curl_setopt($conn, CURLOPT_CUSTOMREQUEST, 'GET'); // メソッド指定
            curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
            curl_setopt($conn, CURLOPT_RETURNTRANSFER, true); // 実行結果を文字列で返す。
            curl_setopt($conn,CURLOPT_FOLLOWLOCATION,true);//リダイレクトの際にヘッダのRefererを自動的に追加させる
            curl_setopt($conn, CURLOPT_MAXREDIRS, 3);
            $res =  curl_exec($conn);
            curl_close($conn); //セッションの終了
            return $res;
        } catch (Exception $e) {
            $html = '<!DOCTYPE html><html lang="ja"><head><title>GAS Error</title></head><body><h1>GAS Copy Spreadsheet Error</h1><p>' . $e->getMessage() . '</p></body></html>';
            file_put_contents( 'temp/database_error.html', $html);
            return 'NG';
        }
    }
    /**
     * Get google - Google設定情報取得
     * @param integer $google_id - 引数：Google ID
     * @return array $result - 戻り値：Google設定情報
     */
    public static function getGoogle($google_id){
        self::init(); //DBインスタンスを生成-Create db instance
        $sql = "SELECT * FROM amt_google WHERE google_id = :google_id;"; //SQL文-Sql statement
        $result = self::$db->select($sql, array('google_id' => $google_id)); //該当するレコードを取得-Extract record that match search criteria
        return $result[0];
    }
    /**
     * Get estimate form data - 見積書式データを取得
     * @return array $result - 戻り値：見積明細データ配列
     */
    public static function getEstimateForm() {
        self::init(); //DBインスタンスを生成-Create db instance
        $sql = "SELECT * FROM smt_estimate_form ORDER BY estimate_form_id;";//SQL文-Sql statement
        $result = self::$db->select($sql);//該当するレコードを取得-Extract record that match search criteria
        return $result;
    }
}
