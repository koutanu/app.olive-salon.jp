<?php

class Session
{

    public static function init()
    {
        //session_name(SYS_NAME);
        ini_set('session.gc_maxlifetime', 3600);
        session_start();
    }
    public static function regenerateID()
    {
        //session_name(SYS_NAME);
        session_regenerate_id(true);
    }
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }
    public static function destroy()
    {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            //セッションcookieを破棄します
            setcookie(session_name(), '', time() - 1800, '/');
        }
        //最終的にセッションを破棄します
        session_destroy();
    }
    public static function getSessionID()
    {
        $sessionId = session_id();
        return $sessionId;
    }
    public static function getUserInfo($key)
    {
        $user_info = self::get('user_info');
        if (!empty($user_info)) {
            if (isset($key)) {
                return $user_info[$key];
            } else {
                return $user_info;
            }
        }
    }
    public static function setToken($action)
    {
        $key = 'token/' . $action;
        $keyword = session_id() . $action;
        $token = password_hash(($keyword), PASSWORD_DEFAULT);
        self::set($key, $token);
        return $token;
    }
    public static function getToken($action)
    {
        $key = 'token/' . $action;
        $token = self::get($key);
        return $token;
    }
    public static function checkToken($action, $token)
    {
        $sessionToken = self::getToken($action);
        if (empty($sessionToken) || ($sessionToken != $token)) {
            return false;
        } else {
            return true;
        }
    }
}
