<?php

class Auth
{

    public static function checkLogin()
    {
        Session::init();
        $logged = $_SESSION['login_state'];
        if ($logged == false || $logged == null) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    public static function handleLogin()
    {
        $requestedurl = $_GET['url'];
        $now = time();
        if (!self::checkLogin()) {
            if (isset($_SESSION['reset']) || isset($_SESSION['home'])) {
                $_SESSION['last_request_time'] = $now;
            } else {
                if ($requestedurl != 'failure/permission') {
                    Session::destroy();
                    Session::init();
                    $_SESSION['requestedurl'] = $requestedurl;
                    $_SESSION['lastrequest'] = $now;
                }
                header('location: ' . URL . 'login');
                return false;
            }
        } else {
            $lastreq = $_SESSION['last_request_time'];
            if (($lastreq + 7200) <= $now) {
                if ($requestedurl != 'failure/permission') {
                    Session::destroy();
                    Session::init();
                    $_SESSION['requestedurl'] = $requestedurl;
                    $_SESSION['lastrequest'] = $now;
                }
                header('location: ' . URL . 'login');
                return false;
            } else {
                $_SESSION['lastreq'] = $now;
            }
        }
        return true;
    }
}
