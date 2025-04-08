<?php

namespace App\Models;

use CodeIgniter\Model;

class StateModel extends Model
{
    protected $table = 'state';
    protected $allowedFields = ['country_id', 'name'];
}
