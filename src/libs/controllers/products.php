<?php

class Products extends Controller
{
    private $class_name = 'products';

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
        $this->view->method = __FUNCTION__;
        $this->view->products = $this->model->getAllProducts();
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'index', '商品一覧');
    }

    function create()
    {
        $token = Session::setToken($this->class_name . '/create');
        $this->view->token = $token;
        $this->view->method = __FUNCTION__;
        $this->view->supplier = $this->model->getSupplierAll();
        $this->view->tax_rate = $this->model->getTaxRate();
        $this->view->js = array($this->class_name . '/create.js');
        $this->view->render($this->class_name, 'create', '商品登録');
    }

    function detail($id)
    {
        $token = Session::setToken($this->class_name . '/detail');
        $this->view->token = $token;
        $this->view->method = __FUNCTION__;
        $this->view->products = $this->model->getProductsById($id);
        $this->view->supplier = $this->model->getSupplierAll();
        $this->view->tax = $this->model->getTaxRate();
        $this->view->js = array($this->class_name . '/detail.js');
        $this->view->render($this->class_name, 'detail', '商品詳細');
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
                $this->productsCreate($data);
            } else {
                $this->productsUpdate($data);
            }
        } else {
            $result['result'] = "登録に失敗したよ！とーくん？が違うみたいだよ。";
            $this->tasklog->record(1, 'トークンエラー', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    private function productsCreate($data)
    {
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $image_result = File::uploadImage('image', 'products');
            if ($image_result[1] === 'success') {
                $data['image1_link'] = $image_result[0];
                $database_result = $this->model->create('m_products', $data);
                if ($database_result[0] === true) {
                    $result['result'] = 'success';
                    $this->tasklog->record(0, 'success', $this->class_name . '/create', __FUNCTION__);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                } else {
                    $result['result'] = "登録に失敗したよ～(´；ω；`)ｳｩｩ";
                    $this->tasklog->record(1, 'データベース登録エラー', $this->class_name . '/create', __FUNCTION__, $database_result[1]);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                }
            } else {
                $result['result'] = $image_result[1];
                $this->tasklog->record(1, $result['result'], $this->class_name . '/create', __FUNCTION__);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        } else {
            $database_result = $this->model->create('m_products', $data);
            if ($database_result[0] === true) {
                $result['result'] = 'success';
                $this->tasklog->record(0, 'success', $this->class_name . '/create', __FUNCTION__);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } else {
                $result['result'] = "登録に失敗したよ～(´；ω；`)ｳｩｩ";
                $this->tasklog->record(1, 'データベース登録エラー', $this->class_name . '/create', __FUNCTION__);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        }
    }

    private function productsUpdate($data)
    {
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $delete_status  = ($data['image1_link']) ? $this->imageDelete($data['image1_link']) : true;
            if ($delete_status === true) {
                $image_result = File::uploadImage('image', 'products');
                if ($image_result[1] === 'success') {
                    $data['image1_link'] = $image_result[0];
                    $database_result = $this->model->update('m_products', $data);
                    $this->databaseResultCheck($database_result);
                } else {
                    $result['result'] = $image_result[1];
                    $this->tasklog->record(1, $result['result'], $this->class_name . '/update', __FUNCTION__);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                }
            } else {
                $result['result'] = '元画像の削除に失敗しちゃった';
                $this->tasklog->record(1, '元画像削除エラー', $this->class_name . '/update', __FUNCTION__, '', $delete_status);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        } else {
            $database_result = $this->model->update('m_products', $data);
            $this->databaseResultCheck($database_result);
        }
    }

    function databaseResultCheck($database_result)
    {
        if ($database_result[0] === true) {
            $result['result'] = 'success';
            $this->tasklog->record(0, 'success', $this->class_name . '/update', __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            $result['result'] = "更新に失敗したよ～(´；ω；`)ｳｩｩ";
            $this->tasklog->record(1, 'データベース更新エラー', $this->class_name . '/update', __FUNCTION__, $database_result[1]);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    function delete()
    {
        $result = array();
        $token = filter_input(INPUT_POST, 'token');
        $method = filter_input(INPUT_POST, 'method');
        $id = filter_input(INPUT_POST, 'id');
        $image1_link = filter_input(INPUT_POST, 'image1_link');
        if (Session::checkToken($this->class_name . '/' . $method, $token)) {
            //画像データ削除
            $image_result = ($image1_link) ? $this->imageDelete($image1_link) : true;
            if ($image_result === true) {
                $delete_result = $this->model->deleteProducts($id);
                if ($delete_result[0] === true) {
                    $result['result'] = 'success';
                    $this->tasklog->record(0, 'success', $this->class_name, __FUNCTION__);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                } else {
                    $result['result'] = "データベース削除に失敗しちゃった...";
                    $this->tasklog->record(1, 'データベース削除エラー', $this->class_name, __FUNCTION__, $delete_result[1]);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                }
            } else {
                $result['result'] = '元画像の削除に失敗したよ';
                $this->tasklog->record(1, '元画像削除エラー', $this->class_name, __FUNCTION__, '', $image_result);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        } else {
            $result['result'] = "登録に失敗したよ！とーくん？が違うみたいだよ。";
            $this->tasklog->record(1, 'トークンエラー', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    function imageDelete($data)
    {
        $filename = basename((string)$data);
        if ($filename === '' || $filename === '.' || $filename === '..') {
            return true;
        }
        $path = DOC_ROOT . 'images/products/' . $filename;
        $realBase = realpath(DOC_ROOT . 'images/products');
        $realFile = realpath($path);
        if ($realBase === false) {
            return true;
        }
        if ($realFile !== false && strpos($realFile, $realBase) === 0 && is_file($realFile)) {
            return @unlink($realFile);
        }
        return true;
    }
}
