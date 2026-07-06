<?php

class Analysis extends Controller
{
    private $class_name = 'analysis';

    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    function index()
    {
        $this->view->all_reservation_graph = $this->getReservationRateAllVisitors(); //全体予約率
        $this->view->new_reservation_graph = $this->getReservationRateNewVisitors(); //新規予約率
        $this->view->existing_reservation_graph = $this->getReservationRateExistingVisitors(); //既存予約率
        $this->view->all_visitors_graph = $this->getAllVisitorsCount(); //総顧客数
        $this->view->new_visitors_graph = $this->getNewVisitorsCount(); //新規顧客
        $this->view->existing_visitors_graph = $this->getExistingVisitorsCount(); //既存顧客
        $this->view->advertisement_graph = $this->getAdvertisement(); //何で当店を知ったか
        $this->view->total_sales_graph = $this->getTotalSalesAll(); //今までの年ごとの総売り上げ
        $this->view->total_grossprofit_graph = $this->getTotalGrossProfitAll(); //今までの年ごとの売上総利益(商品粗利)
        $token = Session::setToken($this->class_name . '/index');
        $this->view->token = $token;
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'index', '総合分析');
    }

    function getReservationRateAllVisitors()
    {
        $visitors_count = $this->model->getAllVisitorsCount();
        $reservation_count = $this->model->getAllReservationCount();
        foreach ($visitors_count as $key => $count) {
            if (!empty($reservation_count[$key])) {
                if ($count['visitors_count'] <= 0) {
                    $reservation_rate[$key]['reservation_rate'] = 0;
                } else {
                    $reservation_rate[$key]['reservation_rate'] = (floor(($reservation_count[$key]['reservation_count'] / $count['visitors_count']) * 10000) / 100);
                }
            }
            $reservation_rate[$key]['created_at'] = $count['created_at'];
        }
        return json_encode($reservation_rate);
    }

    function getReservationRateNewVisitors()
    {
        $visitors_count = $this->model->getNewVisitorsCount();
        $reservation_count = $this->model->getNewReservationCount();
        foreach ($visitors_count as $key => $count) {
            if (!empty($reservation_count[$key])) {
                if ($count['visitors_count'] <= 0) {
                    $reservation_rate[$key]['reservation_rate'] = 0;
                } else {
                    $reservation_rate[$key]['reservation_rate'] = (floor(($reservation_count[$key]['reservation_count'] / $count['visitors_count']) * 10000) / 100);
                }
            }
            $reservation_rate[$key]['created_at'] = $count['created_at'];
        }
        return json_encode($reservation_rate);
    }

    function getReservationRateExistingVisitors()
    {
        $visitors_count = $this->model->getExistingVisitorsCount();
        $reservation_count = $this->model->getExistingReservationCount();
        foreach ($visitors_count as $key => $count) {
            if (!empty($reservation_count[$key])) {
                if ($count['visitors_count'] <= 0) {
                    $reservation_rate[$key]['reservation_rate'] = 0;
                } else {
                    $reservation_rate[$key]['reservation_rate'] = (floor(($reservation_count[$key]['reservation_count'] / $count['visitors_count']) * 10000) / 100);
                }
            }
            $reservation_rate[$key]['created_at'] = $count['created_at'];
        }
        return json_encode($reservation_rate);
    }

    function getAllVisitorsCount()
    {
        $visitors_count = $this->model->getAllVisitorsCount();
        return json_encode($visitors_count);
    }

    function getNewVisitorsCount()
    {
        $visitors_count = $this->model->getNewVisitorsCount();
        return json_encode($visitors_count);
    }

    function getExistingVisitorsCount()
    {
        $visitors_count = $this->model->getExistingVisitorsCount();
        return json_encode($visitors_count);
    }

    function getAdvertisement()
    {
        $result = $this->model->getAdvertisement();
        return json_encode($result[0]);
    }

    function getTotalSalesAll()
    {
        $menu = $this->model->getMenuSalesByYear();
        $products = $this->model->getProductsSalesByYear();
        foreach ($menu as $key => $value) {
            $total_sales[$key]['sales'] = $value['gross_profit'] + $products[$key]['price'];
            $total_sales[$key]['year'] = $value['year'];
        }
        return json_encode($total_sales);
    }

    function getTotalGrossProfitAll()
    {
        $menu = $this->model->getMenuSalesByYear();
        $products = $this->model->getProductsSalesByYear();
        foreach ($menu as $key => $value) {
            $total_grossprofit[$key]['grossprofit'] = $value['gross_profit'] + $products[$key]['price'] - $products[$key]['cost'];
            $total_grossprofit[$key]['year'] = $value['year'];
        }
        return json_encode($total_grossprofit);
    }
}
