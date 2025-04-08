<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class DashboardController extends BaseController
{
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $employeeId = session()->get('employee_id');
        $employee = $this->employeeModel->find($employeeId);

        $data = [
            'employee' => $employee,
            'page_title' => 'Dashboard',
        ];

        return view('dashboard', $data);
    }

    public function profile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $employeeId = session()->get('employee_id');
        $employee = $this->employeeModel->find($employeeId);

        $data = [
            'employee' => $employee,
            'page_title' => 'My Profile',
        ];

        return view('profile', $data);
    }

    public function updateProfile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $employeeId = session()->get('employee_id');

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'first_name' => 'required|min_length[2]|max_length[255]',
                'last_name' => 'required|min_length[2]|max_length[255]',
                'phone' => 'required|min_length[10]',
                'address' => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('validation', $this->validator);
            }

            $updateData = [
                'first_name' => $this->request->getVar('first_name'),
                'last_name' => $this->request->getVar('last_name'),
                'phone' => $this->request->getVar('phone'),
                'address' => $this->request->getVar('address'),
            ];

            $this->employeeModel->update($employeeId, $updateData);
            session()->setFlashdata('success', 'Profile updated successfully.');

            // Update session name
            $newName = $updateData['first_name'] . ' ' . $updateData['last_name'];
            session()->set('employee_name', $newName);

            return redirect()->to('/dashboard/profile');
        }

        return redirect()->to('/dashboard/profile');
    }

    public function changePassword()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'page_title' => 'Change Password',
        ];
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'current_password' => 'required',
                'new_password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[new_password]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('validation', $this->validator);
            }

            $employeeId = session()->get('employee_id');
            $employee = $this->employeeModel->find($employeeId);

            $currentPassword = $this->request->getVar('current_password');
            $newPassword = $this->request->getVar('new_password');

            if (password_verify($currentPassword, $employee['password'])) {
                $this->employeeModel->update($employeeId, [
                    'password' => password_hash($newPassword, PASSWORD_DEFAULT)
                ]);

                session()->setFlashdata('success', 'Password changed successfully.');
                return redirect()->to('/dashboard');
            } else {
                session()->setFlashdata('error', 'Current password is incorrect.');
            }
        }

        return view('change_password', $data);
    }
}
