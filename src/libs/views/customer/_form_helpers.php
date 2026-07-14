<?php
/**
 * 顧客フォーム用ヘルパー（create / detail 共通）
 */
$customer = $customer ?? ($this->customer ?? null);

if (!function_exists('customer_field_value')) {
    function customer_field_value($customer, $key, $default = '')
    {
        if (!is_array($customer) || !array_key_exists($key, $customer) || $customer[$key] === null) {
            return $default;
        }
        return $customer[$key];
    }
}

if (!function_exists('customer_is_checked')) {
    function customer_is_checked($customer, $key, $expect = 1)
    {
        return (int)customer_field_value($customer, $key, 0) === (int)$expect;
    }
}
