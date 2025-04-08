<?php

namespace App\Models;

use CodeIgniter\Model;

class NonWorkingDayModel extends Model
{
    protected $table = 'nonworkingday';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date'];
    
    // Get all non-working days between two dates
    public function getDatesBetween($startDate, $endDate)
    {
        return $this->where('date >=', $startDate)
                    ->where('date <=', $endDate)
                    ->findAll();
    }
}