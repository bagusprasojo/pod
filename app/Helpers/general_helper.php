<?php

use App\Models\CartModel;
use App\Models\DesainModel;

if (!function_exists('get_jml_order_cart')) {
    function get_jml_order_cart()
    {
        $session = session();

        if ($session->has('id_user')) {
            $id_user = $session->get('id_user');
            
            $cartModel = new CartModel();

            $jml_order_cart = $cartModel->where('id_user', $id_user)->countAllResults();

            return $jml_order_cart;
        }

        // Jika user belum login, kembalikan 0
        return 0;
    }
}

if (!function_exists('get_jml_desain')) {
    function get_jml_desain()
    {
        $session = session();

        if ($session->has('id_user')) {
            $id_user = $session->get('id_user');
            
            $cartModel = new DesainModel();

            $jml_desain = $cartModel->where('id_user', $id_user)->countAllResults();

            return $jml_desain;
        }

        // Jika user belum login, kembalikan 0
        return 0;
    }
}

if (!function_exists('uang')) {

    function uang($money) {
        $h = 'Rp ' . number_format($money,0,'.','.');
        return $h;
    }

}

if (!function_exists('uangstrip')) {

    function uangstrip($money) {
        $h = 'Rp '.number_format($money,0,'.','.').',-';
        return $h;
    }

}

if (!function_exists('bilangan')) {

    function bilangan($money) {
        $h = number_format($money,0,'.','.');
        return $h;
    }

}

