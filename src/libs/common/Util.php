<?php

class Util
{
    public static function getNameInitialList()
    {
        return preg_split("//u", "あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわ", -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function hs($string)
    {
        if (is_array($string)) {
            return array_map(['Util', 'hs'], $string);
        }
        return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
    }

    public static function getAgeForBirthday($year, $month, $day)
    {
        if (!$year || !$month || !$day) {
            return '';
        }
        $today = date('Ymd');
        $birthday = sprintf('%04d-%02d-%02d', (int)$year, (int)$month, (int)$day);
        $birthday_format = date('Ymd', strtotime($birthday));
        return (int)floor(($today - intval($birthday_format)) / 10000);
    }

    public static function getLastVisit($date)
    {
        if (!$date || $date === '0000-00-00 00:00:00') {
            return '来店無し';
        }
        $today = date('Y-m-d');
        return floor((strtotime($today) - strtotime($date)) / 86400) . '日前';
    }
}
