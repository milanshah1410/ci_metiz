<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table  = 'employee_master';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'employee_code',
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'password',
        'address',
        'country',
        'state',
        'city',
        'zip'
    ];
}
