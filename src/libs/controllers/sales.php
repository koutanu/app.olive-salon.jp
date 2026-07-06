<?php

class Sales extends Controller
{
    private $class_name = 'sales';

    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    function index($id)
    {
        $this->view->token = Session::setToken($this->class_name . '/index');
        $this->view->method = __FUNCTION__;
        $customer = $this->model->getCustomerById($id);
        $this->view->age = Util::getAgeForBirthday($customer['year'], $customer['month'], $customer['day']);
        $this->view->customer = $customer;
        $this->view->grossprofit_graph = $this->getGrossProfitMonthlyById($id); //施術売上高 + 商品粗利
        $this->view->menu_graph = $this->getMenuGrossProfitMonthlyById($id); //施術売上高
        $this->view->products_graph = $this->getProductsGrossProfitMonthlyById($id); //商品粗利
        $sales = $this->model->getSalesById($id);
        $this->view->sales = $sales;
        $this->view->next_reservation_date = (!empty($sales[0]['next_reservation_date'])) ? date('Y年m月d日', strtotime($sales[0]['next_reservation_date'])) : '予約なし';
        $this->view->last_visit = ($sales) ? Util::getLastVisit($sales[0]['created_at']) : '来店無し';
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'index', '顧客別売上');
    }

    function calendar($date)
    {
        $this->view->today_customer = $this->model->getTodayCustomer();
        $this->view->year = substr($date, 0, 4);
        $this->view->month = substr($date, 4, 5);
        $this->view->sales = $this->model->getSalesToMonth($date);
        $this->view->reservation_customer = $this->model->getReservationCustomerByDate($date);
        $this->view->cancel_customer = $this->model->getCancelCustomerByDate($date);
        $this->view->products_grossprofit = $this->model->getProductsGrossProfitByDate($date);
        $this->view->token = Session::setToken($this->class_name . '/calendar');
        $this->view->method = __FUNCTION__;
        $this->view->js = array($this->class_name . '/calendar.js');
        $this->view->render($this->class_name, 'calendar', '売上カレンダー');
    }

    function create($id)
    {
        $customer = $this->model->getCustomerById($id);
        $this->view->customer = $customer;
        $this->view->age = Util::getAgeForBirthday($customer['year'], $customer['month'], $customer['day']);
        $this->view->menu_list = $this->model->getMenuListAll();
        $this->view->option_list = $this->model->getOptionListAll();
        $this->view->stock = $this->model->getAllStock();
        $this->view->tax_rate = json_encode($this->model->getTaxRate());
        $this->view->reservation_discount = $this->getReservationDiscount($id);
        $this->view->token = Session::setToken($this->class_name . '/create');
        $this->view->js = array($this->class_name . '/create.js');
        $this->view->render($this->class_name, 'create', '売上登録');
    }

    function detail($id)
    {
        $this->view->token = Session::setToken($this->class_name . '/detail');
        $this->view->method = __FUNCTION__;
        $this->view->sales = $this->model->getSalesDetailById($id);
        $this->view->menu_option = $this->model->getMenuOptionById($id);
        $this->view->products = $this->model->getSalesProductsById($id);
        $this->view->js = array($this->class_name . '/detail.js');
        $this->view->render($this->class_name, 'detail', '売上詳細');
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
                    case 'stock_id':
                    case 'tax_id':
                    case 'products_id':
                    case 'products_discount':
                    case 'products_sales':
                    case 'products_price':
                    case 'unit':
                    case 'lot':
                    case 'max_unit':
                    case 'stock_unit':
                    case 'method':
                    case 'token':
                    case 'menu_option':
                        break; //商品売上は全部除外
                    case 'next_reservation_flag': //flag処理
                        $data[$key] = true;
                        break;
                    case 'menu_id':
                        if (empty(filter_input(INPUT_POST, $key))) {
                            break;
                        } else {
                            $data[$key] = filter_input(INPUT_POST, $key);
                            break;
                        }
                    default:
                        $data[$key] = filter_input(INPUT_POST, $key);
                        break;
                }
            }
            $detabase_result = $this->model->create('t_sales', $data);
            if ($detabase_result[0] === true) {
                $menu_option = filter_input(INPUT_POST, 'menu_option', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                if (isset($menu_option)) {
                    $option_result = $this->setMenuOption($detabase_result[1]);
                } else {
                    $option_result = true;
                }
                if ($option_result != true) {
                    $this->model->deleteSales($detabase_result[1]);
                    $result['result'] = "オプションの登録に失敗しちゃった(/ω＼)";
                    $this->tasklog->record(1, 'オプション登録エラー', $this->class_name, __FUNCTION__);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                } else {
                    $products_id = filter_input(INPUT_POST, 'products_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                    if (isset($products_id)) {
                        $products_result = $this->setStock($detabase_result[1]);
                    } else {
                        $products_result = true;
                    }
                    if ($products_result === true) {
                        $result['result'] = "success";
                        $this->tasklog->record(0, 'success', $this->class_name, __FUNCTION__);
                        echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    } else {
                        $this->model->deleteSales($detabase_result[1]);
                        $result['result'] = "商品売上の登録に失敗しちゃった(/ω＼)";
                        $this->tasklog->record(1, '商品売上登録エラー', $this->class_name, __FUNCTION__);
                        echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    }
                }
            } else {
                $result['result'] = "登録に失敗したよ～(´；ω；`)ｳｩｩ";
                $this->tasklog->record(1, 'データベース登録エラー', $this->class_name, __FUNCTION__, $detabase_result[1]);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        } else {
            $result['result'] = "登録に失敗したよ！とーくん？が違うみたいだよ。";
            $this->tasklog->record(1, 'トークンエラー', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    function setStock($sales_id)
    {
        $result = $this->setStockUnitData($sales_id);
        if ($result != true) {
            return false;
        }
        $result = $this->setStockLotData($sales_id);
        if ($result != true) {
            return false;
        }
        return true;
    }

    function setMenuOption($sales_id)
    {
        $option_ids = filter_input(INPUT_POST, 'menu_option', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        foreach ($option_ids as $id) {
            $data['sales_id'] = $sales_id;
            $data['menu_option_id'] = $id;
            $create_result = $this->model->create('t_sales_menu_option', $data);
            if ($create_result[0] != true) {
                return false;
            }
        }
        return true;
    }

    function setStockUnitData($sales_id)
    {
        $products_ids = filter_input(INPUT_POST, 'products_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $unit = filter_input(INPUT_POST, 'unit', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $max_unit = filter_input(INPUT_POST, 'max_unit', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $price = filter_input(INPUT_POST, 'products_price', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $tax_id = filter_input(INPUT_POST, 'tax_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $i = 0;
        foreach ($products_ids as $products_id) {
            if ($unit[$i] > 0) {
                $current_stock = $this->model->getStockUnitById($products_id);
                $unit_number = $current_stock['unit'] - $unit[$i];
                if ($unit_number < 0) {
                    while ($unit_number < 0) { //unit数がマイナスの場合
                        if ($current_stock['lot'] > 0) { //lotがある場合はlotをばらす。
                            $lot_data['id'] = $current_stock['id'];
                            $lot_data['lot'] = $current_stock['lot'] - 1;
                            $update_result = $this->model->update('s_stock', $lot_data); //lotの更新
                            if ($update_result[0] != true) {
                                return false;
                            }
                            $unit_data['id'] = $current_stock['id'];
                            $unit_data['unit'] = $max_unit[$i] - abs($unit_number);
                            $update_result = $this->model->update('s_stock', $unit_data); //unitの更新
                            $sales_data['sales_id'] = $sales_id;
                            $sales_data['unit'] = abs($unit_number);
                            $sales_data['stock_id'] = $current_stock['id'];
                            $sales_data['price'] = ($price[$i] / $max_unit[$i]) * abs($unit_number);
                            $sales_data['cost'] = ($current_stock['cost'] / $max_unit[$i]) * abs($unit_number);
                            $sales_data['postage_cost'] = ($current_stock['postage_cost'] / $max_unit[$i]) * abs($unit_number);
                            $sales_data['tax_id'] = $tax_id[$i];
                            $create_result = $this->model->create('t_sales_products', $sales_data);
                            if ($update_result[0] != true || $create_result[0] != true) {
                                return false;
                            }
                            $unit_number = 0;
                        } else {
                            $unit_data['unit'] = 0;
                            $unit_data['id'] = $current_stock['id'];
                            $update_result = $this->model->update('s_stock', $unit_data);
                            $sales_data['sales_id'] = $sales_id;
                            $sales_data['unit'] = $current_stock['unit'];
                            $sales_data['stock_id'] = $current_stock['id'];
                            $sales_data['price'] = ($price[$i] / $max_unit[$i]) * abs($unit_number);
                            $sales_data['cost'] = ($current_stock['cost'] / $max_unit[$i]) * abs($unit_number);
                            $sales_data['postage_cost'] = ($current_stock['postage_cost'] / $max_unit[$i]) * abs($unit_number);
                            $sales_data['tax_id'] = $tax_id[$i];
                            $create_result = $this->model->create('t_sales_products', $sales_data);
                            if ($update_result[0] != true || $create_result[0] != true) {
                                return false;
                            }
                            $current_stock = $this->model->getStockUnitById($products_id);
                            $unit_number = $current_stock['unit'] - abs($unit_number);
                        }
                    }
                } else {
                    $data['unit'] = $unit_number;
                    $data['id'] = $current_stock['id'];
                    $update_result = $this->model->update('s_stock', $data);
                    $sales_data['sales_id'] = $sales_id;
                    $sales_data['unit'] = $unit[$i];
                    $sales_data['stock_id'] = $current_stock['id'];
                    $sales_data['price'] = ($price[$i] / $max_unit[$i]) * abs($unit[$i]);
                    $sales_data['cost'] = ($current_stock['cost'] / $max_unit[$i]) * abs($unit[$i]);
                    $sales_data['postage_cost'] = ($current_stock['postage_cost'] / $max_unit[$i]) * abs($unit[$i]);
                    $sales_data['tax_id'] = $tax_id[$i];
                    $create_result = $this->model->create('t_sales_products', $sales_data);
                    if ($update_result[0] != true || $create_result[0] != true) {
                        return false;
                    }
                }
            }
            $i++;
        }
        return true;
    }

    function setStockLotData($sales_id)
    {
        $products_ids = filter_input(INPUT_POST, 'products_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $lot = filter_input(INPUT_POST, 'lot', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $price = filter_input(INPUT_POST, 'products_price', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $tax_id = filter_input(INPUT_POST, 'tax_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        $i = 0;
        foreach ($products_ids as $products_id) {
            if ($lot[$i] > 0) {
                $current_stock = $this->model->getStockLotById($products_id);
                $lot_number = $current_stock['lot'] - $lot[$i];
                while ($lot_number < 0) {
                    $stock_data['lot'] = 0;
                    $stock_data['id'] = $current_stock['id'];
                    $update_result = $this->model->update('s_stock', $stock_data);
                    $sales_data['sales_id'] = $sales_id;
                    $sales_data['lot'] = $current_stock['lot'];
                    $sales_data['stock_id'] = $current_stock['id'];
                    $sales_data['price'] = $price[$i] * $current_stock['lot'];
                    $sales_data['cost'] = $current_stock['cost'] * $current_stock['lot'];
                    $sales_data['postage_cost'] = $current_stock['postage_cost'] * $current_stock['lot'];
                    $sales_data['tax_id'] = $tax_id[$i];
                    $create_result = $this->model->create('t_sales_products', $sales_data);
                    if ($update_result[0] != true || $create_result[0] != true) {
                        return false;
                    }
                    $current_stock = $this->model->getStockLotById($products_id);
                    $lot_number = $current_stock['lot'] - abs($lot_number);
                }
                $stock_data['lot'] = $lot_number;
                $stock_data['id'] = $current_stock['id'];
                $update_result = $this->model->update('s_stock', $stock_data);
                $sales_data['sales_id'] = $sales_id;
                $sales_data['lot'] = $lot[$i];
                $sales_data['stock_id'] = $current_stock['id'];
                $sales_data['price'] = $price[$i] * $lot[$i];
                $sales_data['cost'] = $current_stock['cost'] * $lot[$i];
                $sales_data['postage_cost'] = $current_stock['postage_cost'] * $lot[$i];
                $sales_data['tax_id'] = $tax_id[$i];
                $create_result = $this->model->create('t_sales_products', $sales_data);
                if ($update_result[0] != true || $create_result[0] != true) {
                    return false;
                }
            }
            $i++;
        }
        return true;
    }

    function getGrossProfitMonthlyById($id)
    {
        $menu = $this->model->getMenuGrossProfitMonthlyById($id);
        $products = $this->model->getProductsGrossProfitMonthlyById($id);
        foreach ($menu as $key => $value) {
            $gross_profit[$key]['gross_profit'] = $value['gross_profit'] + $products[$key]['gross_profit'] - $products[$key]['cost'];
            $gross_profit[$key]['created_at'] = $value['created_at'];
        }
        return json_encode($gross_profit);
    }

    function getMenuGrossProfitMonthlyById($id)
    {
        $products = $this->model->getMenuGrossProfitMonthlyById($id);
        return json_encode($products);
    }

    function getProductsGrossProfitMonthlyById($id)
    {
        $products = $this->model->getProductsGrossProfitMonthlyById($id);
        return json_encode($products);
    }

    function delete()
    {
        $token = filter_input(INPUT_POST, 'token');
        $method = filter_input(INPUT_POST, 'method');
        if (Session::checkToken($this->class_name . '/' . $method, $token)) {
            $id = filter_input(INPUT_POST, 'id');
            $delete_flag = $this->model->deleteSales($id);
            if ($delete_flag[0] == true) {
                $result['result'] = "success";
                $this->tasklog->record(0, 'success', $this->class_name, __FUNCTION__);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } else {
                $result['result'] = "削除に失敗したよ！";
                $this->tasklog->record(1, 'データベースエラー', $this->class_name, __FUNCTION__, $delete_flag[1]);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        } else {
            $result['result'] = "削除に失敗したよ！とーくん？が違うみたいだよ。";
            $this->tasklog->record(1, 'トークンエラー', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    function getMenuGrossProfitMonthly()
    {
        $products = $this->model->getMenuGrossProfitMonthly();
        return json_encode($products);
    }

    function cancel()
    {
        $data['id'] = filter_input(INPUT_POST, 'id');
        $flag = filter_input(INPUT_POST, 'flag');
        if ($flag == 1) {
            $data['cancel_flag'] = 0;
        } else {
            $data['cancel_flag'] = 1;
        }
        $result = $this->model->update('t_sales', $data);
        echo json_encode($result);
    }

    function getReservationDiscount($id)
    {
        $discount = 0;
        $sales = $this->model->getSalesLastByIdNotCancel($id);
        if (empty($sales) || $sales['cancel_flag'] == 1) {
            return $discount;
        }
        if ($sales['next_reservation_flag'] == 1) {
            $discount += 500;
        }
        $last_time = new DateTime($sales['created_at']);
        $today = new DateTime(date('Y-m-d'));
        $diff = $last_time->diff($today);
        $number_of_days = $diff->days;
        if ($number_of_days <= 14) {
            $discount += 1000;
        } elseif ($number_of_days <= 21) {
            $discount += 500;
        }
        return $discount;
    }

    function change_reservation()
    {
        $data['id'] = filter_input(INPUT_POST, 'id');
        $data['next_reservation_flag'] = 1;
        $data['next_reservation_date'] = filter_input(INPUT_POST, 'reservation_date');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $result = $this->model->update('t_sales', $data);
        echo json_encode($result);
    }
}
