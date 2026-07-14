<?php

class Supplier extends Controller
{
    private $class_name = 'supplier';

    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
        Auth::requireAdmin();
    }

    function index()
    {
        $token = Session::setToken($this->class_name . '/index');
        $this->view->token = $token;
        $this->view->supplier = $this->model->getSupplierAll();
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'index', '仕入先一覧');
    }
    function save()
    {
        $data = array();
        $result = array();
        $token = filter_input(INPUT_POST, 'token');
        $method = filter_input(INPUT_POST, 'method');
        if (Session::checkToken($this->class_name . '/' . $method, $token)) {
            $keys = array_keys($_POST);
            foreach ($keys as $key) {
                switch ($key) {
                    case 'token':
                    case 'method':
                        break;
                    case 'save_flag':
                        $save_flag = filter_input(INPUT_POST, $key);
                        break;
                    default:
                        $data[$key] = filter_input(INPUT_POST, $key);
                        break;
                }
            }
            if ($save_flag  === 'create') {
                $detabase_result = $this->model->create('m_supplier', $data);
            } else {
                $detabase_result = $this->model->update('m_supplier', $data);
            }
            if ($detabase_result[0] === true) {
                $result['result'] = "success";
                $this->tasklog->record(0, 'success', $this->class_name . '/' . $save_flag, __FUNCTION__);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } else {
                $result['result'] = "登録に失敗したよ～(´；ω；`)ｳｩｩ";
                $this->tasklog->record(1, 'データベース登録エラー', $this->class_name . '/' . $save_flag, __FUNCTION__, $detabase_result[1]);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        } else {
            $result['result'] = "登録に失敗したよ！とーくん？が違うみたいだよ。";
            $this->tasklog->record(1, 'トークンエラー', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}
