<?php

namespace App\Models;

use CodeIgniter\Model;

class CountryModel extends Model
{
    protected $table = 'country';
    protected $allowedFields = ['name'];
}
