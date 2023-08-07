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
    public function loginUser(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!Validate::email($email)) {
            ErrorBag::setError('email', 'Please Enter A Valid Email.');
        }
        if (!Validate::string($password, 8, 255)) {
            ErrorBag::setError('password', 'Password Is Not Valid!');
        }

        $this->userModel = model(UserModel::class);
        $this->userModel->LoginUser($email, $password);
    }

    public function registerUser(): void
    {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!Validate::string($username, 5, 55)) {
            ErrorBag::setError('username', 'A Valid Username Should Be Between 5 and 55 Characters.');
        }
        if (!Validate::email($email)) {
            ErrorBag::setError('email','Please Enter A Valid Email.');
        }
        if (!Validate::string($password, 8, 255)) {
            ErrorBag::setError('password','A Valid Password Should Be Between 8 and 255 Characters.');
        }

        $this->userModel = new UserModel(App::resolve(Database::class));
        $this->userModel->registerUser($username, $email, $password);
    }

    public function updatePassword(): void
    {
        $email = $_POST['email'] ?? '';
        $newPassword = $_POST['password'] ?? '';

        if (! Validate::email($email)) {
           ErrorBag::setError('email', 'Email Is Not Valid!');
        }
        if (! Validate::string($newPassword, 8, 255)) {
            ErrorBag::setError('password', 'Password Should Be Between 8 and 255 Characters!');
        }

        if (!empty(ErrorBag::errors())) {
            view("Password/update", [
                'errors' => ErrorBag::errors()
            ]);
            exit;
        }

        $this->userModel = model(UserModel::class);
        $this->userModel->updatePassword($email, $newPassword);
    }

    public function logout(): void
    {
        Session::destroy();
        redirect("/");
    }
}