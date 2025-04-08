<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeLeaveModel extends Model
{
    protected $table = 'employee_leave_master';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'employee_code',
        'leavetype',
        'fromdate',
        'todate',
        'numberofDays',
        'comment'
    ];

    const STATUS_PENDING  = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;


    /**
     * Get all leave records for an employee
     */
    public function getEmployeeLeaves($employeeCode)
    {
        return $this->select('employee_leave_master.*, leavemaster.leaveType')
            ->join('leavemaster', 'leavemaster.id = employee_leave_master.leavetype')
            ->where('employee_code', $employeeCode)
            ->orderBy('fromdate', 'DESC')
            ->findAll();
    }
    
    /**
     * Get total leave days for an employee
     */
    public function getTotalLeaveDays($employeeCode)
    {
        return $this->selectSum('numberofDays')
            ->where('employee_code', $employeeCode)
            ->get()
            ->getRow()
            ->numberofDays ?? 0;
    }
}
