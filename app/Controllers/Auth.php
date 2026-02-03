<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required',
                'password' => 'required',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $this->userModel->verifyLogin($username, $password);

            if ($user) {
                $sessionData = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'avatar' => $user['avatar'],
                    'isLoggedIn' => true,
                ];

                session()->set($sessionData);
                return redirect()->to('/dashboard')->with('success', 'Selamat datang, ' . $user['name'] . '!');
            }

            return redirect()->back()->withInput()->with('error', 'Username atau password salah');
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Anda berhasil logout');
    }
}
