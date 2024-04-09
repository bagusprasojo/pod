<?php

if (!function_exists('is_logged_in')) {
    function is_logged_in()
    {
        // Logika untuk memeriksa apakah pengguna sudah login
        // Misalnya, periksa sesi atau status autentikasi pengguna

        // Gantikan dengan logika validasi sesuai dengan kebutuhan Anda
        
        return isset($_SESSION['id_user']); // Contoh: Cek apakah ada 'user_id' di sesi
    }
}

if (!function_exists('show_auth')) {
    function show_auth()
    {
        echo "show_auth";
    }
}
