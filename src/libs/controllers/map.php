<?php

class Map extends Controller
{
    private $class_name = 'map';

    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    function index()
    {
        $this->view->customer_geo = $this->getCustomerGeoAll();
        $this->view->customer_geo_recently = $this->getCustomerGeoRecently();
        $token = Session::setToken($this->class_name . '/index');
        $this->view->token = $token;
        $this->view->js = array($this->class_name . '/index.js');
        $this->view->render($this->class_name, 'index', '顧客マップ');
    }

    function getCustomerGeoAll()
    {
        $customer = $this->model->getCustomerGeoAll();
        return json_encode($customer);
    }

    function getCustomerGeoRecently()
    {
        $customer = $this->model->getCustomerGeoRecently();
        return json_encode($customer);
    }
}
