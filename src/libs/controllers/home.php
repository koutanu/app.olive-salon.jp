<?php

class Home extends Controller
{
    private $class_name = 'home';

    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    function index()
    {
        $token = Session::setToken($this->class_name . '/index');
        $this->view->token = $token;
        $date = date('Y-m-d');
        $this->date = $date;
        $this->view->stock = $this->model->getStockAll();
        $this->view->grossprofit_graph = $this->getGrossProfitMonthly(); //施術売上高 + 商品売上高
        $this->view->total_sales = $this->getTotalSales(); //年間総売り上げ(施術売上 + 商品粗利)
        $this->view->menu_graph = $this->getMenuGrossProfitMonthly(); //施術売上高
        $this->view->products_graph = $this->getProductsSalesMonthly(); //商品売上高
        $this->view->age_group = $this->getAgeGroup(); //年齢層
        $this->view->products_monthly = $this->getProductsCountMonthly(); //当月商品売上個数
        $this->view->ave_grossprofit = $this->getAveGrossProfit(); // 平均 施術売上高 + 商品売上高
        $this->view->ave_menu = $this->getAveMenu(); // 平均 施術売上高
        $this->view->ave_products = $this->getAveProducts(); // 平均 商品売上高
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'index', 'Olive Salon');
    }

    function getAgeGroup()
    {
        $age_group = array(
            'under 10' => 0,
            '10s' => 0,
            '20s' => 0,
            '30s' => 0,
            '40s' => 0,
            '50s' => 0,
            '60s' => 0,
            '70s' => 0,
            '80s' => 0,
            '90s' => 0,
            '100s' => 0,
        );
        $customer = $this->model->getCustomerBirthday();
        $today = date('Ymd');
        foreach ($customer as $value) {
            $birthday = $value['year'] . '-' . $value['month'] . '-' . $value['day'];
            $birthday_format = date('Ymd', strtotime($birthday));
            $age = floor(($today - intval($birthday_format)) / 10000);
            $floor_age = (floor($age / 10) * 10);
            if ($floor_age < 10) {
                $age_group['under 10']++;
            } else {
                $age_group[$floor_age . 's']++;
            }
        }
        foreach ($age_group as $key => $value) {
            if ($value === 0) {
                unset($age_group[$key]);
            }
        }
        return json_encode($age_group);
    }

    function getGrossProfitMonthly()
    {
        $gross_profit = [];
        $menu = $this->model->getMenuGrossProfitMonthly();
        $products = $this->model->getProductsGrossProfitMonthly();
        foreach ($menu as $key => $value) {
            $gross_profit[$key]['gross_profit'] = $value['gross_profit'] + $products[$key]['price'] - $products[$key]['cost'];
            $gross_profit[$key]['created_at'] = $value['created_at'];
        }
        return json_encode($gross_profit);
    }

    function getTotalSales()
    {
        $total_sales = 0;
        $menu = $this->model->getMenuGrossProfitYearly();
        $products = $this->model->getProductsGrossProfitYearly();
        foreach ($menu as $key => $value) {
            $total_sales += $value['gross_profit'] + $products[$key]['price'];
        }
        return $total_sales;
    }

    function getPurchasePriceMonthly()
    {
        $products = $this->model->getPurchasePriceMonthly();
        return json_encode($products);
    }

    function getMenuGrossProfitMonthly()
    {
        $products = $this->model->getMenuGrossProfitMonthly();
        return json_encode($products);
    }

    function getProductsSalesMonthly()
    {
        $products = $this->model->getProductsSalesMonthly();
        return json_encode($products);
    }

    function getProductsCountMonthly()
    {
        $products = $this->model->getProductsCountMonthly(date('Ym'));
        return json_encode($products);
    }

    function get_products_count_monthly()
    {
        $date = str_replace('-', '', filter_input(INPUT_POST, 'date'));
        $products = $this->model->getProductsCountMonthly($date);
        echo json_encode($products);
    }

    //平均
    function getAveGrossProfit()
    {
        $gross_profit = [];
        $menu = $this->model->getAveMenuGrossProfitMonthly();
        $products = $this->model->getAveProductsGrossProfitMonthly();
        foreach ($menu as $key => $value) {
            $gross_profit[$key]['gross_profit'] = $value['gross_profit'] + $products[$key]['price'] - $products[$key]['cost'];
            $gross_profit[$key]['created_at'] = $value['created_at'];
        }
        $sum = 0;
        foreach ($gross_profit as $value) {
            $sum += $value['gross_profit'];
        }
        if (count($gross_profit) > 0) {
            return floor(($sum / count($gross_profit)));
        }
    }

    function getAveMenu()
    {
        $products = $this->model->getAveMenuGrossProfitMonthly();
        $sum = 0;
        foreach ($products as $value) {
            $sum += $value['gross_profit'];
        }
        if (count($products) > 0) {
            return floor(($sum / count($products)));
        }
    }

    function getAveProducts()
    {
        $products = $this->model->getAveProductsSalesMonthly();
        $sum = 0;
        foreach ($products as $value) {
            $sum += $value['gross_profit'];
        }
        if (count($products) > 0) {
            return floor(($sum / count($products)));
        }
    }
}
