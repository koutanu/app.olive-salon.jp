<?php
/**
 * Harden File upload helper — image types only, DOC_ROOT based paths.
 */
class File
{
    public static function uploadImage($name, $save_path)
    {
        $filename = '';
        $save_path = basename(str_replace(['..', '\\'], '', $save_path));

        if (!is_uploaded_file($_FILES[$name]['tmp_name'] ?? '')) {
            return ['', '画像が見つかりません。'];
        }

        $path = rtrim(DOC_ROOT, '/\\') . '/images/' . $save_path;
        if (!file_exists($path)) {
            if (!mkdir($path, 0755, true)) {
                return ['', 'ディレクトリを作成できませんでした。'];
            }
        }

        try {
            if (!isset($_FILES[$name]['error']) || !is_int($_FILES[$name]['error'])) {
                throw new RuntimeException('パラメータが不正です。');
            }

            switch ($_FILES[$name]['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('ファイルが選択されていません。');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('ファイルサイズが大きすぎます。');
                default:
                    throw new RuntimeException('アップロードエラーが発生しました。');
            }

            if ($_FILES[$name]['size'] > 5000000) {
                throw new RuntimeException('ファイルサイズが大きすぎます。');
            }

            $filetype = [
                'gif' => 'image/gif',
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'webp' => 'image/webp',
            ];
            $mime = mime_content_type($_FILES[$name]['tmp_name']);
            $ext = array_search($mime, $filetype, true);
            if ($ext === false) {
                throw new RuntimeException('許可されていないファイル形式です。');
            }

            $filename = bin2hex(random_bytes(16)) . '.' . $ext;
            $dest = $path . '/' . $filename;
            if (!move_uploaded_file($_FILES[$name]['tmp_name'], $dest)) {
                throw new RuntimeException('ファイルの保存に失敗しました。');
            }
            chmod($dest, 0644);
            return [$filename, 'success'];
        } catch (RuntimeException $e) {
            return ['', $e->getMessage()];
        }
    }
}
