<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserDashboard extends BaseController
{
	// public function __construct() {
                
    // }

    public function index()
    {
        $session = session();
        if (!is_logged_in()) {
            $session->set('previous_url', current_url());
            return redirect()->to('/login')->with('error', 'Anda harus login untuk masuk ke halaman dashboard user');
        }
        // Add your code here.

        // Disini Anda dapat mengakses data-data pribadi user

        $id_user = $session->get('id_user');

        $userModel = new UserModel();
        $user = $userModel->where('id_user', $id_user)
                          ->first();

        $userData = [
            'username' => $user['username'],
            'name' => $user['name'],
            'email' => $user['email'],
            'address' => $user['address'],
            'id' => $user['id_user'],
            'follower_count' => $user['follower_count'],
            'following_count' => $user['following_count'],
        ];

        echo 'user_dashboard';
        die();



        return view('dashboard', [
            'userData' => $userData,
            'statistics' => $statistics,
            'latestReports'=>$latestReports,
            'pager'=>$pager
        ]);
    }

}