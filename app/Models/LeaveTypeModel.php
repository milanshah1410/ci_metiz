<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaveTypeModel extends Model
{
    protected $table = 'leavemaster';
    protected $primaryKey = 'id';
    protected $allowedFields = ['leaveType'];
    protected $useTimestamps = false;
    
    /**
     * Get all leave types with current balance for an employee
     */
    public function getLeaveTypesWithBalance($employeeCode)
    {
        $db = \Config\Database::connect();
        
        $query = $db->query("
            SELECT lm.*, 
                COALESCE(
                    (SELECT lb.leavebalance 
                    FROM ci_leavebalance lb 
                    WHERE lb.leavetype = lm.id AND lb.employeecode = '{$employeeCode}' 
                    ORDER BY lb.id DESC LIMIT 1), 0
                ) as current_balance
            FROM ci_leavemaster lm
            ORDER BY lm.leaveType
        ");
        
        return $query->getResult();
    }
}