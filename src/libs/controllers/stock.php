<?php

class Stock extends Controller
{
    private $class_name = 'stock';

    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    function index()
    {
        $token = Session::setToken($this->class_name . '/index');
        $this->view->token = $token;
        $this->view->stock = $this->model->getStockAll();
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'index', '在庫確認');
    }

    function create()
    {
        $token = Session::setToken($this->class_name . '/create');
        $this->view->token = $token;
        $this->view->supplier = $this->model->getSupplierAll();
        $this->view->tax_rate = $this->getTaxRate();
        $this->view->js = array($this->class_name . '/create.js');
        $this->view->render($this->class_name, 'create', '商品仕入れ');
    }

    function detail($id)
    {
        $token = Session::setToken($this->class_name . '/detail');
        $this->view->token = $token;
        $this->view->stock = $this->model->getStockById($id);
        $this->view->stock_delivery = $this->model->getStockDeliveryById($id);
        $this->view->supplier = $this->model->getSupplierAll();
        $this->view->tax_rate = $this->getTaxRate();
        $this->view->js = array($this->class_name . '/detail.js');
        $this->view->render($this->class_name, 'detail', '在庫詳細');
    }

    function save()
    {
        $result = array();
        $database_result = array(
            'stock',
            'stock_products',
            's_stock'
        );
        $token = filter_input(INPUT_POST, 'token');
        $method = filter_input(INPUT_POST, 'method');
        if (Session::checkToken($this->class_name . '/' . $method, $token)) {
            $database_result['stock'] = $this->saveStock();
            if ($database_result['stock'][0] === true) {
                $database_result['stock_products'] = $this->saveStockProducts($database_result['stock'][1]);
            }
            if ($database_result['stock_products'][0] === true) {
                $database_result['s_stock'] = $this->saveStockState();
            }
            switch ($database_result) {
                case $database_result['stock'][0] === false:
                    $this->model->deleteStock($database_result['stock'][1]); //登録したデータの削除
                    $result['result'] = "仕入記録の登録に失敗しちゃった(/ω＼)";
                    $this->tasklog->record(1, '仕入記録登録エラー', $this->class_name, __FUNCTION__, $database_result['stock'][1]);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    break;
                case $database_result['stock_products'][0] === false:
                    $this->model->deleteStock($database_result['stock'][1]); //登録したデータの削除
                    $result['result'] = "仕入れ商品の登録に失敗しちゃった(/ω＼)";
                    $this->tasklog->record(1, '仕入れ商品登録エラー', $this->class_name, __FUNCTION__, $database_result['stock_products'][1]);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    break;
                case $database_result['s_stock'][0] === false:
                    $this->model->deleteStock($database_result['stock'][1]); //登録したデータの削除
                    $result['result'] = "在庫の更新に失敗しちゃった(/ω＼)";
                    $this->tasklog->record(1, '在庫更新エラー', $this->class_name, __FUNCTION__, $database_result['s_stock'][1]);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    break;
                default:
                    $result['result'] = "success";
                    $this->tasklog->record(0, 'success', $this->class_name, __FUNCTION__);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    break;
            }
        } else {
            $result['result'] = "登録に失敗したよ！とーくん？が違うみたいだよ。";
            $this->tasklog->record(1, 'トークンエラー', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    function saveStock()
    {
        $data['supplier_id'] = filter_input(INPUT_POST, 'supplier_id');
        $data['postage'] = filter_input(INPUT_POST, 'postage');
        $data['total_price'] = filter_input(INPUT_POST, 'total_price');
        $data['discount'] = filter_input(INPUT_POST, 'discount');
        $data['delivery_at'] = filter_input(INPUT_POST, 'delivery_at'); //仕入日
        $data['created_at'] = date('Y-m-d');
        return $this->model->create('t_stock', $data);
    }

    function saveStockProducts($stock_id)
    {
        $products_id = filter_input(INPUT_POST, 'products_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $tax_id = filter_input(INPUT_POST, 'tax_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $lot = filter_input(INPUT_POST, 'lot', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $cost = filter_input(INPUT_POST, 'cost', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $max_unit = filter_input(INPUT_POST, 'max_unit', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $lot_count = 0;
        foreach ($lot as $value) {
            $lot_count += $value;
        }
        $postage = filter_input(INPUT_POST, 'postage');
        $postage_cost = (round(($postage / $lot_count) * 100) / 100);

        $i = 0;
        foreach ($products_id as $id) {
            $stock_data[$i]['stock_id'] = $stock_id;
            $stock_data[$i]['products_id'] = $id;
            $stock_data[$i]['tax_id'] = intval($tax_id[$i]);
            $stock_data[$i]['cost'] = intval($cost[$i]);
            $stock_data[$i]['lot'] = intval($lot[$i]);
            $stock_data[$i]['max_unit'] = intval($max_unit[$i]);
            $stock_data[$i]['postage_cost'] = $postage_cost;
            $i++;
        }

        $i = 0;
        foreach ($stock_data as $value) {
            $colum_names = implode(', ', array_keys($value));
            $placeholders = ':' . implode(', :', array_keys($value));
            $sql[$i] = "INSERT INTO t_stock_products ($colum_names) VALUES ($placeholders);";
            $i++;
        }
        return $this->model->saveDetail($sql, $stock_data);
    }

    function saveStockState()
    {
        $products_id = filter_input(INPUT_POST, 'products_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $tax_id = filter_input(INPUT_POST, 'tax_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $lot = filter_input(INPUT_POST, 'lot', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $max_unit = filter_input(INPUT_POST, 'max_unit', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $cost = filter_input(INPUT_POST, 'cost', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $delivery_at = filter_input(INPUT_POST, 'delivery_at');
        $lot_count = 0;
        foreach ($lot as $value) {
            $lot_count += $value;
        }
        $postage = filter_input(INPUT_POST, 'postage');
        $postage_cost = (round(($postage / $lot_count) * 100) / 100);

        $i = 0;
        foreach ($products_id as $id) {
            $stock_data[$i]['products_id'] = $id;
            $stock_data[$i]['tax_id'] = intval($tax_id[$i]);
            $stock_data[$i]['cost'] = intval($cost[$i]);
            $stock_data[$i]['lot'] = intval($lot[$i]);
            $stock_data[$i]['max_unit'] = intval($max_unit[$i]);
            $stock_data[$i]['postage_cost'] = $postage_cost;
            $stock_data[$i]['delivery_at'] = $delivery_at;
            $i++;
        }

        $i = 0;
        foreach ($stock_data as $value) {
            $colum_names = implode(', ', array_keys($value));
            $placeholders = ':' . implode(', :', array_keys($value));
            $sql[$i] = "INSERT INTO s_stock ($colum_names) VALUES ($placeholders);";
            $i++;
        }
        return $this->model->saveDetail($sql, $stock_data);
    }

    function get_products_for_supplier()
    {
        $id = filter_input(INPUT_POST, 'id');
        $data = $this->model->getProductsBySupplierId($id);
        echo json_encode($data);
    }

    function getTaxRate()
    {
        $result = $this->model->getTaxRate();
        return json_encode($result);
    }

    function save_stock_price()
    {
        $data['price'] = intval(filter_input(INPUT_POST, 'price'));
        $data['products_id'] = intval(filter_input(INPUT_POST, 'products_id'));
        $result = $this->model->stock_price_update('s_stock', $data);
        if ($result[0] == true) {
            $result['result'] = "success";
            $this->tasklog->record(0, 'success', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            $result['result'] = "登録に失敗したよ！";
            $this->tasklog->record(1, '基本売値登録失敗', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}
