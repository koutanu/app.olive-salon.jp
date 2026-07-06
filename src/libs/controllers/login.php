<?php

class Login extends Controller
{

    private $class_name = 'login';
    private $alert;

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->alert = $this->alert;
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'index', 'ログイン画面');
    }

    function account()
    {
        $this->view->alert = $this->alert;
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'account', 'アカウント新規追加');
    }

    function run()
    {
        $login_account = filter_input(INPUT_POST, 'login_account');
        $user_info = $this->model->auth($login_account);
        if ($user_info !== false) {
            Session::init();
            Session::set('user_info', $user_info);
            Session::set('login_state', true);
            Session::set('last_request_time', time());
            $message = 'ログイン成功';
            $this->tasklog->record(0, $message, $this->class_name, __FUNCTION__);
            header('location: ' . URL . 'home');
        } else {
            $message = 'ログインエラー';
            $this->tasklog->record(1, $message, $this->class_name, __FUNCTION__);
            header('location: ' . URL . 'login/error');
        }
    }

    // function createUser()
    // {
    //     $account = filter_input(INPUT_POST, 'account');
    //     $password = filter_input(INPUT_POST, 'password');
    //     $name = filter_input(INPUT_POST, 'name');
    //     if ($this->model->createUser($account, $name, $password) >= 0) {
    //         return true;
    //     };
    // }

    function error()
    {
        $this->view->alert = 'ログインできませんでした。';
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'index', 'Login');
    }

    function timeout()
    {
        header('location: ' . URL . 'login');
    }
}
