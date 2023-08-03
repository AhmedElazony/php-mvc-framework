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

    public function loginUser()
    {
        return view('Session/create', [
            'heading' => 'Login'
        ]);
    }

    public function registerUser()
    {
        return view('Registration/create', [
            'heading' => 'Register'
        ]);
    }

    public function editPassword()
    {
        return view('Password/update', [
            'heading' => 'Update Password'
        ]);
    }
}