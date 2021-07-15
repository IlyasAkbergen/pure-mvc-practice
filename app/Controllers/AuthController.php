<?php

namespace App\Controllers;

use App\Models\User;
use App\Router;
use App\Utility\Auth;
use App\Utility\Hash;
use App\Utility\Session;
use Rakit\Validation\ErrorBag;
use Rakit\Validation\Validator;

class AuthController extends BaseController
{
    public function login()
    {
        if (Auth::isAuthenticated()) {
            return Router::redirect('tasks.index');
        }
        $this->view('auth/login');
    }

    public function authenticate()
    {
        $input = $this->validateInput();

        $user = User
            ::where(User::FIELD_USERNAME, $input['username'])
            ->first()
        ;

        $errors = [];

        if (!$user) {
            $errors['username'] = [
                'required' => 'Username not found',
            ];
        }

        if ($user && $user->{User::FIELD_PASSWORD} !== Hash::generate($input['password'])) {
            $errors['password'] = [
                'required' => 'Wrong password',
            ];
        }

        if (!empty($errors)) {
            $this->view(
                'auth/login',
                [
                    'input'  => $input,
                    'errors' => new ErrorBag($errors),
                ]
            );
            return;
        }

        Session::put('user', $user->id);

        return Router::redirect('tasks.index');
    }

    public function logout()
    {
        Session::destroy();
        return Router::redirect('tasks.index');
    }

    private function validateInput()
    {
        $input = $this->requestParams
            ->only(
                [
                    User::FIELD_USERNAME,
                    User::FIELD_PASSWORD,
                ]
            )
            ->toArray()
        ;

        $validation = (new Validator())
            ->make(
                $input,
                [
                    'username' => 'required|max:255',
                    'password' => 'required',
                ]
            )
        ;

        $validation->validate();

        if ($validation->fails()) {
            $errors = $validation->errors();
            $this->view(
                'auth/login',
                [
                    'input'  => $input,
                    'errors' => $errors,
                ]
            );
            exit;
        }

        return $input;
    }
}