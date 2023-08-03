<?php

namespace App\Models;

use Core\ErrorBag;

class UserModel extends Model
{
    public function setUser($username, $email, $password)
    {
        $this->db->insert('user', [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
    }
    public function getUser(array $filters): bool|array
    {
        return $this->db->selectWhere('user', '=', $filters);
    }
    public function update(string $columnValue, $filters)
    {
        $this->db->update('user', $columnValue, $filters);
    }

    public function loginUser($email, $password)
    {
        // Check if The email Exists in The DB.
        $user = $this->getUser(['email' => $email]);

        if (!$user) {
            // This Means The User Doesn't Exist.
            ErrorBag::setError('email',"This Email Doesn't Exist.");
        } else {
            if (password_verify($password, $user['password'])) {
                // This Means Inputs Are Correct, Redirect To Home Page.
                login('user', [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email']
                ]);
                redirect("/");
            } else {
                ErrorBag::setError('password','Password is Incorrect!');
            }
        }

        if (!empty(ErrorBag::errors())) {
            view('Session/create', [
                'errors' => ErrorBag::errors()
            ]);
            exit;
        }
    }

    public function registerUser($username, $email, $password)
    {
        if (!empty(ErrorBag::errors())) {
            return view('Registration/create', [
                'errors' => ErrorBag::errors()
            ]);
        }

        // Check if The email is already exists in the DB.
        $user = $this->getUser(['email' => $email]);

        if ($user) {
            // This Means It's Already Exists in The DB.
            ErrorBag::setError('email', 'Email Already Exists!');
        } else {
            // This Means This is A New User.
            $this->setUser($username, $email, $password);
            // redirect to login page.
            redirect("/login");
        }

        return view('Registration/create', [
            'errors' => ErrorBag::errors()
        ]);
    }

    public function updatePassword($email, $newPassword)
    {
        $user = $this->getUser(['email' => $email]);
        // Check For The Email
        if (! $user) {
            // This Means Email Is Not Found!
            ErrorBag::setError('email', 'This Email Does Not Exist!');
        } else {
            // Update Password, Redirect To Login Page.
            $this->update('password = ' .  password_hash($newPassword, PASSWORD_BCRYPT), ['email' => $email]);
            redirect("/login");
        }

        if (!empty(ErrorBag::errors())) {
            return view("Password/update", [
                'errors' => ErrorBag::errors()
            ]);
        }
    }
}