<?php

class Customer extends Controller
{
    private $class_name = 'customer';

    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    function index()
    {
        $this->view->customer = $this->model->getAllCustomer();
        $this->view->birthday_customer = $this->model->getBirthdayCustomer();
        $this->view->birthday_customer_nextmonth = $this->model->getBirthdayNextmonthCustomer();
        $this->view->today_customer = $this->model->getTodayCustomer();
        $token = Session::setToken($this->class_name . '/index');
        $this->view->token = $token;
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'index', '顧客一覧');
    }

    function create()
    {
        $token = Session::setToken($this->class_name . '/create');
        $this->view->token = $token;
        $this->view->method = __FUNCTION__;
        $this->view->js = array($this->class_name . '/create.js');
        $this->view->render($this->class_name, 'create', '顧客登録');
    }

    function detail($id)
    {
        $token = Session::setToken($this->class_name . '/detail');
        $this->view->token = $token;
        $this->view->method = __FUNCTION__;
        $customer = $this->model->getCustomerById($id);
        $this->view->age = Util::getAgeForBirthday($customer['year'], $customer['month'], $customer['day']);
        $this->view->customer = $customer;
        $this->view->js = array($this->class_name . '/detail.js');
        $this->view->render($this->class_name, 'detail', '顧客詳細');
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
                    case 'name':
                    case 'kana':
                    case 'age':
                    case 'post':
                    case 'prefecture':
                    case 'city':
                    case 'address':
                    case 'apartment':
                    case 'lat':
                    case 'lng':
                    case 'children':
                    case 'tel':
                    case 'work':
                    case 'hobby':
                    case 'ad1_text':
                    case 'ad_other_text':
                    case 'work_style_text':
                    case 'sports_other_text':
                    case 'clinic_other_text':
                    case 'allergy_other_text':
                    case 'ope_parts':
                    case 'surgery_period':
                    case 'medicine_name':
                    case 'injury_parts':
                    case 'injury_period':
                    case 'trouble_parts':
                    case 'trouble_period':
                    case 'request_other_text':
                    case 'other':
                    case 'created_at':
                        $data[$key] = filter_input(INPUT_POST, $key);
                        break;
                    default: //checkbox radio
                        if (isset($_POST[$key]) && $_POST[$key] != '') {
                            $data[$key] = intval(filter_input(INPUT_POST, $key)); //valueの値をintに変換
                        } else { //nullの場合
                            $data[$key] = intval(0);
                        }
                        break;
                }
            }
            if ($save_flag === 'create') {
                $xml = $this->registerLatLngForGoogleMap($data);
                if ($xml->status == "OK") {
                    $data['lat'] = (string)$xml->result[0]->geometry[0]->location[0]->lat;
                    $data['lng'] = (string)$xml->result[0]->geometry[0]->location[0]->lng;
                    $detabase_result = $this->model->create('m_customer', $data);
                } else {
                    $detabase_result[0] = false;
                    $detabase_result[1] = $xml->error_message;
                }
            } elseif ($save_flag === 'update') {
                $data['updated_at'] = date('Y-m-d H:i:s');
                $xml = $this->registerLatLngForGoogleMap($data);
                if ($xml->status == "OK") {
                    $data['lat'] = (string)$xml->result[0]->geometry[0]->location[0]->lat;
                    $data['lng'] = (string)$xml->result[0]->geometry[0]->location[0]->lng;
                    $detabase_result = $this->model->update('m_customer', $data);
                } else {
                    $detabase_result[0] = false;
                    $detabase_result[1] = $xml->error_message;
                }
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

    function delete()
    {
        $result = array();
        $token = filter_input(INPUT_POST, 'token');
        $method = filter_input(INPUT_POST, 'method');
        $id = filter_input(INPUT_POST, 'id');
        if (Session::checkToken($this->class_name . '/' . $method, $token)) {
            $database_result = $this->model->deleteCustomer($id);
            if ($database_result[0] === true) {
                //不随する全てのデータ削除
                $result['result'] = "success";
                $this->tasklog->record(0, 'success', $this->class_name, __FUNCTION__);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } else {
                $result['result'] = "データベース削除に失敗しちゃった...";
                $this->tasklog->record(1, 'データベース削除エラー', $this->class_name, __FUNCTION__, $database_result[1]);
                echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        } else {
            $result['result'] = "登録に失敗したよ！とーくん？が違うみたいだよ。";
            $this->tasklog->record(1, 'トークンエラー', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    function search()
    {
        $token = filter_input(INPUT_POST, 'token');
        $method = filter_input(INPUT_POST, 'method');
        if (Session::checkToken($this->class_name . '/' . $method, $token)) {
            $name = filter_input(INPUT_POST, 'name');
            $database_result = $this->model->searchCustomerByName($name);
            echo json_encode($database_result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            $result['result'] = "登録に失敗したよ！とーくん？が違うみたいだよ。";
            $this->tasklog->record(1, 'トークンエラー', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    function search_initial()
    {
        $token = filter_input(INPUT_POST, 'token');
        $method = filter_input(INPUT_POST, 'method');
        if (Session::checkToken($this->class_name . '/' . $method, $token)) {
            $initial = filter_input(INPUT_POST, 'initial');
            $database_result = $this->model->searchCustomerByInitial($initial);
            echo json_encode($database_result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            $result['result'] = "登録に失敗したよ！とーくん？が違うみたいだよ。";
            $this->tasklog->record(1, 'トークンエラー', $this->class_name, __FUNCTION__);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    function registerLatLngForGoogleMap($data)
    {
        // 住所の連結
        $address_string = $data['prefecture'] . $data['city'] . $data['address'];
        // URLエンコードの適用
        $encoded_address = urlencode($address_string);
        $address = "https://maps.googleapis.com/maps/api/geocode/xml?address=" . $encoded_address . "&key=" . GEO_API;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $address);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if (empty($result)) {
            error_log("Geocoding Error: Empty response from Google API.");
            return null;
        }
        $xml = new SimpleXMLElement($result);
        return $xml;
    }
}
