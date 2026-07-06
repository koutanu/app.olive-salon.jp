<?php

class Util
{

    const gengoList = array(
        ['name' => '平成', 'name_short' => 'H', 'timestamp' => 600188400], // 1989-01-08,
        ['name' => '昭和', 'name_short' => 'S', 'timestamp' => -1357635600], // 1926-12-25'
        ['name' => '大正', 'name_short' => 'T', 'timestamp' => -1812186000], // 1912-07-30
        ['name' => '明治', 'name_short' => 'M', 'timestamp' => -3216790800], // 1868-01-25
    );
    const ampm = array(
        'am' => '午前',
        'pm' => '午後',
    );

    public static function getNameInitialList()
    {
        return preg_split("//u", "あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわ");
    }

    public static function hs($string)
    {
        if (is_array($string)) {
            return array_map(array('Util', 'hs'), $string);
        } else {
            return htmlspecialchars($string, ENT_QUOTES, "UTF-8");
        }
    }

    public static function hs_decode($string)
    {
        if (is_array($string)) {
            return array_map(array('Util', 'hs_decode'), $string);
        } else {
            //return htmlspecialchars_decode($string, ENT_QUOTES,"UTF-8");
            return htmlspecialchars_decode($string);
        }
    }

    public static function removeSpace($string)
    {
        if (is_array($string)) {
            return array_map(array('Util', 'removeSpace'), $string);
        } else {
            return str_replace(array("　", " "), '', $string);
        }
    }

    public static function removeCrLf($string)
    {
        if (is_array($string)) {
            return array_map(array('Util', 'removeCrLf'), $string);
        } else {
            return str_replace(array("\r\n", "\n", "\r"), '', $string);
        }
    }

    public static function removeSpaceCrLf($string)
    {
        if (is_array($string)) {
            return array_map(array('Util', 'removeSpaceCrLf'), $string);
        } else {
            return str_replace(array("　", " ", "\r\n", "\n", "\r"), '', $string);
        }
    }

    public static function Ymd($date)
    {
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '未入力';
        } else {
            return date('Y-n-j', strtotime($date));
        }
    }

    public static function Md($date)
    {
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '未入力';
        } else {
            return date('n/j', strtotime($date));
        }
    }

    public static function Mdhm($date)
    {
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '未入力';
        } else {
            return date('n/j H:i', strtotime($date));
        }
    }

    public static function Ymdhm($date)
    {
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '未入力';
        } else {
            return date('Y/n/j H:i', strtotime($date));
        }
    }

    public static function jYmd($date)
    {
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '';
        } else {
            return date('Y年n月j日', strtotime($date));
        }
    }

    public static function jYmdhm($date)
    {
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '';
        } else {
            return date('Y年n月j日 H時i分', strtotime($date));
        }
    }

    public static function jMdhm($date)
    {
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '';
        } else {
            return date('n月j日 H時i分', strtotime($date));
        }
    }

    public static function nYnjw($date)
    {
        $week = array('日', '月', '火', '水', '木', '金', '土');
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '未入力';
        } else {
            $Date = strtotime($date);
            $Year = date('Y', $Date);
            $Month = date('n', $Date);
            $Day = date('j', $Date);
            $Week = $week[date('w', $Date)];
            return $Year . '/' . $Month . '/' . $Day . '(' . $Week . ') ';
        }
    }

    public static function nYnjwhm($date)
    {
        $week = array('日', '月', '火', '水', '木', '金', '土');
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '';
        } else {
            $Date = strtotime($date);
            $Year = date('Y', $Date);
            $Month = date('n', $Date);
            $Day = date('j', $Date);
            $Week = $week[date('w', $Date)];
            $Hour = date('H', $Date);
            $Minute = date('i', $Date);
            return $Year . '/' . $Month . '/' . $Day . '(' . $Week . ') ' . $Hour . ':' . $Minute;
        }
    }

    public static function nNjwhm($date)
    {
        $week = array('日', '月', '火', '水', '木', '金', '土');
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '';
        } else {
            $Date = strtotime($date);
            $Month = date('n', $Date);
            $Day = date('j', $Date);
            $Week = $week[date('w', $Date)];
            $Hour = date('H', $Date);
            $Minute = date('i', $Date);
            return $Month . '/' . $Day . '(' . $Week . ') ' . $Hour . ':' . $Minute;
        }
    }

    public static function jDay($day)
    {
        $week = json_decode(JDAY, true);
        return $week[$day];
    }

    public static function wYmd($date)
    {
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '';
        } else {
            $Date = strtotime($date);
            $YearAD = intval(date('Y', $Date));
            $month = date('n', $Date);
            $day = date('j', $Date);
            $gengo = "";
            $wayear = 0;
            if (date("Ymd", $Date) >= 20190501) {
                return '(令和' . sprintf("%01d", $YearAD - 2018) . "年" . $month . "月" . $day . "日)";
            } else if (date("Ymd", $Date) >= 19890108) {
                return '(平成' . sprintf("%01d", $YearAD - 1988) . "年" . $month . "月" . $day . "日)";
            } else if (date("Ymd", $Date) >= 19261225) {
                return '(昭和' . sprintf("%01d", $YearAD - 1925) . "年" . $month . "月" . $day . "日)";
            } else if (date("Ymd", $Date) >= 19120730) {
                return '(大正' . sprintf("%01d", $YearAD - 1911) . "年" . $month . "月" . $day . "日)";
            } else {
                return '(明治' . sprintf("%01d", $YearAD - 1867) . "年" . $month . "月" . $day . "日)";
            }
        }
    }

    public static function splitDatetime($date)
    {
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            return '';
        } else {
            list($year, $month, $day, $hour, $minute, $second) = preg_split('/[-: ]/', $date);
        }
        $result = array(
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'hour' => $hour,
            'minute' => $minute,
            'second' => $second
        );
        return $result;
    }

    public static function getAge($date)
    {
        if ($date === 0) {
            return '';
        } else {
            return floor((date("Ymd") - date("Ymd", strtotime($date))) / 10000) . '歳';
        }
    }

    public static function beginningOfMonth($date)
    {
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date));
        $yearmonth = $year . '-' . sprintf('%02d', $month);
        return date('Y-m-d', strtotime('first day of ' . $yearmonth));
    }

    public static function endOfMonth($date)
    {
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date));
        $yearmonth = $year . '-' . sprintf('%02d', $month);
        return date('Y-m-d', strtotime('last day of ' . $yearmonth));
    }

    public static function nextEndOfMonth($date)
    {
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date));
        if ($month === 12) {
            $month = 1;
            $year = $year + 1;
        } else {
            $month = $month + 1;
        }
        return date('Y-m-t', strtotime($year . '-' . $month . '-1'));
    }

    public static function next20thOfMonth($date)
    {
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date));
        if ($month === 12) {
            $month = 1;
            $year = $year + 1;
        } else {
            $month = $month + 1;
        }
        return date('Y-m-d', strtotime($year . '-' . $month . '-20'));
    }

    function getFirstWeekday($year, $month, $day)
    {
        $w = $day - 1;
        $date = date('Ymd', strtotime($year . sprintf('%02d', $month) . '01 this week ' . $w . ' day'));
        if (substr($date, 0, 6) !== $year . sprintf('%02d', $month)) {
            $date = date('Y-m-d', strtotime($date . ' 1 week'));
        }
        return $date;
    }

    function getNthWeekday($year, $month, $number, $day)
    {
        $date = self::getFirstWeekday($year, $month, $day);
        $weeknumber = intval($number) - 1;
        return date('Y-m-d', strtotime($date . ' + ' . $weeknumber . ' week'));
    }

    function getNthWeekday0($year, $month, $number, $day)
    {
        $months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"); //月-Months
        $weeks = array("First", "Second", "Third", "Forth", "Fifth"); //週-Week number
        $days = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"); //曜日-Days of week
        $timestring = $weeks[$number - 1] . ' ' . $days[$day] . ' of ' . $months[$month - 1] . ' ' . $year;
        $timestring = "fifth sun of dec 2018";
        $date = date('Y-m-d', strtotime($timestring));
        //$date = date('Y-m-d', strtotime($weeks[$number - 1] . ' ' . $days[$day] . ' of ' . $months[$month - 1] . ' ' . $year));
        return $date;
    }

    function getWeekNumber($date, $day)
    {
        if ($day != 6) {
            $day = (6 - $day) + $date;
        } else { // 土曜日の場合を修正
            $day = $date;
        }
        return ceil($day / 7);
    }

    public static function setInputDate($date)
    {
        if ($date === 0) {
            return date('Y-m-d', time());
        } elseif (!$date) {
            return '';
        } else {
            return date('Y-m-d', strtotime($date));
        }
    }

    public static function getStartEndDay($year, $month, $date)
    {
        $start = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, $month, $date, $year))));
        $end = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', mktime(23, 59, 59, $month, $date, $year))));
        return array($start, $end);
    }

    public static function getStartEndWeek($year, $month, $date)
    {
        $start = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, $month, $date, $year))));
        $end = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', mktime(23, 59, 59, $month, $date, $year)) . ' +' . 6 . ' day'));
        return array($start, $end);
    }

    public static function getStartEndMonth($year, $month, $date)
    {
        $start = date('Y-m-d H:i:s', mktime(0, 0, 0, $month, 1, $year));
        $end = date('Y-m-t H:i:s', mktime(23, 59, 59, $month, 1, $year));
        return array($start, $end);
    }

    public static function setInputDateTime($date)
    {
        if (is_null($data)) {
            $result = '';
        } elseif ($date === 0) {
            $result = date('Y-m-d', time()) . 'T' . date('H:i', time());
        } elseif (!$date) {
            $result = '';
        } else {
            $result = date('Y-m-d', strtotime($date)) . 'T' . date('H:i', strtotime($date));
        }
        return $result;
    }

    public static function yearSelect($start = 2017)
    {
        $year = date('Y', time());
        $data = array();
        for ($i = $start; $i <= $year + 1; $i++) {
            $data[$i] = $i;
        }
        return $data;
    }

    public static function getWarekiYear($year = 0)
    {
        if ($year != 0) {
            $YearAD = intval($year);
            if ($YearAD > 2019) {
                return '(令和' . sprintf("%01d", $YearAD - 2018) . "年)";
            } else if ($YearAD >= 1989) {
                return '(平成' . sprintf("%01d", $YearAD - 1988) . "年)";
            } else if ($YearAD >= 1927) {
                return '(昭和' . sprintf("%01d", $YearAD - 1925) . "年)";
            } else if ($YearAD >= 1913) {
                return '(大正' . sprintf("%01d", $YearAD - 1911) . "年)";
            } else {
                return '(明治' . sprintf("%01d", $YearAD - 1867) . "年)";
            }
        } else {
            return '';
        }
    }

    public static function getDateTime($date, $hour, $minute)
    {
        if ($date === 0 || $date === '0000-00-00 00:00:00' || !$date) {
            $datetime = '0000-00-00 00:00:00';
        } else {
            $datetime = $date . ' ' . $hour . ':' . $minute . ':00';
        }
        return $datetime;
    }

    public static function beginingOfWeek($date)
    {
        if ($date === '') {
            $y = date('Y');
            $m = date('n');
            $d = date('j');
            $w = date('w');
        } else {
            $y = date('Y', strtotime($date));
            $m = date('n', strtotime($date));
            $d = date('j', strtotime($date));
            $w = date('w', strtotime($date));
        }
        $datetime = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, $m, $d, $y)) . ' -' . $w . ' day'));
        return $datetime;
    }

    public static function monthSelect()
    {
        $data = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
        return $data;
    }

    public static function kanaSelect()
    {
        $data = array('', 'ア', 'カ', 'サ', 'タ', 'ナ', 'ハ', 'マ', 'ヤ', 'ラ', 'ワ');
        return $data;
    }

    public static function setSearchKeyStrings($string, $column, $name)
    {
        if (is_array($column)) {
            $columns = $column;
            $val = count($column);
        } else {
            $columns = array($column);
            $val = 1;
        }
        $bind = array();
        $searchkey_temp = str_replace('　', ' ', $string);
        $searchkey .= " AND (";
        if (strpos($searchkey_temp, ' ') === false) {
            for ($i = 0; $i < $val; $i++) {
                if ($val > 1) {
                    $searchkey .= "(";
                }
                $searchkey .= $columns[$i] . " LIKE :$name";
                $bind = array_merge($bind, array($name => '%' . $string . '%'));
                if ($val > 1) {
                    $searchkey .= ")";
                }
                if ($i != ($val - 1)) {
                    $searchkey .= " OR ";
                }
            }
        } else {
            $array = explode(" ", $searchkey_temp);
            for ($i = 0; $i < $val; $i++) {
                if ($val > 1) {
                    $searchkey .= "(";
                }
                for ($j = 0; $j < count($array); $j++) {
                    $bindname = $name . $j;
                    $searchkey .= $columns[$i] . " LIKE :$bindname";
                    $bind = array_merge($bind, array($bindname => '%' . $array[$j] . '%'));
                    if ($j != (count($array) - 1)) {
                        $searchkey .= " AND ";
                    }
                }
                if ($val > 1) {
                    $searchkey .= ")";
                }
                if ($i != ($val - 1)) {
                    $searchkey .= " OR ";
                }
            }
        }
        $searchkey .= ")";
        return array($searchkey, $bind);
    }

    public static function getTaxRate($date)
    {
        if ($date === 0) {
            $date = strtotime(date('Y-m-d'));
        } else {
            $date = strtotime($date);
            if (date("Ymd", $date) >= 20191001) {
                return 10;
            } else if (date("Ymd", $date) >= 20140401) {
                return 8;
            } else if (date("Ymd", $date) >= 19970401) {
                return 5;
            } else if (date("Ymd", $date) >= 19890401) {
                return 3;
            } else {
                return 0;
            }
        }
    }

    public static function setCheckString($val)
    {
        if (intval($val) === 0) {
            return '&#x2610;';
        } else {
            //return '&#10003;';
            return '&#x2611;';
        }
    }

    public static function adjustStringLength($str, $max)
    {
        $str = Util::hs_decode($str);
        $str = strip_tags($str);
        $str = str_replace(array("\r\n", "\r", "\n"), '', $str);
        $str = str_replace('&nbsp;', ' ', $str);
        $len = mb_strlen($str, 'utf8');
        if ($len > intval($max)) {
            $str = mb_substr($str, 0, $max - 1, 'utf8') . '...';
        }
        return $str;
    }

    public static function setNumberFormat($val)
    {
        if (($val != '') || !(is_null($val))) {
            $resutl = number_format($val);
        } else {
            $resutl = 0;
        }
        return $resutl;
    }

    public static function setNumberFormat2($val)
    {
        if (($val != '') || !(is_null($val))) {
            if (intval($val) < 0) {
                $resutl = '▲' . number_format($val * -1);
            } else {
                $resutl = number_format($val);
            }
        } else {
            $resutl = 0;
        }
        return $resutl;
    }

    public static function setFloatNumberFormat($val)
    {
        if ($val != '') {
            $number = explode('.', floatval($val));
            $result1 = number_format($number[0]);
            if (intval($number[1]) != 0) {
                $result2 = '.' . strval($number[1]);
            } else {
                $result2 = '';
            }
        } else {
            $resutl = 0;
        }
        return $result1 . $result2;
    }

    public static function getFileExtention($filepath)
    {
        $ext = pathinfo($filepath, PATHINFO_EXTENSION);
        return $ext;
    }

    public static function getFilenameExtention($filename)
    {
        $arr = explode('.', $filename);
        $ext = end($arr);
        return $ext;
    }

    public static function setSecureString($str)
    {
        $str = stripslashes($str);
        $str = str_replace('"', '""', $str);
        $str = htmlspecialchars($str, ENT_QUOTES, "utf-8");
        return $str;
    }

    public static function getAgeForBirthday($year, $month, $day)
    {
        $today = date('Ymd');
        $birthday = $year . '-' . $month . '-' . $day;
        $birthday_format = date('Ymd', strtotime($birthday));
        return floor(($today - intval($birthday_format)) / 10000);
    }

    public static function getLastVisit($date)
    {
        $today = date('Y-m-d');
        return floor((strtotime($today) - strtotime($date)) / 86400) . '日前';
    }
}
