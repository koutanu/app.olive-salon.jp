<?php

class File
{
    public static function uploadImage($name, $save_path)
    {
        $filename = '';
        if (is_uploaded_file($_FILES[$name]['tmp_name'])) {
            $path = 'images/' . $save_path;
            $result = FALSE;
            if (file_exists($path)) { //---------------------------ディレクトリ有
                $result = TRUE;
            } else { //---------------------------------------------------ディレクトリ無
                if (mkdir($path, 0755)) { //-------ディレクトリ作成                
                    chmod($path, 0755); //------パーミッション変更                      
                    $result = TRUE;
                }
            } //-----------------------------------------------------ディレクトリ有無
            if ($result == TRUE) {
                try {
                    // 未定義である・複数ファイルである・$_FILES Corruption 攻撃を受けた
                    // どれかに該当していれば不正なパラメータとして処理する
                    if (!isset($_FILES[$name]['error']) || !is_int($_FILES[$name]['error'])) {
                        throw new RuntimeException('パラメータが不正です。ダメだよ。');
                        $result = 'パラメータが不正です。ダメだよ。';
                    }
                    // $_FILES[$name]['error'] の値を確認
                    switch ($_FILES[$name]['error']) {
                        case UPLOAD_ERR_OK: // OK
                            break;
                        case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                            throw new RuntimeException('エラー。ファイルえらんだ？');
                            $result = 'エラー。ファイルえらんだ？';
                        case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過(php.ini-line:upload_max_filesize)
                        case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過 (設定した場合のみ)
                            throw new RuntimeException('ファイルがおっきいよ～...');
                            $result = 'ファイルがおっきいよ～...';
                        default:
                            throw new RuntimeException('わからないエラーが出ちゃった...');
                            $result = 'わからないエラーが出ちゃった...';
                    }
                    if ($_FILES[$name]['size'] > 20000000) {
                        throw new RuntimeException('ファイルがおっきいよ～...');
                        $result = 'ファイルがおっきいよ～...';
                    }
                    // $_FILES[$name]['mime']の値はブラウザ側で偽装可能なので
                    // MIMEタイプに対応する拡張子を自前で取得する
                    $filetype = array(
                        'gif' => 'image/gif',
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                        'tif' => 'mage/tiff',
                        'svg' => 'image/svg+xml',
                        'pdf' => 'application/pdf',
                        'txt' => 'text/plain',
                        'flv' => 'video/x-flv',
                        'mp4' => 'video/mp4',
                        'webp' => 'image/webp'
                    );
                    if (!$ext = array_search(
                        mime_content_type($_FILES[$name]['tmp_name']), // MIMEタイプに対応する拡張子を自前で取得する
                        $filetype,
                        true
                    )) {
                        throw new RuntimeException('ファイル形式が不正です。だめっ!');
                        $result = 'ファイル形式が不正です。だめっ!';
                    }
                    $filename = uniqid(mt_rand(), true) . '.' . $ext;
                    $path = $path . '/' . $filename;
                    if (!move_uploaded_file($_FILES[$name]['tmp_name'], $path)) {
                        throw new RuntimeException('ファイル保存時に、えらー？？が発生したみたい。');
                        $result = 'ファイル保存時に、えらー？？が発生したみたい。';
                    }
                    // ファイルのパーミッションを確実に0644に設定する
                    chmod($path, 0755);
                    $result = 'success';
                } catch (RuntimeException $e) {
                    $result = $e->getMessage();
                }
            }
        } else {
            $result = '画像が見あたらないよ？';
        }
        $data = array($filename, $result);
        return $data;
    }
}
