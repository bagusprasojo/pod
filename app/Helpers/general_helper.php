<?php

use App\Models\CartModel;

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

