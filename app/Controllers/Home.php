<?php

namespace App\Controllers;

class Home extends BaseController
{
    // public function index(): string
    // {
    //     return view('welcome_message');
    // }
    public function index()
{
    $data['title'] = "Beranda Lab Fisika Dasar";
    return view('home_view', $data);
}
}
