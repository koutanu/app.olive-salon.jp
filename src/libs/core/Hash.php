<?php

class Hash {
    private static $method = 'aes-256-cbc';//暗号化方式-Method
    private static $iv0 = 1234560000000000;
    private static $options = OPENSSL_RAW_DATA;//オプション
    public static function encryptPW($data1, $data2, $data3) {
        $data = $data1;
        $salt = $data2;
        $iv = self::$iv0 + strtotime($data3);
        $encrypted = self::encrypt($data, $salt, $iv);
        return $encrypted;
    }
    public static function decryptPW($data1, $data2, $data3) {
        $data = $data1;
        $salt = $data2;
        $iv = self::$iv0 + strtotime($data3);
        $decrypted = self::decrypt($data, $salt, $iv);
        return $decrypted;
    }
    //暗号化
    private static function encrypt($data, $salt, $iv) {
        $encrypted = base64_encode(openssl_encrypt($data, self::$method, $salt, self::$options, $iv));//暗号化
        return $encrypted;        
    }
    //復号
    private static function decrypt($data, $salt, $iv) {
        $decrypted = openssl_decrypt(base64_decode($data), self::$method, $salt, self::$options, $iv);//復号
        return $decrypted;
    }
    /**
     * ランダム文字列生成 (英数字)
     * $length: 生成する文字数
     */
    public static function randomStr($length = 32) {
        static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; ++$i) {
            $str .= $chars[mt_rand(0, 61)];
        }
        return $str;
    }
}