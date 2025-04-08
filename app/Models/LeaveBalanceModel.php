<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaveBalanceModel extends Model
{
    protected $table = 'leavebalance';
    protected $primaryKey = 'id';
    protected $allowedFields = ['leavetype', 'employeecode', 'leavebalance', 'creadeted_DateTime'];
    protected $useTimestamps = false;

    /**
     * Get current leave balance for an employee and leave type
     */
    public function getCurrentBalance($employeeCode, $leaveTypeId)
    {
        $balance = $this->where('employeecode', $employeeCode)
            ->where('leavetype', $leaveTypeId)
            ->orderBy('id', 'DESC')
            ->first();

        return $balance ? $balance['leavebalance'] : 0;
    }

    /**
     * Update leave balance for an employee
     */
    public function updateBalance($employeeCode, $leaveTypeId, $newBalance)
    {
        $data = [
            'employeecode' => $employeeCode,
            'leavetype' => $leaveTypeId,
            'leavebalance' => $newBalance,
            'creadeted_DateTime' => date('Y-m-d H:i:s')
        ];

        return $this->insert($data);
    }

    /**
     * Update the most recent leave balance record for an employee
     */
    public function updateLatestBalance($employeeCode, $leaveTypeId, $newBalance)
    {
        // Find the latest record ID
        $latestRecord = $this->where('employeecode', $employeeCode)
            ->where('leavetype', $leaveTypeId)
            ->orderBy('id', 'DESC')
            ->first();

        if ($latestRecord) {
            // Update the existing record
            return $this->update($latestRecord['id'], [
                'leavebalance' => $newBalance,
                'creadeted_DateTime' => date('Y-m-d H:i:s')
            ]);
        } else {
            // No record exists, create a new one
            return $this->insert([
                'employeecode' => $employeeCode,
                'leavetype' => $leaveTypeId,
                'leavebalance' => $newBalance,
                'creadeted_DateTime' => date('Y-m-d H:i:s')
            ]);
        }
    }
    /**
     * Get balance summary for graphs
     */
    public function getBalanceSummary($employeeCode)
    {
        $db = \Config\Database::connect();

        // Get total allocated leaves
        $query = $db->query("
            SELECT lm.id, lm.leaveType, 
                COALESCE(
                    (SELECT SUM(lb.leavebalance) 
                    FROM ci_leavebalance lb 
                    WHERE lb.leavetype = lm.id AND lb.employeecode = '{$employeeCode}' 
                    ORDER BY lb.id LIMIT 1), 0
                ) as total_allocated,
                COALESCE(
                    (SELECT SUM(el.numberofDays) 
                    FROM ci_employee_leave_master el 
                    WHERE el.leavetype = lm.id AND el.employee_code = '{$employeeCode}'), 0
                ) as total_used,
                COALESCE(
                    (SELECT lb.leavebalance 
                    FROM ci_leavebalance lb 
                    WHERE lb.leavetype = lm.id AND lb.employeecode = '{$employeeCode}' 
                    ORDER BY lb.id DESC LIMIT 1), 0
                ) as current_balance
            FROM ci_leavemaster lm
        ");

        return $query->getResult();
    }
}
