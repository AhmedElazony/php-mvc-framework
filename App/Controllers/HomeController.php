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

    public function contact()
    {
        return view('contact', [
            'heading' => 'Contact Us!'
        ]);
    }
}