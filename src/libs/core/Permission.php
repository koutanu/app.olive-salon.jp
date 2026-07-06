<?php

/**
 * 
 */
class Permission {

    public static function checkPermission($classname) {
        $auth_id = Session::getUserInfo('auth_id');
        $permission = false;
        switch ($classname) {
            case 'account':
                switch ($auth_id) {
                    case 99:
                        $permission = true;
                        break;
                }
                break;
            default:
                $permission = true;
                break;
        }
        if (!$permission) {
            header('location: ' . URL . 'failure/permission');
            return false;
        } else {
            return true;
        }
    }

    public static function checkPermissionDetail($data) {
        $auth_id = Session::getUserInfo('auth_id');
        $permission = false;
        switch ($auth_id) {
            case 99: case 98: case 91:
                $permission = true;
                break;
            case 0:
                $permission = false;
                break;
            default:
                $permission = false;
                break;
        }
        if (!$permission) {
            header('location: ' . URL . 'failure/permission');
        }
        return $permission;
    }

    public static function getPermission($agent_id, $company_id, $branch_id = 0, $user_id = 0) {
        switch (Session::getUserInfo('auth_id')) {
            case 99: case 98: case 91:
                $permission = true;
                break;
            case 0:
                if ($user_id == Session::getUserInfo('user_id')) {
                    $permission = true;
                } else {
                    $permission = false;
                }
                break;
            default:
                $permission = false;
                break;
        }
        return $permission;
    }

}
