<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        return view('index', [
            'heading' => 'Home'
        ]);
    }

    public function about()
    {
        return view('about', [
            'heading' => 'About'
        ]);
    }
}