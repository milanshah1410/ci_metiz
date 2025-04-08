<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class AuthController extends BaseController
{
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        return redirect()->to('/auth/login');
    }

    public function login()
    {
        $data = [];
        if ($this->request->getMethod() == 'POST') {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $employee = $this->employeeModel->where('username', $username)
                ->orWhere('email', $username)
                ->first();
            if ($employee && password_verify($password, $employee['password'])) {
                $sessionData = [
                    'employee_id' => $employee['id'],
                    'employee_code' => $employee['employee_code'],
                    'employee_name' => $employee['first_name'] . ' ' . $employee['last_name'],
                    'employee_email' => $employee['email'],
                    'logged_in' => TRUE,
                ];

                session()->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                session()->setFlashdata('error', 'Invalid username/email or password.');
            }
        }

        return view('auth/login', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
