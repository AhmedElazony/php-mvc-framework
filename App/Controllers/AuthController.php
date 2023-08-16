<?php

namespace App\Controllers;

use Core\Application as App;
use Core\Database\Database;
use Core\ErrorBag;
use Core\Session;
use App\Models\UserModel;
use Core\Validator as Validate;

class AuthController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = model(UserModel::class);
    }

    public function loginUser(): void
    {
        $inputs = getInputs(['email', 'password']);

        if (!Validate::email($inputs['email'])) {
            ErrorBag::setError('email', 'Please Enter A Valid Email.');
        }
        if (!Validate::string($inputs['password'], 8, 255)) {
            ErrorBag::setError('password', 'Password Is Not Valid!');
        }

        $this->userModel->LoginUser($inputs['email'], $inputs['password']);
    }

    public function registerUser(): void
    {
        $inputs = getInputs(['username', 'email', 'password']);

        if (!Validate::string($inputs['username'], 5, 55)) {
            ErrorBag::setError('username', 'A Valid Username Should Be Between 5 and 55 Characters.');
        }
        if (!Validate::email($inputs['email'])) {
            ErrorBag::setError('email','Please Enter A Valid Email.');
        }
        if (!Validate::string($inputs['password'], 8, 255)) {
            ErrorBag::setError('password','A Valid Password Should Be Between 8 and 255 Characters.');
        }

        $this->userModel->registerUser($inputs['username'], $inputs['email'], $inputs['password']);
    }

    public function updatePassword(): void
    {
        $inputs = getInputs(['email', 'password']);

        if (! Validate::email($inputs['email'])) {
           ErrorBag::setError('email', 'Email Is Not Valid!');
        }
        if (! Validate::string($inputs['password'], 8, 255)) {
            ErrorBag::setError('password', 'Password Should Be Between 8 and 255 Characters!');
        }

        if (!empty(ErrorBag::errors())) {
            view("Password/update", [
                'errors' => ErrorBag::errors()
            ]);
            exit;
        }

        $this->userModel->updatePassword($inputs['email'], $inputs['password']);
    }

    public function logout(): void
    {
        Session::destroy();
        redirect("/");
    }
}